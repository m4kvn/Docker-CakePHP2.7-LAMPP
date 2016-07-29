<?php
/*
 * @author 菅野、斉藤篤史 日付を取得するメソッド
 */
class EventdatesController extends AppController {
	public $name = "Eventdates";
	public $uses = array('Event', 'Past', 'Venue', 'Host', 'Tag', 'Eventdate','EventImage');
	public $helpers = array (
			'UploadPack.Upload'
	);
	public $components = array (
			'Auth'
	);
	public function beforeFilter() {
		$this->Auth->authError = 'ログインが必要です';
		$this->Auth->allow ( 'search' );
		$this->Auth->allow ( 'searchmonth' );
		$this->Auth->allow ( 'searchspan' );

		$this->dataSender();
	}
	public function beforeRender() {
		$this->loadModel ( 'Event' );
		$allEventList = $this->Event->find ( 'all' );
		$this->set ( 'allEventList', $allEventList );
	}

	/*
	 * @author 斉藤篤史、齋藤創 　* 日付検索するメソッド 　
	 */
	public function search($date = null) {
		if ($date == null)
			$this->redirect ( '/events/index' );
        
		$list = $this->Eventdate->findEventIdListByDateString ( $date );
		$this->loadModel ( 'Event' );
        
        $batch_time = date('Y-m-01');
        if(strtotime($date) > strtotime($batch_time)){
            $result = $this->Event->findByEventIdList ( $list );
            
        }else{
            $finds = $this->Past->findByEventIdList($list);
            $result = $this->Event->findByEventIdList ( $list );
            $index = count($result);
            foreach($finds as $key => $value ){
                $result[$index] = array('Event' => $value['Past']);
                $result[$index] += array('Venue' => $value['Venue']);
                $result[$index] += array('Host' => $value['Host']);
                $result[$index] += array('Eventdate' => $value['Eventdate']);
                $result[$index] += array('Tag' => $value['Tag']);
                $index++;
            }
            
        }
        
		foreach ( $result as $key => $value ) {
			$result [$key] ['Event'] = $this->Event->addMarkFlag ( $value ['Event'] );
		}

		// 次への機能takerusiki
		$this->set ( 'allresult', count ( $result ) );
		$listId = $this->params ['url'] ['id'];
		if ($listId == null) {
			$listId = 1;
		}
		$displayNum = 20; /* 一画面あたりの表示イベント数 */

		$eventNum = $listId * $displayNum;
		$eventListForResult = array (); /* View送信用の変数 */

		if ($displayNum * $listId < count ( $result )) {
			for($i = $displayNum * ($listId - 1); $i < $eventNum; $i ++) {
				array_push ( $eventListForResult, $result [$i] );
			}
		} else {
			for($i = $displayNum * ($listId - 1); $i < count ( $result ); $i ++) {
				array_push ( $eventListForResult, $result [$i] );
			}
		}

		$image = array();
 		for($i = 0; $i < count($eventListForResult); $i++){
			$options = array('conditions' => array('event_id' => $eventListForResult[$i]['Event']['id']));
 			$arr = $this->EventImage->find('first',$options);
 			array_push($image, $arr);
 		}
 		$this->set('image', $image);

		$this->set ( 'eventNum', count ( $result ) );
		$this->set ( 'result', $eventListForResult );
		$this->set ( 'id', $listId ); // takerusan
		                           // $this->set('result',$result);
		$this->set ( 'searchdate', $date );
		$this->set("title_for_layout", date('Y/m/d',strtotime($date)) . "に開催されるイベント - HakoEve" );
		// if($this->Auth->loggedIn())
		// $this->render('/Events/manageresult');
		// else
		// $this->render('/Events/result');
	}

