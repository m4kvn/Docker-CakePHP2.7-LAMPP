<?php echo $this->Html->css('manage'); ?>
<?php echo $this->Html->css('tag'); ?>
<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">タグ管理</div>
<?php echo $this->element('actionmanage')?>

	<div class="tag_add">
		<div style="border-bottom: solid 1px #000000; margin-top: 30px;">
		<font color = '#000000' style="font-size: 29px;">タグ編集</font>
		</div>
<br>
<?php
	/*
	 * @author 斉藤篤史
	 * タグ情報を変更する入力ホーム
	 */
	echo $this->Form->create('Tag',array('type'=>'file'));
	echo $this->Form->input('Tag.tag_name',array('label' => 'タグ名'));
	echo "<br>";
	echo $this->Form->input('Tag.priority',array('label' => '優先度'));
	?>
	</br>
	<?php
	echo $this->Form->end('送信');
?>

</div>
</div>