<?php
/*
 * @author 菅野
 */
class EventsTag extends AppModel{
	//モデル名
	public $name = 'EventsTag';

	public $useTable = 'Events_tags';
	public $belongsTo = array(
	'Tag' => array(
	'className' => 'Tag',
	'foreignKey' => 'tag_id',
	'conditions' => '',
	'fields' => '',
	'order' => ''
	),
	'Event' => array(
	'className' => 'Event',
	'foreignKey' => 'event_id',
	'conditions' => '',
	'fields' => '',
	'order' => ''
	)
	);
	
	public function getUsingTagId(){
		$list = $this->find('list',array('fields'=>array('tag_id'),'recursive'=>0));
		$list = array_unique($list);
		unset($list[array_search(null,$list)]);
		return $list;
	}

	public function getRecommendScore($currentEventId,$idList){
		$this->belongsTo = array();
		$fr = $this->find('all',array('recursive'=>0,'conditions'=>$this->getIdListInCondition($idList)));
		$current = array();
		$candidate = array();
		foreach ($fr as $key => $value) {
			if($value['EventsTag']['event_id'] == $currentEventId){
				array_push($current , $value['EventsTag']['tag_id']);
			}else{
				if(!array_key_exists($value['EventsTag']['event_id'], $candidate))
					$candidate += array($value['EventsTag']['event_id'] => array());
				array_push($candidate[$value['EventsTag']['event_id']],$value['EventsTag']['tag_id']);
			}
		}
		$score = $candidate;
		foreach ($score as $key => $value)
			$score[$key] = 0;

		foreach ($candidate as $key => $value) {
			foreach ($value as $k => $v) {
				if(in_array($v, $current))
					$score[$key] += 20;
			}
		}

		return $score;
	}

	public function getIdListInCondition($idList){
		if(count($idList) == 0){
			return '';
		}else if(count($idList) == 1 ){
			return array('event_id = '=> current($idList));
		}else{
			return array('event_id IN' => $idList );
		}
	}
}