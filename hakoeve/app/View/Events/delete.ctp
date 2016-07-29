<?php 
	/*
	 * @author 斉藤篤史
	 * イベント情報を削除するフォームです。
	 */
	echo $this->Form->create(false,array('type'=>'post','action'=>'delete'));
	echo $this->Form->text("Event.id");
	echo $this->Form->end("削除");
?>