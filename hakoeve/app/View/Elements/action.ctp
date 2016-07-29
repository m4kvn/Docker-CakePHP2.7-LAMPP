
  <?php
  $cals = array();
   foreach($allEventList as $data){
   	foreach ($data['Eventdate'] as $date) {
   		$cal = str_replace('-', '',$date['date']);
   		if(array_search($cal,$cals)===FALSE)
   			$cals[] = $cal;
   	}
   }
 ?>
<div class="actions">
<br/>

 <?php if($flag==1){?>
<ul><li><div id="right"><?php echo $this->Html->link('HakoEveトップ', array('controller'=>'Events','action' => 'index')); ?></div><br/></li></ul>
<?php 	}?>
<div class="section form_search">

	<?php echo $this->Form->create('Event', array( 'novalidate' => true, 'url' => array_merge(array('action' => 'index'), $this->params['pass']) )); ?>
	<h1>キーワードからイベントを探す</h1>
	<div class="search">
	<?php echo $this->Form->input('keyword', array('placeholder' => '', 'label' => false)); ?>
	</div>
	
	<div class="sub">
<input type="submit" value="検索" >
</div>
	<?php echo $this->Form->end(); ?>
</div><br/>
<h1>開催場所からイベントを探す</h1>
 <div class = "button">
<ul>

<li>	<?php echo $this->Html->link($this->Html->image('map.jpg', array('border' => 0)), array('controller'=>'Venues','action' => 'search'), array('escape' => false)); ?></li>
  </ul>
   </div><br/>
  <h1>ジャンルからイベントを探す</h1>
  <div class = "button">
	<ul>
		<li><?php echo $this->Html->link($this->Html->image('tagsearch.jpg', array('border' => 0)), array('controller'=>'Tags','action' => 'index'), array('escape' => false)); ?></br></li>
	</ul>
	</div>
	<br/>
	<h1>日付からイベントを探す</h1>
<script type="text/javascript">


<?php 
for($i=0;$i<count($cals);$i++){?>
clndrLink["#<?php echo date('Ymd', strtotime($cals[$i])); ?>"] = "href='/hakoeve/eventdates/search/<?php echo date('Ymd', strtotime($cals[$i])); ?>'  ";
<?php }?>
calendar_print(); 

</script>


<br>
<br>
<br>
<ul><li><div id="right"><?php echo $this->Html->link('HakoEveについて', array('controller'=>'Events','action' => 'about')); ?></div><br/></li></ul>

	<style type="text/css">
#calendar{
	width: 250px;
	background: #5E370D;
}
#X_calendar_boxId { }
#sample_3a { }
.X_calendar_table {
	padding-bottom: 10px;
	padding-right: 0px;
	padding-left:0px;
	border: none;
	border-collapse: 0px;
	border-spacing: 0px;
	text-align: center;
	font-size: 100%;
}

.X_calendar_caption {
	width: 220px;
	height: 25px;
	padding-top: 15px;
	margin: 0px 19px 0px -2px;
	color: #474747;
	font-weight: bold;
	background: url(images/side_title.jpg) no-repeat center top;
}

.X_calendar_caption a:link, 
.X_calendar_caption a:link, 
.X_calendar_caption a:link {
	padding: 0px 6px;
	text-decoration: none;
	color: #000;
	font-weight: normal;
}
.X_calendar_caption a:hover {
	color:#FFFFFF;
}
.X_calendar_table td { 
	width: 25px;
	height: 33px;
	padding: 0px;
	border: 1px solid #fafafa;	
	text-align: center;
	vertical-align: middle;
}
.X_calendar_table td a:link, 
.X_calendar_table td a:visited, 
.X_calendar_table td a:active {
	width: 22px;
	height: 12px;
	padding-top: 3px;
	padding-left: 0px;
	padding-right: 0px;
	padding-bottom: 3px;
	text-decoration: underline;
	vertical-align: left;
	color: #598d45;
	font-size: 20px;
	font-weight: bold;
}
.X_calendar_table td a:hover {
	text-decoration: underline;
	color: #2E6F0D;
	backGround-color: d5d5d5;
}
.X_calendar_default {
	backGround-color: #f5f5f5; <!-- 平日の全体の背景 -->
	color:#000;
}
.X_calendar_weeks {
	width: 29px;
	height:25px;
	text-align: center;
	padding: 0px;
	border: 1px solid #fafafa;
	background: #8c5730;
	font-weight: bold;
	font-size: 100%;
	color: #FCC;
}
.X_calendar_weeks2 {
	width: 29px;
	height:25px;
	text-align: center;
	padding: 0px;
	border: 1px solid #fafafa;
	background: #8c5730;
	font-weight: bold;
	font-size: 100%;
	color: #FFF;
}
.X_calendar_weeks3 {
	width: 29px;
	height:25px;
	text-align: center;
	padding: 0px;
	border: 1px solid #fafafa;
	background: #8c5730;
	font-weight: bold;
	font-size: 100%;
	color: #DDF;
}
.X_calendar_holiday {
	color: #000000;
	background:  #f5f5f5; <!-- 日曜・祝日の全体の背景 -->
}
.X_calendar_saturday {
	color: #000;
	background:  #f5f5f5; <!-- 土曜日の全体の背景 -->
}
.X_calendar_none {
	backGround: #f5f5f5; <!-- 何も割り当てられていない日 -->
	color: #aaaaaa;
}
.X_calendar_today {
    border: 1px solid #fa00fa;
	background: #FF5; <!-- 今日の背景色 -->
}

</style>
</div>