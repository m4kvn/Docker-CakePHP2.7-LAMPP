<?php echo $this->Html->css('manage'); ?>
<?php echo $this->Html->css('host'); ?>
<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">主催者管理</div>
<?php echo $this->element('actionmanage')?>

	<div class="host_add">
  <div style="border-bottom: solid 1px #000000; margin-top: 30px;">
  <font color = '#000000' style="font-size: 22px;">主催者編集</font>
</div>
<br>
<?php
	/*
	 * @author 斉藤篤史
	 * 主催者情報を変更する入力ホーム
	 */
	echo $this->Form->create('Host',array('type'=>'file'));
	echo $this->Form->input('Host.host_name',array('label' => '主催者名'));
	echo "<br>";
	echo $this->Form->input('Host.address',array('label' => '住所'));
	echo "<br>";
	echo $this->Form->input('Host.contact',array('label' => '連絡先'));
	echo "<br>";
	echo $this->Form->input('Host.priority',array('label' => '優先度'));
	?>
	<br>
	<?php
	echo $this->Form->end('送信');
?>

</div>
</div>