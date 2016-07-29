<?php
App::uses('AppModel', 'Model');

class Past extends AppModel{
	//モデル名
	public $name = 'Past';	
	//Venueモデルとのアソシエーション
	public $belongsTo = array(
		'Venue' => array(),
		'Host' => array()
		);

	public $hasMany = array(
        'Eventdate' => array(
            'className'     => 'Eventdate',
            'foreignKey'    => 'event_id',
            'conditions'    => '',
            'order'         => 'Eventdate.date ASC',
            'limit'         => '',
            'dependent'     => true
        )
    );
	public $hasAndBelongsToMany = array(
		'Tag' =>
            array(
                'className'              => 'Tag',
                'joinTable'              => 'Events_tags',
                'foreignKey'             => 'event_id',
                'associationForeignKey'  => 'tag_id',
                'unique'                 => true,
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
    
    public function findByEventIdList($idList){
		if($idList == null) return null;
		$this->hasMany['Eventdate']['order'] = array('Eventdate.date' => 'ASC');
		$conditions = $this->getIdListInCondition($idList);
		return $this->find('all',array('conditions' => array($conditions, 'Past.visible !=' => 0)));
	}
    
    public function getIdListInCondition($idList){
		if(count($idList) == 0){
			return '';
		}else if(count($idList) == 1 ){
			return array('Past.id = '=> current($idList));
		}else{
			return array('Past.id IN' => $idList );
		}
	}
    
    public function findByEventIdListSortedForSearchMonth($idList, $month){
		$month = strtotime($month);
		$month = date('Y-m-d', $month);
		$eventList = $this->findByEventIdList($idList);

		for($eventcount=0;$eventcount<count($eventList);$eventcount++){
			if(count($eventList[$eventcount]['Eventdate'])!=1){
				$datecount = count($eventList[$eventcount]['Eventdate']);
				$plusarray = $eventList[$eventcount];
				for($d=0;$d<$datecount;$d++){
					if($plusarray['Eventdate'][$d]['date']>=$month&&$plusarray['Eventdate'][$d]['date']<date('Y-m-d', strtotime("$month +1 month"))){
						$eventList[$eventcount]['Eventdate'] = $plusarray['Eventdate'][$d];
						$eventList[$eventcount]['Eventdate']= array($eventList[$eventcount]['Eventdate']);
						array_push($eventList,$eventList[$eventcount]);
					}
				}
				unset($eventList[$eventcount]);
			}
		}

		foreach($eventList as $key =>$row)
			$date[$key] = $row['Eventdate'][0]["date"];
		array_multisort($date,SORT_ASC,$eventList);
	//	print_r($eventList);
		return $eventList;
	}
}

?>