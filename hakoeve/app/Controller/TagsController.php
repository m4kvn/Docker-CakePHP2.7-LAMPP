<?php
App::uses('AppController', 'Controller');

class TagsController extends AppController {

	//コントローラ名		
	public $name = 'Tags';
	public $uses = array('Event', 'Venue', 'Host', 'Tag', 'Eventdate','EventImage');
	public $helpers = array('UploadPack.Upload');
	public $components = array('Auth');
	
	public function beforeFilter(){
		$this->Auth->authError='ログインが必要です';
		$this->Auth->allow('index');
	//	$this->Auth->allow('manage');
		$this->Auth->allow('search');
	//	$this->Auth->allow('manage');
	//	$this->Auth->allow('add');
		//$this->Auth->allow('delete');
	//	$this->Auth->allow('edit');
		$this->dataSender('');
	}

	public function beforeRender(){
		$this->loadModel('Event');
		$allEventList = $this->Event->find('all');
		$this->set('allEventList',$allEventList);
	}
	
	public function add() {
		//ポストだった場合のみ処理
		if ($this->request->is('post')) {
			$this->Tag->create();
			if ($this->Tag->save($this->request->data)) {
				$this->Session->setFlash('タグが保存されました。');
				$this->redirect('manage');
			} else {
				$this->Session->setFlash('タグが保存できませんでした');
			}
		}
		$this->set("title_for_layout", "タグ追加 - HakoEve" );
	}
	
	/*
	 * @author 斉藤篤史、齋藤創
	 * タグ削除メソッド
	 */
	public function delete($id = null){
		if($id == null){
			$this->Session->setFlash('タグが削除できませんでした');
			$this->redirect(array('action'=>'manage'));
			return;
		}
		$this->Tag->id = $id;
		$this->loadModel('EventsTag');
		$result = array('result' => $id);
		$re = array_intersect($result,$this->EventsTag->getUsingTagId());
		if(count($re) == 0){
			if($this->Tag->delete($this->data['Tag']['id'])){
				$this->Session->setFlash('タグが削除されました');
				$this->redirect(array('action'=>'manage'));
			}else $this->Session->setFlash('タグが削除できませんでした');
		}else $this->Session->setFlash('タグが削除できませんでした');

		$this->redirect(array('action'=>'manage'));
	}

	public function index(){
		$this->set( 'select1', $this->Tag->find( 'list', array('order'=>array('priority'=>"ASC"), 'fields' => array( 'id','tag_name'))));
	}

	public function data(){
		return $this->Tag->find( 'list', array('order'=>array('priority'=>"ASC"), 'fields' => array( 'id','tag_name')));
	}
	
	public function search($tagId = null){
		$this->set("title_for_layout", "ジャンル検索 - HakoEve" );
		$list = array();
		$this->loadModel('EventsTag');
		$this->loadModel('Eventdate');
		$this->loadModel('Event');
		$this->loadModel('Tag');
		$searchtag = array();

		if($tagId == null){
		if($this->request->is('get')){
			$list = $this->Event->find('list',array('fields'=>array('id')));
			$tagId = $this->params['url']['tagid'];
		}
		if($this->request->is('post')){
			$list = $this->Event->find('list',array('fields'=>array('id')));
			$tagId = $this->request->data['Tag']['radio1'];
		}
		}else{
			$list = $this->Event->find('list',array('fields'=>array('id')));
			$tagId = $this->params['url']['tagid'];
		//	$list = array_intersect($list,$this->EventsTag->find('list',array('fields'=>array('event_id'),'conditions'=>array('tag_id'=>$tagId))));
		//	array_push($searchtag,$this->Tag->find('first',array('conditions'=>array('id'=>$tagId),'recursive'=>0)));
		}
			if(isset($tagId[0])){
				foreach ($tagId as $id){
					$list = array_intersect($list,$this->EventsTag->find('list',array('fields'=>array('event_id'),'conditions'=>array('tag_id'=>$id))));
					array_push($searchtag,$this->Tag->find('first',array('conditions'=>array('id'=>$id),'recursive'=>0)));
				}
			}
		//}else{
		//	$list = $this->EventsTag->find('list',array('fields'=>array('event_id') ,'conditions'=>array('EventsTag.tag_id'=>$tagId)));
		//	array_push($searchtag,$this->Tag->find('first',array('conditions'=>array('id'=>$tagId),'recursive'=>0)));
		//}
		$list = array_unique($list);
		
		$aftertoday = $this->Eventdate->getEventIdListAfterToday();

		$result = $this->Event->findByEventIdList(array_intersect($list, $aftertoday));

		//if($result!=array()){
			foreach($result as $key =>$row)
				$date[$key] = $row['Eventdate'][0]["date"];
			array_multisort($date,SORT_ASC,$result);
		/*}else{
			$this->set('result',array());
			//$this->render('/Events/result');
			return;
		}*/
		
		foreach ($result as $key => $value) {
			$result[$key]['Event'] = $this->Event->addMarkFlag($value['Event']);
		}
		$this->set('allresult',count($result));
		$listId = $this->params['url']['id'];
		if($listId == null){ $listId = 1;}
		$displayNum = 20; /*一画面あたりの表示イベント数*/
		
		$eventNum = $listId * $displayNum;
		$eventListForResult = array(); /*View送信用の変数*/
		
		if($displayNum * $listId < count($result)){
			for($i = $displayNum * ($listId - 1); $i < $eventNum ;$i++){
				array_push($eventListForResult, $result[$i]);
			}
		}else{
			for($i = $displayNum * ($listId - 1); $i < count($result) ;$i++){
				array_push($eventListForResult, $result[$i]);
			}
		}
		
		$this->set('eventNum',count($result));
		$this->set('result',$eventListForResult);
		$this->set('id', $listId);
		$this->set('tagId', $tagId);
		$this->set('searchtag',$searchtag);
		//$this->set('tagsearch', "tagsearch");

		//$this->render('/Events/result');
		
		$image = array();
 		for($i = 0; $i < count($eventListForResult); $i++){
			$options = array('conditions' => array('event_id' => $eventListForResult[$i]['Event']['id']));
 			$arr = $this->EventImage->find('first',$options);
 			array_push($image, $arr);
 		}
 		$this->set('image', $image);
		
	}

	public function manage(){
		$this->set("title_for_layout", "タグ管理 - HakoEve" );
		$data = $this->Tag->find('all',array('recursive'=>0));
		$this->loadModel('EventsTag');
		$usingList = $this->EventsTag->getUsingTagId();
		$data2 = array();

		foreach ($data as $value) {
			if(array_search($value['Tag']['id'],$usingList))
 				$value['Tag'] += array('delete_flag'=>false);
 			else
 				$value['Tag'] += array('delete_flag'=>true);
			array_push($data2,$value);
		}
		$this->set('data',$data2);
	}
	
	public function edit($id = null) {
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException('不正なイベントです。');
		}
		//ポストかプットだったら
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data['Tag'] += array('id'=>$id);
			if ($this->Tag->save($data)) {
				$this->Session->setFlash('タグ情報が変更されました。');
				$this->redirect(array('action' => 'manage'));
			} else {
				$this->Session->setFlash('タグ情報を変更できませんでした。');
			}
		}
	
		$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
		$this->request->data = $this->Tag->find('first', $options);
		$this->set("title_for_layout", $this->request->data['Tag']['tag_name']. " 編集 - HakoEve" );
	}
	
	private function dataSender(){
		App::import('Controller', 'Venues');
		$venue = new VenuesController();
		$this->set('venue' , $venue->data());
			
		$this->set('select1',$this->data());
			
	}
}
?>