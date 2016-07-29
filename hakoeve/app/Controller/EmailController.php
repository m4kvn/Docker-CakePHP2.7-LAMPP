<?php
// app/Controller/EmailsController.phpに保存
App::uses('CakeEmail', 'Network/Email');

class EmailController extends AppController{
	public function sendforgot($username,$pass){
		$email = new CakeEmail('smtp');
		$res = $email->config(array('log' => 'emails'))
		->from(array('root@mail.hakoevehost.com' => 'HakoEve'))
		->to('b1011094@fun.ac.jp')
		->subject('【HakoEve】パスワードを再発行しました')
		->send('函館市地域交流まちづくりセンター様
				パスワードを再発行しました。
				ユーザネーム　'.$username.'
				パスワード '. $pass .'
				http://175.184.16.65/hakoeve/users/login
				にアクセスしてユーザネームとパスワードを入力し、ログインして下さい。
				ログイン後はパスワードを適宜変更するようお願いします。
				このメールアドレスは送信専用です。返信はできません。');
		$this->Session->setFlash('b1011094@fun.ac.jp宛にメールを送信しました。メールに記載されたユーザネームとパスワードでログインして下さい。');
		$this->redirect('/users/login');
	}
}
