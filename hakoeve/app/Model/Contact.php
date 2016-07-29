<?php
class Contact extends AppModel{
	public $useTable = false;
	
	public function sameCheck($value, $field_name){
		if($this->data[$this->name]['ReMailAddress'] === $this->data[$this->name][$field_name]){
			return true;
		}
		return false;
	}
	
	public $validate = array(
		'Name' => array(
			array('rule' => 'notEmpty', 'message' => '名前が入力されていません')
		),
		'MailAddress' => array(
			'email' => array('rule' => 'email', 'message' => 'メールアドレスを正しく入力してください'),
			'notEmpty' => array('rule' => 'notEmpty', 'message' => 'メールアドレスを入力してください')
		),
		'ReMailAddress' => array(
			'email' => array('rule' => 'email', 'message' => 'メールアドレスを正しく入力してください'),
			'notEmpty' => array('rule' => 'notEmpty', 'message' => '確認用メールアドレスを入力してください'),
			'same' => array('rule' => array('sameCheck', 'MailAddress'), 'message' => 'メールアドレスが一致しません')
		),
		'Title' => array(
			array('rule' => 'notEmpty', 'message' => 'お問い合わせ件名が入力されていません')
		),
		'Context' => array(
			array('rule' => 'notEmpty', 'message' => 'お問い合わせ内容が入力されていません')
		),
		'EventTitle' => array(
			array('rule' => 'notEmpty', 'message' => 'イベント名が入力されていません')
		),
		'DeteTime' => array(
			array('rule' => 'notEmpty', 'message' => '開催日時が入力されていません')
		),
		'Venue' => array(
			array('rule' => 'notEmpty', 'message' => '開催場所が入力されていません')
		),
		'Host' => array(
			array('rule' => 'notEmpty', 'message' => '主催者情報が入力されていません')
		),
		'Detail' => array(
			array('rule' => 'notEmpty', 'message' => 'イベント詳細が入力されていません')
		)
	);

}

?>