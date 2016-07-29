<?php

 class VenuesController extends AppController{

 	//コントローラ名
 	public $name = "Venues";
	public $uses = array('Event', 'Venue', 'Host', 'Tag', 'Eventdate','EventImage');
 	//コンポーネント読み込み
 	public $components = array('Geocoder','Auth');
	//使用するヘルパー
 	public $helpers = array('UploadPack.Upload');

	public function beforeFilter(){
		$this->Auth->authError='ログインが必要です';
		$this->Auth->allow('search');
	//	$this->Auth->allow('index');
	//	$this->Auth->allow('add');$this->Auth->allow('edit');
		

		$this->dataSender();
	}

 	public function beforeRender(){
		$this->loadModel('Event');
		$allEventList = $this->Event->find('all');
		$this->set('allEventList',$allEventList);
	}

 	/*
 	 * @author 斉藤篤史、齋藤創
 	 * 開催場所を一覧するメソッド
 	 */
 	public function index(){
		$this->set("title_for_layout", "開催場所管理 - HakoEve" );
 		//場所情報が使われているかどうかの処理
 		$this->loadModel('Event');
 		$eventVenueList = $this->Event->getUsingVenueId();
 		$data = $this->Venue->find('all',array('recursive'=>0));
 		$data2 = array();
 		foreach ($data as $value){
 			if(array_search($value['Venue']['id'],$eventVenueList)){
 				$value['Venue'] += array('delete_flag'=>false);
 				array_push($data2,$value);
 			}else{
 				$value['Venue'] += array('delete_flag'=>true);
 				array_push($data2,$value);
 			}
 		}
 		$this->set('data', $data2);
 	}

 	/*
 	 *@author 菅野久樹
 	 *場所地図検索メソッド
 	 *
 	*/
 	public function search(){
	//	$this->Prg->commonProcess();
		$this->set("title_for_layout", "開催場所検索 - HakoEve" );
		
		$this->loadModel('Eventdate');
		$this->loadModel('Event');
		$list = $this->Eventdate->SakabeGetEventIdListAfterToday();
		$list = array_unique($list);

		$eventList = $this->Event->findByEventIdList($list);
		foreach($eventList as $key =>$row)
			$date[$key] = $row['Event']["id"];
		array_multisort($date,SORT_DESC,$eventList);

		$id = $this->request->query['id'];
		$checkedEventList = array();
		for($i = 0; $i < count($eventList); $i++){
			if($eventList[$i]['Event']['visible'] != 0 && $eventList[$i]['Event']['venue_id'] == $id){
				array_push($checkedEventList, $eventList[$i]);
			}}
		$listId = $this->params['url']['page'];echo $listId;
		if($listId == null){ $listId = 1;}
		$displayNum = 20; /*一画面あたりの表示イベント数*/

		$eventNum = $listId * $displayNum;
		$eventListForList = array(); /*View送信用の変数*/

		if($displayNum * $listId < count($checkedEventList)){
			for($i = $displayNum * ($listId - 1); $i < $eventNum ;$i++){
				array_push($eventListForList, $checkedEventList[$i]);
			}
		}else{
			for($i = $displayNum * ($listId - 1); $i < count($checkedEventList) ;$i++){
				array_push($eventListForList, $checkedEventList[$i]);
			}
		}

		$this->set('eventNum',count($checkedEventList));
		$this->set('eventList', $eventListForList);
		$this->set('id', $listId);
		if(!count($eventListForList)){
			$options = array('fields' => array('venue_name') ,'conditions' => array('id' => $id));
			$this->set('venueName', $this->Venue->find('first', $options));
		}

		$image = array();
 		for($i = 0; $i < count($eventListForList); $i++){
			$options = array('conditions' => array('event_id' => $eventListForList[$i]['Event']['id']));
 			$arr = $this->EventImage->find('first',$options);
 			array_push($image, $arr);
 		}
 		$this->set('image', $image);
 	}

	public function data(){
		//EventDateモデルから今日以降のイベントIDのリスト取得
		$this->loadModel('Eventdate');
		$list = $this->Eventdate->getEventIdListAfterToday();

		//イベントIDのリストの長さによって分岐
		if(count($list) == 1 )
			$this->Venue->hasMany['Event']['conditions'] = 'Event.id =' . current($list);
		else if( count($list) >= 2 )
			$this->Venue->hasMany['Event']['conditions'] = array('Event.id IN' => $list);
		else if(count($list) == 0){
			$result = array();
			$this->set('result',$result);
			$this->render('/Elements/venue');
			return;
		}

		//EventIDのリストを使ってVenueモデルから検索
		$result = $this->Venue->find('all',array('recursive'=>2,'order'=>array('priority'=>'asc')));

		//イベントが無い場所情報は配列からまるまる削除
		$deletelist = array();
		for($i=0 ;$i < count($result) ; $i++) {
			if($result[$i]['Event'] == array())
				array_push($deletelist,$i);
		}
		foreach ($deletelist as $value) {
			unset($result[$value]);
		}

		$this->loadModel('Event');

		foreach ($result as $key => $value) {
			foreach ($value['Event'] as $k => $v) {
				$result[$key]['Event'][$k] = $this->Event->addMarkFlag($v);
			}
		}
		//結果セット
		$this->set('result',$result);
		return $result;

	}

 	/*
 	 * @author 斉藤篤史、齋藤創
 	 * 場所登録用メソッド。
 	 * 入力した住所から緯度と経度も取得できる。
 	 * 取得のためにGeocoderコンポーネントを使用。Geocoderはapp/Controller/Component/GeocoderComponent.php にある。
 	 * コンポーネント使用の参考サイト：https://github.com/mcloide/CakePHP-Geocoder-Component
 	 */
 	public function add(){
		$this->set("title_for_layout", "開催場所追加 - HakoEve" );
 		if(!empty($this->data)){
 			if($this->Venue->save($this->data)){
 				$addr = $this->data['Venue']['address'];
 				$this->Geocoder->address = $addr;
 				$this->Geocoder->geocode();

 				$this->Venue->saveField('latitude',$this->Geocoder->latitude);
 				$this->Venue->saveField('longitude',$this->Geocoder->longitude);
 				$this->Session->setFlash('開催場所情報が保存されました');

 				$this->redirect('index');
 			} else
 			$this->Session->setFlash('開催場所情報が保存できませんでした');
 		}
 	}

 	/*
 	 * @author 斉藤篤史、齋藤創
 	 * 場所削除用メソッド
 	 */
 	public function delete($id = null){
 		if($id == null){
 			$this->Session->setFlash('場所が削除できませんでした');
 			$this->redirect(array('action'=>'index'));
 			return;
 		}

 		$this->Venue->id = $id;
 		$this->loadModel('Event');
 		$event = $this->Event->find('all');
 		$result = array('result' => $id);
 		$re = array_intersect($result,$this->Event->getUsingVenueId());
 		if(count($re) == 0){
 			if($this->Venue->delete($this->data))
 				$this->Session->setFlash('場所が削除されました');
 			else $this->Session->setFlash('場所が削除できませんでした');
 		}else $this->Session->setFlash('場所が削除できませんでした');

 		$this->redirect(array('action'=>'index'));
 	}

 	/*
 	 *@auther　斉藤篤史
 	　*開催場所情報編集メソッド
 	　*/
 	public function edit($id = null) {
 		if (!$this->Venue->exists($id)) {
 			throw new NotFoundException('不正なイベントです。');
 		}
 		//ポストかプットだったら
 		if ($this->request->is('post') || $this->request->is('put')) {
 			$data = $this->request->data;
 			$this->Venue->id = $id;
 			if ($this->Venue->save($data)) {
 				$this->Session->setFlash('開催場所情報が変更されました。');
 				$this->redirect(array('action' => 'index'));
 			} else {
 				$this->Session->setFlash('開催場所情報を変更できませんでした。');
 			}
 		}

 		$options = array('conditions' => array('Venue.' . $this->Venue->primaryKey => $id));
 		$this->request->data = $this->Venue->find('first', $options);
		$this->set("title_for_layout", $this->request->data['Venue']['venue_name'] . "編集 - HakoEve" );
 	}

	private function dataSender(){
 		$this->set('venue' , $this->data());

 		App::import( 'Controller','Tags');
 		$tags = new TagsController();
 		$this->set('select1',$tags->data());

 	}
 }