<?php
App::uses('AppModel', 'Model');
class Tag extends AppModel {
	//モデル名
	public $name = 'Tag';
	public $order = array('priority'=>'ASC','id'=>'ASC');
	public $validate = array(
			'tag_name' => array(
					array(
							'rule' => 'isUnique',
							'message' => 'そのタグ名は既に使われています',
					),
				),
			'priority' => array(
					array(
							'rule' => 'notEmpty',
							'message' => '0より大きい半角数字を入力して下さい',
					),
					array(
							'rule' => 'numeric',
							'required' => true,
							'message' => '0より大きい半角数字を入力して下さい',
					),
					array(
							'rule' => array('comparison', '>',0),
							'required' => true,
							'message' => '0より大きい半角数字を入力して下さい',
					),
				),
	);
	public $hasAndBelongsToMany = array(
		'Event' =>
            array(
                'className'              => 'Event',
                'joinTable'              => 'Events_tags',
                'foreignKey'             => 'tag_id',
                'associationForeignKey'  => 'event_id',
                'unique'                 => false,
                'with'                   => 'EventsTag',
                'conditions'             => '',
                'fields'                 => '',
                'order'                  => '',
                'limit'                  => '',
                'offset'                 => '',
                'finderQuery'            => '',
                'deleteQuery'            => '',
                'insertQuery'            => ''
            )
    );
}