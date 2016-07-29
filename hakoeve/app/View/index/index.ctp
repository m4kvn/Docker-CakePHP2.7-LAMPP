<div class="section form_search">

<h2>検索項目</h2>
	<?php echo $this->Form->create('Event', array( 'novalidate' => true, 'url' => array_merge(array('action' => 'index'), $this->params['pass']) )); ?>
	
	<h3>キーワード</h3>
	<?php echo $this->Form->input('event_name', array('placeholder' => '例）キーワードを入力して下さい。　※フリガナ可', 'label' => false)); ?>
	
	</div>