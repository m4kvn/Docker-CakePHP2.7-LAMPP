<?php echo $this->Html->css('manage'); ?>
<?php echo $this->Html->css('venue'); ?>
<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">開催場所管理</div>
<?php echo $this->element('actionmanage')?>

	<div class="venue_add">
  <div style="border-bottom: solid 1px #000000; margin-top: 30px;">
  <font color = '#000000' style="font-size: 22px;">開催場所追加</font>
</div>
<br>
<?php
/*
 * @author 斉藤篤史
 * 場所名と住所を入力するViewファイルです。
 */
echo $this->Form->create('Venue');
echo $this->Form->input('venue_name',array('label'=>'名前'));
echo "<br>";
echo $this->Form->input('address',array('label'=>'住所'));
echo "<br>";
echo $this->Form->input('priority',array('label'=>'優先度'));
?>
</br>
<?php
echo $this->Form->end("追加");
?>
</div>
</div>