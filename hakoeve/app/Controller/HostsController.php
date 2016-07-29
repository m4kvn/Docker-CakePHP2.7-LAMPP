<?php

App::uses('AppController', 'Controller');

class HostsController extends AppController {

	//コントローラ名		
	public $name = 'Hosts';
	public $components = array('Auth');

	public function beforeFilter(){
		$this->Auth->authError='ログインが必要です';
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
	 * 主催者一覧のメソッド
	 */
	public function index(){
		//主催者情報が使われているかどうかの処理
		$this->loadModel('Event');
		$eventHostList = $this->Event->getUsingHostId();
		$data = $this->Host->find('all',array('recursive'=>0));
		$data2 = array();
		foreach ($data as $value){
			if(array_search($value['Host']['id'],$eventHostList)){
				$value['Host'] += array('delete_flag'=>false);
				array_push($data2,$value);
			}else{
				$value['Host'] += array('delete_flag'=>true);
				array_push($data2,$value);
			}
		}
		$this->set('data', $data2);
		$this->set("title_for_layout", "主催者管理 - HakoEve" );
	}

	/*	
	addメソッド
	新規主催者登録用メソッド
	書いた人：菅野
	*/
	public function add() {
		//ポストだった場合のみ処理
		if ($this->request->is('post')) {
			$this->Host->create();
			if ($this->Host->save($this->request->data)) {
				$this->Session->setFlash('主催者が保存されました。');
				$this->redirect('index');
			} else {
				$this->Session->setFlash('主催者が保存できませんでした');
			} 
		}
		$this->set("title_for_layout", "主催者追加 - HakoEve" );
	}
	
	/*
	 * @author 斉藤篤史、齋藤創
	* 主催者削除メソッド
	*/
	public function delete($id = null){
		if($id == null){
			$this->Session->setFlash('主催者が削除できませんでした');
			$this->redirect(array('action'=>'index'));
			return;
		}
		$this->Host->id = $id;
		$this->loadModel('Event');
		$result = array('result' => $id);
		$re = array_intersect($result,$this->Event->getUsingHostId());
		if(count($re) == 0){
			if($this->Host->delete($this->data['Host']['id'])){
				$this->Session->setFlash('主催者が削除されました');
			}else $this->Session->setFlash('主催者が削除できませんでした');
		}else $this->Session->setFlash('主催者が削除できませんでした');

		$this->redirect(array('action'=>'index'));
	}
	
	/*
	 *@auther　斉藤篤史
	　*主催者情報編集メソッド
	　*/
	public function edit($id = null) {
		if (!$this->Host->exists($id)) {
			throw new NotFoundException('不正なイベントです。');
		}
		//ポストかプットだったら
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data['Host'] += array('id'=>$id);
			if ($this->Host->save($data)) {
				$this->Session->setFlash('主催者情報が変更されました。');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('主催者情報を変更できませんでした。');
			}
		}
		
		$options = array('conditions' => array('Host.' . $this->Host->primaryKey => $id));
		$this->request->data = $this->Host->find('first', $options);
		$this->set("title_for_layout", $this->request->data['Host']['host_name'] . "編集 - HakoEve" );
	}
	
	/*
	 *@auther　斉藤篤史
	　*主催者情報編集確認用メソッド
	　*/
	public function view($id = null) {
		if (!$this->Host->exists($id)) {
			throw new NotFoundException('不正なイベントです。');
		}
		//詳細表示する主催者情報セット
		$options = array('conditions' => array('Host.' . $this->Host->primaryKey => $id));
		$host = $this->Host->find('first', $options);
		$this->set('host', $host);
	}
	
	public function dataSender(){
 		App::import('Controller', 'Venues');
 		$venue = new VenuesController();
 		$this->set('venue' , $venue->data());
 	
 		App::import( 'Controller','Tags');
 		$tags = new TagsController();
 		$this->set('select1',$tags->data());
 	}
}
