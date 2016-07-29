<?php echo $this->Html->css('users'); ?>
<div class="add">
<?php
echo $this->Form->create('User',array('action'=>'add'));
echo $this->Form->input('username');
echo "<br>";
echo $this->Form->input('password');
echo "<br>";
echo $this->Form->end('登録');
?>
</div>