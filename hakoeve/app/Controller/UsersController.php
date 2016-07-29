<?php

class UsersController extends AppController{
	public $name = 'Users';
	public $components = array('Auth');

	public function passGenerate(){
		//ランダム文字列生成(文字コード利用)
		for($i=0,$str=null;$i<10;){
			$num=mt_rand(0x61,0x7A);//ASCII文字コード
			if((0x30<=$num&&$num<=0x39)||(0x41<=$num&&$num<=0x5A)||(0x61<=$num&&$num<=0x7A)){
				$str.= chr($num);//文字コードを文字に変換
				$i++;
			}
		}
		return $str;
	}

	public function beforeFilter(){
		$this->Auth->authError='ログインが必要です';
	//	$this->Auth->allow('add');$this->Auth->allow('changepass');
		$this->Auth->allow('forgot');
		$this->Auth->allow('logout');
		
		$this->dataSender();
	}

	public function login(){
		if($this->request->isPost()){
			if($this->Auth->login()){
				$this->updateSessionAuthUser();
				$this->Session->setFlash('ログインしました');
				$this->redirect('/events/manage');
				//$this->redirect($this->Auth->redirect());
			}else{
				$this->Session->setFlash('ユーザ名とパスワードが一致しませんでした');
			}
		}
		$this->set("title_for_layout", "ログイン - HakoEve" );
	}

	public function logout(){
		$this->Auth->logout();
		$this->set("title_for_layout", "ログアウト - HakoEve" );
	}

	public function add(){
		if(!empty($this->data)){
			if($this->data){
				$this->User->create();
				$user = array('User'=>array(
					'username'=>$this->data['User']['username'],
					'password'=>AuthComponent::password($this->data['User']['password'])));
				$this->User->save($user);
				$this->redirect('login');
			}
		}
		$this->set("title_for_layout", "ユーザー追加 - HakoEve" );
	}

	public function forgot(){
		if(!empty($this->data)){
			$userdata = $this->User->find('first',array('conditions'=>array('username'=>$this->data['User']['username'])));
			if($userdata!=null){
				$pass = $this->passGenerate();
				$this->User->id = $userdata['User']['id'];
				$this->User->saveField('password',AuthComponent::password($pass),false);
				$this->redirect(array('controller'=>'Email','action'=>'sendforgot',$userdata['User']['username'],$pass));
			}else $this->Session->setFlash('存在しないユーザネームです');
		}
		$this->set("title_for_layout", "パスワードを忘れた方はこちら - HakoEve" );
	}

	function changepass(){
		if($this->Auth->loggedin()){
			if($this->request->isPost()){
				$userdata = $this->User->find('first',array('conditions'=>array('id'=>$this->Auth->user('id'))));
				if(AuthComponent::password($this->request->data['Changepassword']['oldpassword']) == $userdata['User']['password']){
					if($this->request->data['Changepassword']['newpassword'] == $this->request->data['Changepassword']['newpassword2']){
						$this->User->id = $this->Auth->user('id');
						$this->User->saveField('password',AuthComponent::password($this->request->data['Changepassword']['newpassword']));
						$this->Session->setFlash('パスワードを変更しました。');
						$this->redirect('/events/manage');
					}else{

						$this->Session->setFlash('2つの新しいパスワードが一致しませんでした。');
					}
				}else{

					$this->Session->setFlash('変更前のパスワードが間違っています。');
				}
			}
			
		}
		$this->set("title_for_layout", "パスワードの変更 - HakoEve" );
		$this->updateSessionAuthUser();
	}

	function updateSessionAuthUser() {
		$this->loadModel('User'); // Userモデルを読み込んでいるなら消してもOK
		$user = $this->User->find('first', array('conditions' => array('id' => $this->Auth->user('id')), 'recursive' => -1));
		unset($user['User']['password']); // 念のためパスワードは除外。どうでもよければ消してもOK
		$this->Session->write('Auth', $user);
	}
	
	private function dataSender(){
		App::import('Controller', 'Venues');
		$venue = new VenuesController();
		$this->set('venue' , $venue->data());

		App::import( 'Controller','Tags');
		$tags = new TagsController();
		$this->set('select1',$tags->data());
	}
}