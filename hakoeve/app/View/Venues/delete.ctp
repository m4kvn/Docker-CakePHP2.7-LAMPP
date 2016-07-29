<?php
	/*
	 * @author 斉藤篤史
	 * 場所情報を削除するフォームです
	 */
	echo $this->Form->create(false,array('type'=>'post','action'=>'delete'));
	echo $this->Form->text("Venue.id");
	echo $this->Form->end("削除");
?>