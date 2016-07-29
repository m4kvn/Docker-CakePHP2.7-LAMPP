<?php echo $this->Html->css('users'); ?>
<div class="forgot">
<div>パスワードの再発行を行います。ユーザ名を入力して下さい。</div>
<?php
echo $this->Form->create('User',array('action'=>'forgot'));
echo "<br>";
echo $this->Form->input('username',array('label'=>'ユーザ名'));
echo "<br>";
echo $this->Form->end('パスワード再発行');
?>
<br>
<?php echo $this->Html->link(__('ログインページへ', true), array('action' => 'login')); ?>
</div>