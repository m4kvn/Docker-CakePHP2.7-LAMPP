<?php
/*
 * @author 斉藤篤史
*/
class Venue extends AppModel{
	//モデル名
	public $name = 'Venue';
	public $order = array('priority'=>'ASC','id'=>'ASC');
	
	//Eventモデルとのアソシエーション
	public $hasMany = 'Event';
	public $validate = array(
			'venue_name' => array(
					array(
							'rule' => 'isUnique',
							'message' => 'その名前は既に使われています',
							'allowEmpty' => true
					),
			),
			'address' => array(
					array(
							'rule' => 'notEmpty',
							'message' => 'キーワードを入力して下さい',
					),
			),
			'priority' => array(
					array(
							'rule' => array('comparison', 'is greater', 0),
							'message' => '0より大きい半角数字を入力してください',
					),
			),
	);
}