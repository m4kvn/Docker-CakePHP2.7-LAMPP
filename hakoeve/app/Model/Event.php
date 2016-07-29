
<?php
App::uses('AppModel', 'Model');

class Event extends AppModel {
	//モデル名
	public $name = 'Event';
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

	public $actsAs = array(
		'Search.Searchable',
		'UploadPack.Upload' => array(
		'thumbnail' => array()
		));

	public $filterArgs = array(
			'keyword' => array('type' => 'query', 'method' => 'orConditions'),

	);

	public function orConditions( $data = array() ) {
		$filter = $data['keyword'];
		$cond = array(
				'OR' => array(
						$this->alias . '.event_name LIKE' => '%' . $filter . '%',
						$this->alias . '.report LIKE' => '%' . $filter . '%',
						$this->Host->alias . '.host_name LIKE' => '%' . $filter . '%',
						$this->Venue->alias . '.venue_name LIKE' => '%' . $filter . '%',
				),
		);
		return $cond;
	}

	public $validate = array(
			'event_name' => array(
					array(
							'rule' => 'notEmpty',
							'message' => 'キーワードを入力して下さい',
					),
			),
			'venue_id' => array(
					array(
							'rule' => 'notEmpty',
							'message' => '開催場所を選択してください',
					),
			),
			'host_id' => array(
					array(
							'rule' => 'notEmpty',
							'message' => '主催者を選択してください',
					),
			),
			'thumbnail' => array(
					'rule' => array('attachmentContentType', array('image/jpeg', 'image/gif', 'image/png')),
					'message' => 'jpg,gif,pngのみアップロードできます。'
			),
	);

	public function findByEventIdList($idList){
		if($idList == null) return null;
		$this->hasMany['Eventdate']['order'] = array('Eventdate.date' => 'ASC');
		$conditions = $this->getIdListInCondition($idList);
		return $this->find('all',array('conditions' => array($conditions, 'Event.visible !=' => 0)));
	}
	
	public function findByEventIdListformanage($idList){
		if($idList == null) return null;
		$this->hasMany['Eventdate']['order'] = array('Eventdate.date' => 'ASC');
		$conditions = $this->getIdListInCondition($idList);
		return $this->find('all',array('conditions' => $conditions));
	}
    
    public function findByEventIdListforCurrent($idList){
        if($idList == null) return null;
		$this->hasMany['Eventdate']['order'] = array('Eventdate.date' => 'ASC');
		$conditions = $this->getIdListInCondition($idList);
		return $this->find('all',array('conditions' => $conditions, 'limit' => 15));
    }
	
	public function findByEventId($id){
		return $this->find('first',$id);
	}

	public function findByEventIdListSortedForIndex($idList){
		$eventList = $this->findByEventIdList($idList);

		for($eventcount=0;$eventcount<count($eventList);$eventcount++){
			if(count($eventList[$eventcount]['Eventdate'])!=1){
				$datecount = count($eventList[$eventcount]['Eventdate']);
				$plusarray = $eventList[$eventcount];
				for($d=0;$d<$datecount;$d++){
					if($plusarray['Eventdate'][$d]['date']>=date('Y-m-d')){
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
		return $eventList;
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




	public function getHostScore($currentId,$hostId,$candidateIdList){
		$currentKey = array_search($currentId, $candidateIdList);
		if(! $currentKey === FALSE)
			unset($candidateIdList[$currentKey]);
		$idWithHost = $this->find('list',array('fields'=>array('id','host_id'),'recursive'=>0,'conditions'=>$this->getIdListInCondition($candidateIdList)));

		foreach ($idWithHost as $key => $value) {
			if($value == $hostId)
				$idWithHost[$key] = 30;
			else
				$idWithHost[$key] = 0;
		}
		return $idWithHost;
	}

	public function addMarkFlag($event){
		$created = new DateTime(date('Y-m-d H:m:s',strtotime($event['created'].'+ 5 day')));
		$updated = new DateTime(date('Y-m-d H:m:s',strtotime($event['updated'].'+ 5 day')));
		$today = new DateTime('now');

		if($created == $updated && $created >= $today)
			$event += array('markFlag' => 0); //新着マーク
		else if($updated >= $today)
			$event += array('markFlag' => 1); //更新マーク
		else $event += array('markFlag' => 2); //マーク表示なし

		return $event;
	}

	public function getUsingVenueId(){
		$list = $this->find('list',array('fields'=>array('venue_id'),'recursive'=>0));
		$list = array_unique($list);
		unset($list[array_search(null,$list)]);
		return $list;
	}

	public function getUsingHostId(){
		$list = $this->find('list',array('fields'=>array('host_id'),'recursive'=>0));
		$list = array_unique($list);
		unset($list[array_search(null,$list)]);
		return $list;
	}

	public function getIdListInCondition($idList){
		if(count($idList) == 0){
			return '';
		}else if(count($idList) == 1 ){
			return array('Event.id = '=> current($idList));
		}else{
			return array('Event.id IN' => $idList );
		}
	}
}

class Keyword extends AppModel{
	public $actsAs = array('Search.Searchable');

	public $filterArgs = array(
			'name' => array('Event.keyword' =>'value'),
	);

}
