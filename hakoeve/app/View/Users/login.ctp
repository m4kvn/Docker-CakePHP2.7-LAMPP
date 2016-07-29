<?php echo $this->Html->css('users'); ?>
<div class="login">
<?php
if($this->Session->check('Message.auth'))
	echo $this->Session->flash('auth');
echo $this->Form->create('User',array('action'=>'login'));
echo $this->Form->input('username',array('label'=>'ユーザ名'));
echo "<br>";
echo $this->Form->input('password',array('label'=>'パスワード'));
?>
</br>
<?php 
echo $this->Form->end('ログイン');
?>
<br>
<?php echo $this->Html->link(__('パスワードを忘れた場合はこちら', true), array('action' => 'forgot')); ?>
</div>