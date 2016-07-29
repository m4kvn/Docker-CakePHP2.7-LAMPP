<?php
App::uses('AppController', 'Controller');

class PastsController extends AppController{
    public $name = 'Pasts';
	public $uses = array('Event', 'Past', 'Venue', 'Host', 'Tag', 'Eventdate','EventImage');
	//検索用の変数準備
//	public $components = array('Search.Prg','Auth', 'Email');
//	public $presetVars = true;
//	public $paginate = array();
    
    public function test(){
        date_default_timezone_set('Asia/Tokyo');
        $not = $this->Eventdate->getEventIdListAfterToday();
        $exception = "";
        /* SQLを記述(CakePHPのsaveメソッド等では手間and冗長になりそうだったため、SQLで操作)*/
        $insert = "INSERT INTO pasts SELECT * FROM events ";
        $delete = "DELETE FROM events ";
        
        $sql = "WHERE id NOT IN (";
        
        foreach($not as $id => $val){
            $exception .= '"' . $val . '"' . ",";
        }
        $exception = substr($exception, 0, -1); //最後の','を削除
        $sql .= $exception . ")"; 
        
        /* Eventテーブルのみ移行させるため、一時的に外部キー制約を無効化 */
        $this->Event->query("SET FOREIGN_KEY_CHECKS = 0");
        
        $this->Event->query($insert . $sql);
        $this->Event->query($delete . $sql);
        
        $this->Event->query("SET FOREIGN_KEY_CHECKS = 1");
    }
    
    public function index(){
        $date = date('Y-m-01');
        $list = $this->Eventdate->findEventIdListByDateString ( $date );
        
        $finds = $this->Past->findByEventIdList($list);
        
        $result = array();
        foreach($finds as $key => $value ){
            $result[$key] = array('Event' => $value['Past']);
            $result[$key] += array('Venue' => $value['Venue']);
            $result[$key] += array('Host' => $value['Host']);
            $result[$key] += array('Eventdate' => $value['Eventdate']);
            $result[$key] += array('Tag' => $value['Tag']);
        }
        
        $this->set('date', $result);
    }
}