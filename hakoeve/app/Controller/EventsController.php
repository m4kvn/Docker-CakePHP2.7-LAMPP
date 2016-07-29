<?php
App::uses('AppController', 'Controller');

class EventsController extends AppController {
	//コントローラ名
	public $name = 'Events';
	public $uses = array('Event', 'Venue', 'Host', 'Tag', 'Eventdate','EventImage');
	//検索用の変数準備
	public $components = array('Search.Prg','Auth', 'Email');
	public $presetVars = true;
	public $paginate = array();

	//使用するヘルパー
	public $helpers = array('UploadPack.Upload');

	//メソッド実行前に呼び出される
	//主にログインしてなくてもアクセスできるページの管理
	public function beforeFilter(){
		$this->Auth->authError='ログインが必要です';
		$this->Auth->allow('index');
		$this->Auth->allow('result');
		$this->Auth->allow('view');
		$this->Auth->allow('about');
		$this->Auth->allow('confirm');
	//	$this->Auth->allow('viewmanagement');
		$this->Auth->allow('image');
		$this->Auth->allow('all');
		$this->Auth->allow('contact');
		$this->Auth->allow('about_add');
		$this->Auth->allow('add');$this->Auth->allow('manage');$this->Auth->allow('edit');$this->Auth->allow('viewmanagement');$this->Auth->allow('delete');
		$this->Auth->allow('current');
		$this->Auth->allow('entry_complete');
		$this->dataSender();
	}

	//ctpのレンダー前に呼び出される
	//カレンダー用のイベントセット
	public function beforeRender(){
		$allEventList = $this->Event->find('all');
		$this->set('allEventList',$allEventList);
	}

	/*
	 *@auther 京谷　坂部
	*@auther 齋藤創　斉藤篤史
	*indexページ　キーワード検索の機能もある
	*/
	public function index(){
		$this->Prg->commonProcess();
		$this->set('title_for_layout', "HakoEve");
		$this->loadModel('Eventdate');
		$list = $this->Eventdate->SakabeGetEventIdListAfterToday();
		$eventList = $this->Event->findByEventIdListSortedForIndex($list);

		foreach ($eventList as $key => $value)
			$eventList[$key]['Event'] = $this->Event->addMarkFlag($value['Event']);
		$this->set('eventList',$eventList);

		$list = $this->Eventdate->getEventIdListAfterToday();
		$eventList = $this->Event->findByEventIdListformanage($list);
		foreach ($eventList as $key => $value)
			$eventList[$key]['Event'] = $this->Event->addMarkFlag($value['Event']);

		$newerEventList = Set::sort($eventList, '{n}.Event.created' ,'desc');
		$this->set('newerEventList',$newerEventList);

		$reccomend = $this->Event->find('all', array('limit' => 4,'order' => array('Event.updated' => 'desc'), 'conditions'=> array('recommend' => 1, 'visible' => 1)));
        if(count($reccomend) <= 0){
            $reccomend = $this->Event->find('all', array('limit' => 4,'order' => array('Event.updated' => 'desc'), 'conditions'=> array('visible' => 1)));
        }
		$this->set('recommend',$reccomend);

 		$image = array();
 		for($i = 0; $i < count($reccomend); $i++){
 			$arr = $this->EventImage->find('first',array('conditions' => array('event_id' => $reccomend[$i]['Event']['id'])));
 			array_push($image, $arr);
 		}
 		$this->set('image', $image);
	}

	public function all($listId = null){
		$this->Prg->commonProcess();
		$this->set('title_for_layout', "イベント一覧 - HakoEve");
		
		$this->loadModel('Eventdate');
		$list = $this->Eventdate->SakabeGetEventIdListAfterToday();
		$eventList = $this->Event->findByEventIdListSortedForIndex($list);

		foreach ($eventList as $key => $value)
			$eventList[$key]['Event'] = $this->Event->addMarkFlag($value['Event']);

		$checkedEventList = array();
		for($i = 0; $i < count($eventList); $i++){
			if($eventList[$i]['Event']['visible'] != 0){
				array_push($checkedEventList, $eventList[$i]);
		}}

		if(isset($this->params['url']['sort'])){
			$checkedEventList = $this->eventSort($checkedEventList, $this->params['url']['sort']);
			$this->set('sort', $this->params['url']['sort']);
		}

		$displayNum = 100; /*一画面あたりの表示イベント数*/

		$eventNum = $listId * $displayNum;
		$eventListForList = array(); /*View送信用の変数*/

		if($displayNum * $listId < count($checkedEventList)){
			for($i = $displayNum * ($listId - 1); $i < $eventNum ;$i++){
				array_push($eventListForList, $checkedEventList[$i]);
			}
		}else{
			for($i = $displayNum * ($listId - 1); $i < count($checkedEventList) ;$i++){
				array_push($eventListForList, $checkedEventList[$i]);
			}
		}

		$this->set('eventNum',count($checkedEventList));
		$this->set('eventList', $eventListForList);
		$this->set('id', $listId);
	}

