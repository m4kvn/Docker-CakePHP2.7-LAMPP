<?php
App::uses('AppController', 'Controller');

class EventImagesController extends AppController {
	public $name = 'EventImages';
	public $uses = array('Event', 'Venue', 'Host', 'Tag', 'Eventdate','EventImage');
	//検索用の変数準備
	public $components = array('Search.Prg','Auth');
	public $presetVars = true;
	public $paginate = array();

	//使用するヘルパー
	public $helpers = array('UploadPack.Upload');

	public function beforeFilter(){
		$this->Auth->authError='ログインが必要です';
		$this->Auth->allow('index');
		$this->Auth->allow('poster');
		$this->dataSender();
	}

	public function index(){
		$this->set("title_for_layout", "ポスター一覧 - HakoEve" );
		$this->loadModel('Eventdate');
		$list = $this->Eventdate->getEventIdListAfterToday();
		$list = $this->EventImage->findEventImageList($list);
		$list = array_unique($list);
		$eventList = $this->Event->findByEventIdList($list);

		foreach($eventList as $key =>$row)
			$date[$key] = $row['Event']["id"];
		array_multisort($date,SORT_DESC,$eventList);

		$this->set('eventList', $eventList);

		$ImageList = array();
		for($i = 0; $i < count($eventList); $i++){
			$arr = $this->EventImage->find('first',array('conditions' => array('event_id' => $eventList[$i]['Event']['id'])));
			if(($arr['EventImage']['img_file_name']) != "") array_push($ImageList, $arr);
		}
		$this->set('imageList', $ImageList);
		$this->set('eventNum', count($ImageList));
	}

	private function dataSender(){
		App::import('Controller', 'Venues');
		$venue = new VenuesController();
		$this->set('venue' , $venue->data());

		App::import( 'Controller','Tags');
		$tags = new TagsController();
		$this->set('select1',$tags->data());
	}

	/*
	 *@auther　諸原
	*ポスター詳細表示用
	*/
	public function poster($id = null) {
		if (!$this->Event->exists($id))
			throw new NotFoundException('不正なイベントです。');
		$this->autoLayout = false;
		//詳細表示するイベント情報セット
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$event = $this->Event->findByEventId($options);
		$event['Event'] = $this->Event->addMarkFlag($event['Event']);
		$this->set('Event', $event);

		//推薦するイベント情報セット
		$this->loadModel('Tag');
		$this->loadModel('Eventdate');
		$this->loadModel('EventsTag');

		$eventList = $this->Eventdate->getEventIdListAfterToday();
		$eventList = $this->EventImage->isImage($eventList);
		if(count($eventList) == 0){
			$this->set('recommend',array());
			return;
		}
		if(count($eventList) == 1){
			foreach ($eventList as $value) {
				if($value == $id){
					$this->set('recommend',array());
					return;
				}
			}
		}

		$tagScore = $this->EventsTag->getRecommendScore($id,$eventList);
		$hostScore = $this->Event->getHostScore($id,$event['Event']['host_id'],$eventList);
		$dateScore = $this->Eventdate->getDateScore($id,$eventList);

		$score = $tagScore;
		foreach ($hostScore as $key => $value)
			$score[$key] += $value;
		foreach ($dateScore as $key => $value)
			$score[$key] += $value;

		$sortedIdList = array_flip($score);
		ksort($sortedIdList);

		foreach ($sortedIdList as $key => $value)
			$sortedIdList[$key] = array();
		foreach ($score as $key => $value)
			array_push($sortedIdList[$value],$key);

		$recoIdList = array();
		$pop = array_pop($sortedIdList);
		while( $pop !== NULL && count($recoIdList) != 3){
			shuffle($pop);
			$p = array_pop($pop);
			while($p !== NULL && count($recoIdList) != 3) {
				array_push($recoIdList,$p);
				$p = array_pop($pop);
			}
			$pop = array_pop($sortedIdList);
		}

		$recommend = array();
		foreach ($recoIdList as $value)
			array_push($recommend,$this->Event->find('first',array('conditions'=>array('Event.id'=>$value))));

		foreach ($recommend as $key => $value)
			$recommend[$key]['Event'] = $this->Event->addMarkFlag($value['Event']);
		$this->set('recommend',$recommend);

		$options = array('conditions' => array('event_id' => $id));
  		$Image = $this->EventImage->find('first',$options);
  		$this->set('Image', $Image);

		$image = array();
 		for($i = 0; $i < count($recommend); $i++){
			$options = array('conditions' => array('event_id' => $recommend[$i]['Event']['id']));
 			$arr = $this->EventImage->find('first',$options);
 			array_push($image, $arr);
 		}
 		$this->set('ReccoImage', $image);
	}
}
?>