	/*
	 * @author 京谷 　* 月ごとを検索するメソッド 　
	 */
	public function searchmonth($month = null, $listId = 1) {
        $month = $month . "01";
		$list = $this->Eventdate->findEventIdListByMonthString ( $month );
		$this->loadModel ( 'Event' );
        $month = date('Ymd',mktime(0, 0, 0, (int)substr($month, 4, -2), (int)substr($month, 6),(int)substr($month, 0, -4)) );
        $batch_time = date('Ym01');
        
        if(strtotime($month) >= strtotime($batch_time)){
            $result = $this->Event->findByEventIdListSortedForSearchMonth ( $list, $month );
        }else{
            $finds = $this->Past->findByEventIdListSortedForSearchMonth ( $list, $month );
            $result = array();
            foreach($finds as $key => $value ){
                $result[$key] = array('Event' => $value['Past']);
                $result[$key] += array('Venue' => $value['Venue']);
                $result[$key] += array('Host' => $value['Host']);
                $result[$key] += array('Eventdate' => $value['Eventdate']);
                $result[$key] += array('Tag' => $value['Tag']);
            }
        }
        $moon = substr ( $month, 4, 2 );
//        print_r($moon . " : " . $month);
		foreach ( $result as $key => $value ) {
			$result [$key] ['Event'] = $this->Event->addMarkFlag ( $value ['Event'] );
		}
///
		$displayNum = 100; /*一画面あたりの表示イベント数*/

		$eventNum = $listId * $displayNum;
		$eventListForResult = array(); /*View送信用の変数*/

		if($displayNum * $listId < count($result)){
			for($i = $displayNum * ($listId - 1); $i < $eventNum ;$i++){
				array_push($eventListForResult, $result[$i]);
			}
		}else{
			for($i = $displayNum * ($listId - 1); $i < count($result) ;$i++){
				array_push($eventListForResult, $result[$i]);
			}
		}

		$this->set('eventNum',count($result));
		$this->set('id', $listId);
///
		$this->set ( 'result', $eventListForResult );
		$this->set ( 'searchmonth', $month );
		$this->set ( 'moon', $moon );
		$this->set ( 'searchmonth', $month);
		
		$this->set("title_for_layout", date('Y/m',strtotime($month)) . "に開催されるイベント - HakoEve" );
	}

	public function searchspan($span1, $span2) {
        $span2 = date('Y-m-d H:i:s', strtotime($span2 . " + 23 hour + 59 minute"));
		$list = $this->Eventdate->findEventIdListBySpanString ( $span1, $span2 );
        
		$listId = $this->params ['url'] ['id'];
		if ($listId == null) {
			$listId = 1;
		}
		$displayNum = 20; /* 一画面あたりの表示イベント数 */

		$eventNum = $listId * $displayNum;

		$showList = array();
		$i = $displayNum * ($listId - 1);$j = 0;
		foreach($list as $key => $value){
			if($i >= $eventNum || $i >= count($list)) break;
			if($j >= $displayNum * ($listId - 1)){
				$showList += array($key => $value);
				$i++;
			}
			$j++;
		}

		$this->loadModel ( 'Event' );
		$result = $this->Event->findByEventIdList ( $showList );
        $index = count($result);
        $res2 = $this->Past->findByEventIdList ( $showList );
        foreach ($res2 as $key => $value ){
            $result[$index] = array('Event' => $value['Past']);
            $result[$index] += array('Venue' => $value['Venue']);
            $result[$index] += array('Host' => $value['Host']);
            $result[$index] += array('Eventdate' => $value['Eventdate']);
            $result[$index] += array('Tag' => $value['Tag']);
            $index++;
        }
        
		//print_r($result);//変数のなかみ見る
		foreach ( $result as $key => $value ) {
			$result [$key] ['Event'] = $this->Event->addMarkFlag ( $value ['Event'] );
		}
		// 次への機能takerusiki
		$this->set ( 'allresult', count ( $list ) );

		$image = array();
 		for($i = 0; $i < count($result); $i++){
			$options = array('conditions' => array('event_id' => $result[$i]['Event']['id']));
 			$arr = $this->EventImage->find('first',$options);
 			array_push($image, $arr);
 		}
 		//print_r($eventListForResult);
 		$this->set('image', $image);

		$this->set ( 'eventNum', count ( $list ) );
		$this->set ( 'result', $result );
		$this->set ( 'id', $listId ); // takerusan

		$this->set ( 'span1', $span1 );
		$this->set ( 'span2', $span2 );
		$this->set("title_for_layout", date('Y/m/d',strtotime($span1)) . "から" . date('Y/m/d',strtotime($span2)) . "に開催されるイベント - HakoEve" );
	}

	public function dataSender(){
 		App::import('Controller', 'Venues');
 		$venue = new VenuesController();
 		$this->set('venue' , $venue->data());

 		App::import( 'Controller','Tags');
 		$tags = new TagsController();
 		$this->set('select1',$tags->data());
 	}
}

?>