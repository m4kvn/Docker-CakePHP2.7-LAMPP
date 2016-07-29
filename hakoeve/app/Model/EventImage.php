<?php
class EventImage extends AppModel{
	public $name = 'EventImage';
	public $actsAs = array(
			'UploadPack.Upload' => array(
					'img' => array(),
					'img2' => array(),
					'img3' => array()
				)
	);
	public $validate = array(
		'name' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'その画像名は既に使われています'
            ),
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => '画像名は半角英数字のみ利用できます'
            )
		)
		
	);

//	public function findEventImageList(){
//		$eventIdList = $this->find('list',array('fields' => array('event_id')));
//		return $eventIdList;
//	}
	
	public function findEventImageList($list){
		$eventIdList = array();
		$event = array();
		foreach ($list as $key => $event_id) {
			if(($event = $this->find('list',array('fields' => array('event_id'), 'conditions' => array('event_id' => $event_id)) )))
				$eventIdList += $event;
		}
		return $eventIdList;
	}

	public function isImage($eventIdList){
		$IDList = array();
		foreach ($eventIdList as $eventid) {
			$eventImage = $this->find("first", array('conditions' => array("event_id" => $eventid)));
			if($eventImage != array()){
				array_push($IDList, $eventid);
			}
		}
		return $IDList;
	}
}