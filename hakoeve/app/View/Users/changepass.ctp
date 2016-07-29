<h3>パスワード変更</h3>
<?php
 echo $this->Form->create('Changepassword');
 echo $this->Form->input('oldpassword',array('label'=> '現在のパスワード','type' => 'password','value'=>''));
 echo $this->Form->input('newpassword',array('label'=>'新しいパスワード','type' => 'password','value'=>''));
 echo $this->Form->input('newpassword2',array('label'=>'新しいパスワード（もう一度）','type' => 'password','value'=>''));
 echo $this->Form->end('パスワードを変更');
 
 ?>