	public function result(){
		$this->Prg->commonProcess();
		$this->set("title_for_layout", $this->passedArgs['keyword'] . " - HakoEve" );
		
		App::uses('Sanitize', 'Utility');
		$key = array('keyword' => Sanitize::stripAll($this->passedArgs['keyword']));
		$conditions = array();
		array_push($conditions , $this->Event->parseCriteria($key));
		$this->loadModel('Eventdate');
		$list = $this->Eventdate->getEventIdListAfterToday();
		array_push($conditions, $this->Event->getIdListInCondition($list));

		if($this->Auth->user()) $result = $this->Event->find('all', array('conditions'=>$conditions, "order" => array("Event.created" => "desc")));
		else $result = $this->Event->find('all',array('conditions'=>array($conditions, 'Event.visible !=' => 0)));

		foreach($result as $key =>$row){
			$date[$key] = $row['Eventdate'][0]["date"];
		}

		if($result != array() && !$this->Auth->user())
			array_multisort($date,SORT_ASC,$result);
		foreach ($result as $key => $value) {
			$result[$key]['Event'] = $this->Event->addMarkFlag($value['Event']);
		}
		$listId = $this->params['url']['id'];
		if($listId == null){ $listId = 1;}
		$displayNum = 20; /*一画面あたりの表示イベント数*/

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
		$this->set('result',$eventListForResult);
		$this->set('id', $listId);

		$image = array();
 		for($i = 0; $i < count($eventListForResult); $i++){
			$options = array('conditions' => array('event_id' => $eventListForResult[$i]['Event']['id']));
 			$arr = $this->EventImage->find('first',$options);
 			array_push($image, $arr);
 		}
 		$this->set('image', $image);
	}

	/*
	 *@auther　菅野
	*イベント詳細表示ページ
	*/
	public function view($id = null) {
		if (!$this->Event->exists($id))
			throw new NotFoundException('不正なイベントです。');

		//詳細表示するイベント情報セット
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$event = $this->Event->findByEventId($options);
		$event['Event'] = $this->Event->addMarkFlag($event['Event']);
		$this->set('Event', $event);
		$this->set("title_for_layout", $event['Event']['event_name'] . " - HakoEve" );
		
		//推薦するイベント情報セット
		$this->loadModel('Tag');
		$this->loadModel('Eventdate');
		$this->loadModel('EventsTag');

		$eventList = $this->Eventdate->getEventIdListAfterToday();
		if(count($eventList) == 0){
			$this->set('recommend',array());
			return;
		}
		if(count($eventList) == 1){
			foreach ($eventList as $value) {
				if($value == $id){
					$this->set('recommend',array());
					return;
				}
			}
		}

		$tagScore = $this->EventsTag->getRecommendScore($id,$eventList);
		$hostScore = $this->Event->getHostScore($id,$event['Event']['host_id'],$eventList);
		$dateScore = $this->Eventdate->getDateScore($id,$eventList);

		$score = $tagScore;
		foreach ($hostScore as $key => $value)
			$score[$key] += $value;
		foreach ($dateScore as $key => $value)
			$score[$key] += $value;

		$sortedIdList = array_flip($score);
		ksort($sortedIdList);

		foreach ($sortedIdList as $key => $value)
			$sortedIdList[$key] = array();
		foreach ($score as $key => $value)
			array_push($sortedIdList[$value],$key);

		$recoIdList = array();
		$pop = array_pop($sortedIdList);
		while( $pop !== NULL && count($recoIdList) != 3){
			shuffle($pop);
			$p = array_pop($pop);
			while($p !== NULL && count($recoIdList) != 3) {
				array_push($recoIdList,$p);
				$p = array_pop($pop);
			}
			$pop = array_pop($sortedIdList);
		}

		$recommend = array();
		foreach ($recoIdList as $value){
			array_push($recommend,$this->Event->find('first',array('conditions'=>array('Event.id'=>$value))));}

//		foreach ($recommend as $key => $value)
//			$recommend[$key]['Event'] = $this->Event->addMarkFlag($value['Event']);
		$this->set('recommend',$recommend);

		$options = array('conditions' => array('event_id' => $id));
  		$Image = $this->EventImage->find('first',$options);
  		$this->set('Image', $Image);

		$image = array();
 		for($i = 0; $i < count($recommend); $i++){
			$options = array('conditions' => array('event_id' => $recommend[$i]['Event']['id']));
 			$arr = $this->EventImage->find('first',$options);
 			array_push($image, $arr);
 		}
 		$this->set('ReccoImage', $image);
	}

