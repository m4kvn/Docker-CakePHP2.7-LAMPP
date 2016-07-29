<?php echo $this->Html->css('manage'); ?>
<?php echo $this->Html->css('host'); ?>
<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">主催者管理</div>
<?php echo $this->element('actionmanage'); ?>

	<div class="host_add">
  <div style="border-bottom: solid 1px #000000; margin-top: 30px;">
  <font color = '#000000' style="font-size: 22px;">主催者追加</font>
</div>
<br>
<?php
/*
 * @author 菅野久樹
 * 主催者を入力するフォームです。
 */
echo $this->Form->create('Host');
echo $this->Form->input('host_name',array('label'=>'主催者名'));
echo "<br>";
echo $this->Form->input('address',array('label'=>'住所'));
echo "<br>";
echo $this->Form->input('contact',array('label'=>'連絡先'));
echo "<br>";
echo $this->Form->input('priority',array('label'=>'優先度'));
?>
</br>
<?php
echo $this->Form->end("追加");
?>
</div>
</div>