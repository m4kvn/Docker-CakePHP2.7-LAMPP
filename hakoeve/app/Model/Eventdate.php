<?php
/*
 * @author 菅野
 */
class Eventdate extends AppModel{
	//モデル名
	public $name = 'Eventdate';
	public $useTable = 'event_dates';
	//Eventモデルとのアソシエーション
	public $hasMany = 'Event';

	public $validate = array(
			'date'=>array(
				'rule' => array('datetime'),
				'message' => '存在しない日付です'
			)
			);

	public $order = 'date asc';

	//存在しない日を見るメソッド
    public function datetime($check) {
        list ($key, $datetime) = each($check);
        if (is_null($datetime)) {
            return true;
        }
        // format check (Y-m-d H:i:s)
        $regex = '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}:(\d{2}))$/';
        if (!preg_match($regex, $datetime)) {
            return false;
        }
        $list = explode(' ', $datetime);
        $date = explode('-', $list[0]);
        // date check (Y-m-d)
        if (!checkdate($date[1], $date[2], $date[0])) {
            return false;
        }
        $time = explode(':', $list[1]);
        // time check (H:i:s)
        if ($time[0] < 0 || $time[0] >=24 || $time[1] < 0 || $time[1] >=60 || $time[2] < 0 || $time[2] >=60) {
            return false;
        }
        return true;
    }

	public function getDateScore($currentId,$candidateIdList){
		$currentKey = array_search($currentId, $candidateIdList);
		if(! $currentKey === FALSE)
			unset($candidateIdList[$currentKey]);

		$dateList = $this->find('all',array('conditions'=>$this->getIdListInCondition($candidateIdList),'recursive'=>0));

		$candidateIdWithDate = array_flip($candidateIdList);
		foreach ($candidateIdWithDate as $key => $value)
			$candidateIdWithDate[$key] = date('Y-m-d',strtotime('+1 year'));

		foreach ($dateList as $value) {
			if($value['Eventdate']['date'] >= date('Y-m-d') && $value['Eventdate']['date'] <= $candidateIdWithDate[$value['Eventdate']['event_id']])
				$candidateIdWithDate[$value['Eventdate']['event_id']] = $value['Eventdate']['date'];
		}

		$score = $candidateIdWithDate;

		foreach ($candidateIdWithDate as $key => $value) {
			if(date('Y-m-d',strtotime('+1 month')) >= $value)
				$score[$key] = 0;
			else if(date('Y-m-d',strtotime('+45 day')) >= $value)
				$score[$key] = -15;
			else
				$score[$key] = -25;
		}

		return $score;
	}

	public function getIdListInCondition($idList){
		if(count($idList) == 0){
			return '';
		}else if(count($idList) == 1 ){
			return array('Eventdate.event_id = '=> current($idList));
		}else{
			return array('Eventdate.event_id IN' => $idList );
		}
	}

	public function getEventIdListAfterToday(){
		date_default_timezone_set('Asia/Tokyo');
		$today = date('Y-m-d');
		$list = $this->find('list',array('fields' => array('event_id'),'conditions'=>array('date >='=>$today)));
 		$list = array_unique($list);
 		return $list;
	}

	//坂部殺す
	public function SakabeGetEventIdListAfterToday(){
		date_default_timezone_set('Asia/Tokyo');
		$today = date('Y-m-d');
		$list = $this->find('list',array('fields' => array('event_id'),'conditions'=>array('date >='=>$today)));
		$list = array($list);
		return $list;
	}

	public function getEventIdListBetweenTodayAndMonthLater(){
		date_default_timezone_set('Asia/Tokyo');
 		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$today = mktime(0,0,0,$month, $day, $year);
		$monthLater = date('Y-m-d', strtotime('+1 month', $today));
		$today = date('Y-m-d');

 		$list = $this->find('list',array('fields' => array('event_id'),'conditions'=>array('date >='=>$today,'date <=' => $monthLater)));
 		$list = array_unique($list);
 		return $list;
	}

	public function findEventIdListByDateString($date){
		$date = strtotime($date);
		$date2 = strtotime("+ 1 day", $date);
		$date = date('Y-m-d',$date);
		$date2 = date('Y-m-d',$date2);
		$eventsIdList = $this->find('list',array('fields' => array('event_id'),'conditions'=>array('date >'=>$date, 'date <'=>$date2)));
		$eventsIdList = array_unique($eventsIdList);
		return $eventsIdList;
	}

	public function findEventIdListByMonthString($date){
		$date = strtotime($date);
		$date = date('Y-m-d',$date);
		$nextdate = date("Y-m-d", strtotime("$date +1 month"));
		$eventsIdList = $this->find('list',array('fields' => array('event_id'),'conditions'=>array('date >='=>$date,'date <'=>$nextdate)));
		$eventsIdList = array_unique($eventsIdList);
		return $eventsIdList;
	}

	public function findEventIdListBySpanString($date1, $date2){
		$date1 = strtotime($date1);
		$date1 = date('Y-m-d H:i:s',$date1);
		$date2 = strtotime($date2);
		$date2 = date('Y-m-d H:i:s',$date2);
		$eventsIdList = $this->find('list',array('fields' => array('event_id'),'conditions'=>array('date >='=>$date1,'date <='=>$date2)));
		$eventsIdList = array_unique($eventsIdList);
		return $eventsIdList;
	}
	
	public function getEventIdList(){
		$eventsIdList = $this->find('list', array('fields' => array('event_id')));
		$eventsIdList = array_unique($eventsIdList);
		return $eventsIdList;
	}
}