	/*
	 addメソッド
	新規イベント登録用メソッド
	書いた人：菅野
	*/
	public function add() {
		$this->set("title_for_layout", "イベント追加 - HakoEve" );
		//ポストだった場合のみ処理
		if ($this->request->is('post')) {
			if(isset($this->data['confirm'])){
				$i = 0;
				foreach ($this->request->data['Eventdate'] as $date){
					$end_time = explode(":", array_pop($this->request->data['Eventdate'][$i]));
					$daytime = explode(" ", array_pop($this->request->data['Eventdate'][$i]));
				/*	if(strtotime($end_time[0].":".$end_time[1]) <= strtotime($daytime[1]) && $end_time[0] != ''){
						$this->Session->setFlash('開催日時と終了時刻の関係に間違いが有ります。');
						$this->EventImage->delete($this->data['EventImage']['id']);
						$this->request->data += array('back' => '戻る');
						$this->set('data', $this->request->data);print_r($this->request->data);
						return;
					}*/
					$this->request->data['Eventdate'][$i] = array();
					$day = explode("-", $daytime[0]);
					$time = explode(":", $daytime[1]);
					$this->request->data['Eventdate'][$i] += array('date'  => array('year' => $day[0], 'month' => $day[1],
						'day' => $day[2], 'hour' => $time[0], 'min' => $time[1]), 'end_time' => array('hour' => $end_time[0], 'min' => $end_time[1]));
					if(strtotime($end_time[0].":".$end_time[1]) <= strtotime($daytime[1]) && $end_time[0] != ''){
						$this->Session->setFlash('開催日時の開始時刻と終了時刻の関係に間違いが有ります。');
						$this->EventImage->delete($this->data['EventImage']['id']);
						
						$showDate = array();$showTime = array(); $num = 0;
						foreach($this->request->data['Eventdate'] as $eventdate){
							$date = $eventdate['date'];
							if($i >= $num) $date = $date['year']. "-" . $date['month'] . "-" . $date['day'] . " " . $date['hour'] . ":" . $date['min'];
							$time = $eventdate['end_time'];
							if($i >= $num) $time = $time['hour'] . ":" . $time['min'];
							$showDate += array($num => $date);  
							$showTime += array($num => $time);
							$num++;
						}
						$this->set('showDate',$showDate);
						$this->set('showTime',$showTime);
						$this->request->data += array('back' => '戻る');
						$this->request->data['Event'] += array('Tag' => $this->request->data['Tag']);
						$this->set('data', $this->request->data);
						$this->setVenueHostTagForForm();
						return;
					}
					$i++;
				}    
				    $this->set('Event', $this->request->data);
				    $venue = $this->Venue->find('first', array('conditions'=>array('Venue.venue_name' => $this->request->data['Event']['venue_name'])));
				    $host = $this->Host->find('first', array('conditions'=>array('Host.host_name' => $this->request->data['Event']['host_name'])));
				    $tag = $this->Tag->find('all', array('conditions'=>array('Tag.id' => $this->data['Tag']['tag_id'])));
				    $this->set('Venue', $venue);
				    $this->set('Host', $host);
//                    for($i = 0; $i <= 2 ;$i++){
//                        $this->data['Event']['thumbnail'][$i][name] = urlencode($this->data['Event']['thumbnail'][$i][name]);
//                    }
                
                    $imgs = array($this->data['Event']['thumbnail'][0],
                                  $this->data['Event']['thumbnail'][1],
                                  $this->data['Event']['thumbnail'][2]);
                
				    $save = array('EventImage' => array(
						'img'  => $imgs[0],
						'img2' => $imgs[1],
						'img3' => $imgs[2],
						'event_id' => 0));
                    $save['EventImage']['img']['name']  = mb_convert_encoding( $save['EventImage']['img']['name'],  'UTF-8', 'auto' );
                    $save['EventImage']['img2']['name'] = mb_convert_encoding( $save['EventImage']['img2']['name'], 'UTF-8', 'auto' );
                    $save['EventImage']['img3']['name'] = mb_convert_encoding( $save['EventImage']['img3']['name'], 'UTF-8', 'auto' );
                
                    $this->EventImage->save($save);
                    $imageId = $this->EventImage->getLastInsertID();
                    
				/*confirmに送る画像をfind*/
				    $imageSave = $this->EventImage->find('first', array('conditions' => array(
						'id' => $imageId,
//						'img_file_name' => $this->imageRename($this->data['Event']['thumbnail'][0]['name']),
//						'img2_file_name' => $this->imageRename($this->data['Event']['thumbnail'][1]['name']),
//						'img3_file_name' => $this->imageRename($this->data['Event']['thumbnail'][2]['name']),
//						'event_id' => 0
						)));
                    $this->set('Image', $imageSave);
				    $this->set('Tag', $tag);
				    $this->render('confirm');
                
                
			} elseif(isset($this->data['back'])) {
	//			$name = $this->imageRename($this->data['Event']['thumbnail']['name']);
	//			$name = $this->EventImage->find('first', array('conditions'=>array('img_file_name' => $name)));
				$this->loadModel('Venue'); $this->loadModel('Host');
				$data = $this->request->data;
				$venue = $this->Venue->find('first', array('recursive' => -1, 'fields' => 'venue_name' , 'conditions' => array('Venue.id' => $data['Event']['venue_id'])));
				$host =  $this->Host->find('first', array('recursive' => -1, 'fields'=> 'Host.host_name','conditions'=>array('Host.id' => $data['Event']['host_id'])));
				$data['Event'] += array('venue_name' => $venue['Venue']['venue_name']);
				$data['Event'] += array('host_name' => $host['Host']['host_name']);
				$showDate = array();$showTime = array(); $num = 0;
				
				foreach($data['Eventdate'] as $eventdate){
					$date = $eventdate['date'];
					$date = $date['year']. "-" . $date['month'] . "-" . $date['day'] . " " . $date['hour'] . ":" . $date['min'] . ":00";
					$time = $eventdate['end_time'];
					$time = $time['hour'] . ":" . $time['min'] . ":00";
					$showDate += array($num => $date);  
					$showTime += array($num => $time);
					$num++;
				}
				
				
				$this->EventImage->delete($this->data['EventImage']['id']);
				$this->set('data', $data);
				$this->set('showDate',$showDate);
				$this->set('showTime',$showTime);

			} elseif(isset($this->data['add'])) {
				$this->Event->create();
				if ($this->Event->saveAssociated($this->request->data)){
					//タグ保存関連処理
				//	$this->saveImage($this->data['Event']['thumbnail']['name'], $this->Event->id);
					$d = $this->data;
					$this->EventImage->save(array('id' => $this->data['EventImage']['id'], 'event_id' => $this->Event->id));
					$this->saveTags($this->request->data,$this->Event->id);

					//if($this->params['url']['loop'] == 1){
					//for($i = 0; $i < 100; $i++){
					//	$d = $this->data;
					//	$d['Event']['event_name'] .= strval($i);
					//	$this->Event->saveAssociated($d);
					//	$this->saveTags($d,$this->Event->getLastInsertID());
					//}
					//}
					$this->Session->setFlash('イベントが保存されました。');
					$this->redirect(array('action' => 'viewmanagement', $this->Event->id));
				} else {
					$this->Session->setFlash('イベントが保存できませんでした');
				}
			}
		}

		//各配列セット
		$this->setVenueHostTagForForm();
	}

