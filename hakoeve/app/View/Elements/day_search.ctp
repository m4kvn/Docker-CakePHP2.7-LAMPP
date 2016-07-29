<?php echo $this->Html->css('jCal'); ?>
<?php echo $this->Html->script('jCal'); ?>
<?php echo $this->Html->script('jquery.animate.clip'); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<?php echo $this->Html->script('day_search'); ?>

<div id="day_area" class="close_dayarea">
	<div id="day_calender" >
		<div class="day_calender_title">
			カレンダーから選択
		</div>
		<div class="day_calender_plugin">
		カレンダーから日にちを選んでください
		</div>
		<div id="calender">
			カレンダーをローディング中です
		</div>
	</div>
	<div id="day_span">
 		<div class="day_span_title">
				期間を選択
		</div>
		<div class="day_span_plugin">
			検索したい期間を選んでください
		</div>
			<input type="text" id="datepicker1" />
			〜
			<input type="text" id="datepicker2" />
			<div class="span_clear_area">
				<input type="button" value="クリア" id="span_clear">
			</div>
			<div class="span_search_area">
				<input type="button" value="検索" id="span_search">
			</div>
	</div>
</div>