<?php
/*
 * @author 菅野
 */
class Host extends AppModel{
	//モデル名
	public $name = 'Host';	
	public $order = array('priority'=>'ASC','id'=>'ASC');
	
	//Eventモデルとのアソシエーション
	public $hasMany = 'Event';
	public $validate = array(
			'host_name' => array(
					array(
							'rule' => 'isUnique',
							'message' => 'その名前は既に使われています',
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