	/*
	 *@auther　菅野
	*イベント編集ページ
	*/
	public function edit($id = null) {
		if (!$this->Event->exists($id))
			throw new NotFoundException('不正なイベントです。');

		//ポストかプットだったら
		if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;

				$i = 0;
				foreach ($data['Eventdate'] as $date){
					$end_time = explode(":", array_pop($data['Eventdate'][$i]));
					$daytime = explode(" ", array_pop($data['Eventdate'][$i]));
					if(strtotime($end_time[0].":".$end_time[1]) <= strtotime($daytime[1]) && $end_time[0] != ''){
						$this->Session->setFlash('開催日時と終了時刻の関係に間違いが有ります。');
						$this->EventImage->delete($this->data['EventImage']['id']);
						$this->set('data', $this->request->data);
						return;
					}
					$this->request->data['Eventdate'][$i] = array();
					$day = explode("-", $daytime[0]);
					$time = explode(":", $daytime[1]);
					$data['Eventdate'][$i] += array('date'  => array('year' => $day[0], 'month' => $day[1],
						'day' => $day[2], 'hour' => $time[0], 'min' => $time[1]), 'end_time' => array('hour' => $end_time[0], 'min' => $end_time[1]));
					$i++;
				}

			$data['Event'] += array('id'=>$id);
			$this->loadModel('Eventdate');
			$dateDeleteIdList = $this->Eventdate->find('list',array('fields'=>array('id'),'conditions'=>array('event_id'=>$id)));

			$venue = $this->Venue->find('first', array('fields'=>array('Venue.id'),'conditions'=>array('Venue.venue_name' => $data['Event']['venue_name'])));
			$host = $this->Host->find('first', array('fields'=>array('Host.id'),'conditions'=>array('Host.host_name' => $data['Event']['host_name'])));

			$data['Event'] += array('venue_id' => $venue['Venue']['id']);
			$data['Event'] += array('host_id' => $host['Host']['id']);
			$data['Event']['venue_name'] = array();
			$data['Event']['host_name'] = array();
			unset($data['Event']['venue_name'], $data['Event']['host_name']);

			$img = $this->findImage($id);
	//		print_r($this->data['Event']['thumbnail']);
			if($this->data['Event']['thumbnail'][0]['name'] != ""){
//                $this->data['Event']['thumbnail'][0]['name'] = urlencode($this->data['Event']['thumbnail'][0]['name']);
				$save = array('EventImage' => array(
					'img' => $this->data['Event']['thumbnail'][0],
					'event_id' => $img['EventImage']['event_id']));

				if($this->data['Event']['thumbnail'][1]['name'] != ""){
//                    $this->data['Event']['thumbnail'][1]['name'] = urlencode($this->data['Event']['thumbnail'][1]['name']);
					$save['EventImage'] += array('img2' => $this->data['Event']['thumbnail'][1]);
				}
				if($this->data['Event']['thumbnail'][2]['name'] != ""){
//                    $this->data['Event']['thumbnail'][2]['name'] = urlencode($this->data['Event']['thumbnail'][2]['name']);
					$save['EventImage'] += array('img3' => $this->data['Event']['thumbnail'][2]);
                }
                
				$this->EventImage->delete($img['EventImage']['id']);
				$this->EventImage->save($save);
			}
			if ($this->Event->saveAssociated($data)) {
				//タグ保存関連処理
				$this->saveTags($data,$id);
				foreach($dateDeleteIdList as $eventDateId)
					$this->Eventdate->delete($eventDateId);
				$this->Session->setFlash('イベント情報が変更されました。');
				$this->redirect(array('action' => 'viewmanagement', $id));
			} else {
				$this->Session->setFlash('イベント情報を変更できませんでした。');
				$img = $this->findImage($id);
				$this->EventImage->delete($img['EventImage']['id']);
			}
		}
		$this->loadModel('Eventdate');
		$showDate = $this->Eventdate->find('list',array('fields'=>array('date'),'conditions'=>array('event_id'=>$id)));
		$showTime = $this->Eventdate->find('list',array('fields'=>array('end_time'),'conditions'=>array('event_id'=>$id)));
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$this->request->data = $this->Event->find('first', $options);
        
