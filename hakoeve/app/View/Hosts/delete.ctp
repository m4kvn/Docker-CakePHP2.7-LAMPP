<?php 
	/*
	 * @author 斉藤篤史
	　* 主催者情報を削除するフォームです
	　*/
	echo $this->Form->create(false,array('type'=>'post','action'=>'delete'));
	echo $this->Form->text("Host.id");
	echo $this->Form->end("削除");
?>