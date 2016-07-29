<?php
App::uses('PastsController', 'Controller');
 
class EndShell extends AppShell{
    public $uses = array('Past');
    public $useDbConfig = 'local';
    
    function startup(){
        parent::startup();
 
        // コントローラー設定
        $this->PastsController = new PastsController();
    }
 
    public function test(){
        $this->out($this->PastsController->test());
    }
    
}

?>