		$this->set("Event", $this->request->data);

		$selected = array();
		foreach ($this->request->data['Tag'] as $value)
			array_push($selected,$value['id']);

		$this->set('selected',$selected);
		$this->set('showDate',$showDate);
		$this->set('showTime',$showTime);
		//各配列セット
		$this->setVenueHostTagForForm();
		$this->set("title_for_layout", $this->request->data['Event']['event_name']." 編集 - HakoEve" );
	}

	/*
	 *@auther　斉藤篤史
	　*管理者用イベント情報詳細メソッド
	　*/
	public function viewmanagement($id = null) {
		if (!$this->Event->exists($id))
			throw new NotFoundException('不正なイベントです。');
		//詳細表示する主催者情報セット
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$Event = $this->Event->find('first', $options);
		$options = array('conditions' => array('event_id' => $id));
  		//$Image = $this->EventImage->find('first',$options);
		$imageSave = $this->EventImage->find('first',$options);
  		$this->set('Image', $imageSave);
		$this->set('Event', $Event);
		
		$this->set("title_for_layout", "イベント管理 " . $Event['Event']['event_name'] . " - HakoEve" );
	}

	/*
	 * @author 斉藤篤史、齋藤創
	* イベント情報削除メソッド
	*/
	public function delete($id = null){
		if($id == null){
			$this->redirect(array('action'=>'manage'));
			return;
		}

		$image = $this->EventImage->find('first',
				array('conditions' =>
						array('EventImage.event_id' => $id)));
		$this->EventImage->delete($image['EventImage']['id']);
		$this->Event->id = $id;
		if($this->Event->delete($this->data['Event']['id']))
			$this->Session->setFlash('イベントが削除されました');
		else
			$this->Session->setFlash('イベントが削除できませんでした');

		$this->redirect(array('action'=>'manage'));
	}

	public function manage($id=null){
		$this->Prg->commonProcess();

		$this->loadModel('Eventdate');
		$list = $this->Eventdate->getEventIdListAfterToday();
		$eventList = $this->Event->findByEventIdListformanage($list);

		foreach($eventList as $key =>$row)
			$date[$key] = $row['Eventdate'][0]["date"];

		array_multisort($date,SORT_ASC,$eventList);
		$this->set('eventList',$eventList);
		
		$this->set("title_for_layout", "管理 - HakoEve" );
	}

	public function manageresult(){
		$this->result();
	}
	public function about(){
		$this->set("title_for_layout", "HakoEveについて - HakoEve" );
	}

	public function entry_complete(){
	}	

	public function contact(){
		$this->set("title_for_layout", "お問い合わせ - HakoEve" );
		$this->loadModel('Contact');
		set_time_limit(120);
		if($this->request->is('post')){
		
			if( (!isset($this->request->data['first']) && !isset($this->request->data['confirm']) ) || isset($this->request->data['back'])){
				$this->set('Back',"Back");
				
			}elseif(isset($this->request->data['first'])){
				$this->Contact->set($this->request->data);
				if (!$this->Contact->validates()) {
					$this->Session->setFlash('入力に間違いがあります');
				}else{
					$this->set('Contact', $this->request->data['Contact']);
				}
				
			}elseif(isset($this->request->data['confirm'])){
				$name = $this->request->data['Contact']['Name'];
				$title = $this->request->data['Contact']['Title'];
				$from = $this->request->data['Contact']['MailAddress'];
				$msg = "HakoEveの問い合わせがありました。\n問い合わせ内容は以下の通りです。\n\n----------------------------------------\n\nFrom : " . 
				$name . " \n\n" . $this->request->data['Contact']['Context'] . "\n\n E-mail:\n" . $from . 
				"\n\n----------------------------------------\n";
				
				$email = new CakeEmail('sakura');                        // インスタンス化
		//	print_r($this->data);
				$email->to('toiawase@hakomachi.com'/*toiawase@hakomachi.comここに送り先のアドレス*/)/////////////////////////////////////////////////////////////
					->emailFormat('text')
					->from(array($from => 'HakoEve_contact'))
					->subject($title);

				if($email->send($msg)){	
					$this->Session->setFlash('メールが送信されました');
					$this->set('Confirm', $this->request->data['Contact']);
				}else
					$this->Session->setFlash('メールの送信に失敗しました');
			}
		}
	}

	public function about_add(){
		$this->set("title_for_layout", "イベント登録申請 - HakoEve" );
		$this->loadModel('Contact');
		set_time_limit(120);
		if($this->request->is('post')){
					
			if( (!isset($this->request->data['first']) && !isset($this->request->data['confirm']) ) || isset($this->request->data['back'])){
				$PrevImg = array(
					$this->request->data['Contact']['file_0']['name'],
					$this->request->data['Contact']['file_1']['name'],
					$this->request->data['Contact']['file_2']['name']					
				);
				for($i = 0; $i <= 2; $i++){
					if($PrevImg[$i] == "" && $this->request->data['Contact']['file_'.$i]['prevname'] != "")
						$PrevImg[$i] = $this->request->data['Contact']['file_'.$i]['prevname'];
				}
				$this->set('Back', $this->request->data['Contact']);
				$this->set('PrevImg', $PrevImg);
				
			}elseif(isset($this->request->data['first'])){
				$this->Contact->set($this->request->data);
				if (!$this->Contact->validates()) {
					$this->Session->setFlash('入力に間違いがあります');
					$this->set('Back', $this->request->data['Contact']);
					for($i = 0; $i <= 2; $i++){
						if($this->request->data['Contact']['file_' . $i]['name'] != ""){
							if(move_uploaded_file($this->request->data['Contact']['file_' . $i]['tmp_name'], "files/" . $this->request->data['Contact']['file_' . $i]['name'])){
								chmod("files/" . $this->request->data['Contact']['file_' . $i]['name'], 0644);
							}
						}
					}
					
					$PrevImg = array(
						$this->request->data['Contact']['file_0']['name'],
						$this->request->data['Contact']['file_1']['name'],
						$this->request->data['Contact']['file_2']['name']					
					);
					for($i = 0; $i <= 2; $i++){
						if($PrevImg[$i] == "" && $this->request->data['Contact']['file_'.$i]['prevname'] != "")
							$PrevImg[$i] = $this->request->data['Contact']['file_'.$i]['prevname'];
					}
					$this->set('PrevImg', $PrevImg);
				}else{
					for($i = 0; $i <= 2; $i++){
						if($this->request->data['Contact']['file_' . $i]['name'] != ""){
							if(move_uploaded_file($this->request->data['Contact']['file_' . $i]['tmp_name'], "files/" . $this->request->data['Contact']['file_' . $i]['name'])){
								chmod("files/" . $this->request->data['Contact']['file_' . $i]['name'], 0644);
							}else{
								$this->Session->setFlash('メールの送信に失敗しました');
								$this->set('Back',$this->request->data['Contact']);
							}
						}
					}
					$Contact = $this->request->data['Contact'];
					for($i = 0; $i <= 2; $i++){
						if($Contact['file_'.$i]['name'] == "" && $Contact['file_'.$i]['prevname'] != "")
							$Contact['file_'.$i]['name'] = $Contact['file_'.$i]['prevname'];
					}
					$this->set('Contact', $Contact);
				}
				
				
			}elseif(isset($this->request->data['confirm'])){
				$name = $this->request->data['Contact']['Name'];
				$title = "[HakoEve]イベント登録申請：" . $name;
				$from = $this->request->data['Contact']['MailAddress'];
				//メール本文の作成
				$EventTitle = $this->request->data['Contact']['EventTitle'];
				$DateTime = $this->request->data['Contact']['DeteTime'];
				$Venue = $this->request->data['Contact']['Venue'];
				$Host = $this->request->data['Contact']['Host'];
				$Detail = $this->request->data['Contact']['Detail'];
				$Remarks = $this->request->data['Contact']['Remarks'];
				$msg = "新しいイベントの登録申請がありました。\n申請内容は以下の通りです。\n\n----------------------------------------\n\n代表者 : " . $name . " \n\n" . "イベント名 : ". $EventTitle . "\n\n開催日時 : ". $DateTime . 
						"\n\n開催場所 : ". $Venue. "\n\n主催者情報 : ". $Host. "\n\nイベント詳細 : ". $Detail. "\n\n備考 : " . $Remarks . "\n\n E-mail:\n" . $from . "\n----------------------------------------\n";
						
				$filename = array($this->request->data['Contact']['file_0']['name'],
								  $this->request->data['Contact']['file_1']['name'],
								  $this->request->data['Contact']['file_2']['name']);
				$email = new CakeEmail('sakura');                        // インスタンス化
		
				$email->to('toiawase@hakomachi.com') // toiawase@hakomachi.com ここに送り先のアドレス 
					->emailFormat('text')
					->from(array($from => 'HakoEve_contact'))
					->subject($title);
				if($filename[0] != "" || $filename[1] != "" || $filename[2] != ""){
					$file = array();
					if($filename[0] != "") $file += array($filename[0] => array('file' => "files/" . $filename[0]));
					if($filename[1] != "") $file += array($filename[1] => array('file' => "files/" . $filename[1]));
					if($filename[2] != "") $file += array($filename[2] => array('file' => "files/" . $filename[2]));
					$email->attachments($file);
				}
				$this->set('Confirm', $this->request->data['Contact']);
				
				
				if($email->send($msg)){	
					$this->Session->setFlash('メールが送信されました');
					
					$msg = $name . "様\nイベント登録の申請が完了しました。\n以下に申請内容を記載します。" . "\n--------------------\n" . 
							"イベント名 : ". $EventTitle . "\n\n開催日時 : ". $DateTime . 
							"\n\n開催場所 : ". $Venue. "\n\n主催者情報 : ". $Host. "\n\nイベント詳細 : ". $Detail. "\n\n備考 : " . $Remarks . 
							"\n--------------------\n\n" . "イベント登録が完了しましたら、その旨をメール致します。\n何かご質問がありましたら、函館市地域交流まちづくりセンターまでご連絡ください。\n" .
							"\n--------------------\n" . "函館市地域交流まちづくりセンター\n〒040-0053 函館市末広町4番19号\nTEL:0138-22-9700／FAX 0138-22-9800\nE-mail toiawase@hakomachi.com";
					$email->from(array($from => 'HakoEve_contact'))
						->subject("イベント登録申請が完了しました")
						->to($from)
						->send($msg);
						$this->set('Contact', $Contact);
						foreach (glob("files/*.png") as $filename) {
							unlink($filename);
						}
						foreach (glob("files/*.jpeg") as $filename) {
							unlink($filename);
						}
						foreach (glob("files/*.jpg") as $filename) {
							unlink($filename);
						}
						foreach (glob("files/*.jpe") as $filename) {
							unlink($filename);
						}
					$this->redirect('/events/entry_complete');
				}else
					$this->Session->setFlash('メールの送信に失敗しました');			
			}
	//		print_r(($this->request->data));
		}
	}

	public function current(){
		$this->layout = "";
		$list = $this->Eventdate->getEventIdList();
		$eventList = $this->Event->findByEventIdListforCurrent($list);
		$newerEventList = Set::sort($eventList, '{n}.Event.created' ,'desc');
		$this->set('newerEventList',$newerEventList);

		$dt = new DateTime();
		$dt->setTimeZone(new DateTimeZone('Asia/Tokyo'));
		$today = $dt->format('Y-m-d H:i:s');
		$this->set('today', $today);
	}

	/*
	 *フォームに必要な場所・主催者・タグセットメソッド
	*@author菅野
	*/
	private function setVenueHostTagForForm(){
		$this->loadModel('Venue');
		$this->loadModel('Host');
		$this->loadModel('Tag');
		$this->set('auto_venue',$this->Venue->find('list',array('fields'=>array('id','venue_name'),'recursive'=>0)));
		$this->set('host',$this->Host->find('list',array('fields'=>array('id','host_name'),'recursive'=>0)));
		$this->set('tag',$this->Tag->find('list',array('fields'=>array('id','tag_name'),'recursive'=>0)));
	}

	/*
	 *タグ保存関連処理
	*@author菅野
	*/
	private function saveTags($data,$event_id){
		$et_array = array();
		foreach($data['Tag']['tag_id'] as $tag_id)
			array_push($et_array,array('Event'=>array('id'=>$event_id),'Tag'=>array('id'=>$tag_id)));
		$this->loadModel('Tag');
		$this->Tag->saveMany($et_array,array('validate'=>false));
	}


	private function findImage($event_id){
		$image = $this->EventImage->find('first',array('conditions' => array('event_id' => $event_id)));
		return $image;
	}

	private function editImage($ImageID, $filename){
		$arr = 	array('EventImage' => array(
				'img' => $filename, 'event_id' => $ImageID['EventImage']['event_id']));
		$this->EventImage->delete($ImageID['EventImage']['id']);
		$this->EventImage->save($arr);
		echo "This is ";

	}

	private function rename($splitStr, $imagename){
		//「.」がファイル名中にある場合の対処
		$filename = explode($splitStr, $imagename);
		$name = '';
		for($i = 0; $i < count($filename); $i++){
			if(strcmp($splitStr, ".") == 0){
				if($i >= count($filename) - 1) $name .= "." . $filename[$i];
				elseif($i <= 0) $name .= $filename[$i];
				else $name .= "_" . $filename[$i];
			}else{
				if($i <= 0) $name .= $filename[$i];
				else $name .= "_" . $filename[$i];
			}
		}
		return $name;
	}

	private function imageRename($imagename){
		$imagename = $this->rename(".", $imagename);
		$imagename =  $this->rename("-", $imagename);
		return $imagename;
	}


	private function saveImage($imagename, $event){
	  $name = $this->imageRename($imagename);

	  $save = $this->EventImage->find('first', array('conditions'=>array('img_file_name' => $name)));
	  $save = array('id' => $save['EventImage']['id'], 'event_id' => $event);
	  $this->EventImage->save($save);
	 }

	private function dataSender(){
		App::import('Controller', 'Venues');
		$venue = new VenuesController();
		$this->set('venue' , $venue->data());

		App::import( 'Controller','Tags');
		$tags = new TagsController();
		$this->set('select1',$tags->data());
	}

	private function eventSort($EventList, $SortRule){

		if($SortRule == 0){ /*開催日時が遅い*/
			$EventList = Set::sort($EventList, "{n}.Eventdate.0.date", "DESC");
		}elseif($SortRule == 1){ /*開催日時が早い順*/
			$EventList = Set::sort($EventList, "{n}.Eventdate.0.date", "ASC");
		}elseif($SortRule == 2){ /*五十音順*/
			$EventList = Set::sort($EventList, "{n}.Event.event_name", "ASC");
		}else{
			$EventList = Set::sort($EventList, "{n}.Eventdate.0.date", "DESC");
		}
		return $EventList;
	}
}