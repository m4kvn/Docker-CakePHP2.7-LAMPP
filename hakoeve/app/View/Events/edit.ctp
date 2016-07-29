<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">イベント管理</div>
<?php echo $this->element('actionmanage')?>
<div class="view">
<div class="manage_view">
</div>
<?php echo $this->Html->css('event_viewmanage'); ?>
<?php echo $this->Html->css('jquery.datetimepicker'); ?>
<?php echo $this->Html->script('jquery-ui'); ?>
<?php echo $this->Html->script('jquery.datetimepicker'); ?>

  <div style="font-size: 29px; border-bottom: solid 1px #000; margin-top: 30px;">
   イベント編集
</div>

<div style="background-color:#f7f8f8; margin-top: 20px; padding: 20px 20px 50px 20px;">

<style type="text/css">
	.picture {
		background-color: #fff;
		border: solid 1px #000;
	}

	.submit {
		clear: right;
		float: left;
		margin-top: 5px;
	}

	.submit input {
		width:	200px;
		height: 100px;
		font-size: 19px;
	}

	.daytime {
		width: 250px;
	}

</style>

 <?php
	echo $this->Form->create('Event',array('type'=>'file'));
?>

<?php
	$opt = array(
				'label'=>'開始日時',
				'timeFormat'=>'24',
				'dateFormat' => 'YMD',
				'maxYear' => date('Y')+2,
				'minYear' => date('Y'),
				'monthNames' => false,
				'interval'=>'5',
				);
	?>

<script>
var i = 0; //初期入力フォームの数
var Default = i;
window.onload = setNow;

function plus_zero(time){
	if (time < 10) {
		time = '0' + time;
	};
	return time;
}

function setNow(){
	var count = <?php echo count($showDate); ?>;
	var date_array = [];
	var end_time_array = [];
	<?php foreach ($showDate as $date): ?>
		date_array.push("<?php echo $date; ?>");
	<?php endforeach; ?>
	<?php foreach ($showTime as $time): ?>
		end_time_array.push("<?php echo $time; ?>");
	<?php endforeach; ?>
	
	for(var j=0; j< count; j++){
		if(j==0){
			$("#area").append('<div class="input date"><input type="text" name="data[Eventdate][0][date]" id="EventDateIDate" class="daytime" value="'+date_array[j]+'"> ～ <input type="text" name="data[Eventdate][0][end_time]" id="EventDateITime" value="'+end_time_array[j]+'" class="daytime" style = "width: 150px;"></div>\n');
			$("#EventDateIDate").datetimepicker({
				lang: 'ja',
				format: 'Y-m-d H:i',
				step: 5
			});
			$("#EventDateITime").datetimepicker({
				lang: 'ja',
				datepicker:false,
				allowBlank:true,
				format: 'H:i',
				step: 5
			});
		}else{
			$("#area").append('<span id=\"group'+j+'\"><div class="input date"><input type="text" name="data[Eventdate]['+j+'][date]" id="EventDateIDate'+j+'" class="daytime" value="'+date_array[j]+'"> ～ <input type="text" name="data[Eventdate]['+i+'][end_time]" id="EventDateITime'+i+'" value="'+end_time_array[j]+'" class="daytime" style = "width: 150px;"></div></span>\n');
			$("#EventDateIDate"+j).datetimepicker({
				lang: 'ja',
				format: 'Y-m-d H:i',
				step: 5
			});
			$("#EventDateITime"+j).datetimepicker({
				lang: 'ja',
				datepicker:false,
				allowBlank:true,
				format: 'H:i',
				step: 5
			});
		};
		i++;
	};
}

function addInput() { //追加処理
 var day =new Date();
 var yy = day.getFullYear();
 var mm = plus_zero(day.getMonth()+1);
 var dd = plus_zero(day.getDate());
 var hh = plus_zero(day.getHours());
 var mi = plus_zero(day.getMinutes());

 $("#area").append('<span id=\"group'+i+'\"><div class="input date"><input type="text" name="data[Eventdate]['+i+'][date]" id="EventDateIDate'+i+'" value="'+yy+'-'+mm+'-'+dd+' '+hh+':'+mi+'" class="daytime"> ～ <input type="text" name="data[Eventdate]['+i+'][end_time]" id="EventDateITime'+i+'" value="'+hh+':'+mi+'" class="daytime" style = "width: 150px;"></div></span>\n');

 $("#EventDateIDate"+i).datetimepicker({
	lang: 'ja',
	format: 'Y-m-d H:i',
	step: 5
});
$("#EventDateITime"+i).datetimepicker({
	lang: 'ja',
	datepicker:false,
	format: 'H:i',
	step: 5
});

i++;
}

function delInput() { //削除処理
$("#group"+i).remove();
　if(i > Default){
　　i --;
　}
}
</script>
 開催日時
  <fieldset id="area">

  </fieldset>
  <p class="day_control">  <input type="button" onclick="addInput()" value="日時追加" /><br>
    <input type="button" onclick="delInput()" value="日時削除" /></p>

	イベント名<br/>
	<?php
	echo $this->Form->text('Event.event_name');?>
<br><br>
開催場所<br/>
	<?php
	echo $this->Form->text('Event.venue_name', array('value' => $Event['Venue']['venue_name']));
	echo $this->Form->error('Event.venue_name');
	?>
	<br><br/>主催者<br/>

	<?php
	echo $this->Form->text('Event.host_name', array('value' => $Event['Host']['host_name']));
	echo $this->Form->error('Event.host_name');
	?><br/><br>
	外部リンク<br/>
	<?php
	echo $this->Form->text('Event.link', array("value" => $Event['Event']['link'])); ?>
	<br><br>詳細<br/>
	<?php
	echo $this->Form->textarea('Event.report', array("value" => $Event['Event']['report'], "style" => "font-size: 17px;"));?>
    </br>
<div style="font-size : 78%;">※詳細文中にHTMLタグは利用できません。</div>
<br><br/>画像<br/>

	<?php
	echo $this->Form->file('Event.thumbnail.0',array('label' => '画像', "class" => "picture"));
	echo $this->Form->error('Event.thumbnail');

	echo $this->Form->file('Event.thumbnail.1',array('label' => '画像', "class" => "picture"));
	echo $this->Form->error('Event.thumbnail');

	echo $this->Form->file('Event.thumbnail.2',array('label' => '画像', "class" => "picture"));
	echo $this->Form->error('Event.thumbnail');

?>
<br><br>
タグ選択<br/>
<?php echo $this->Html->script('jquery.multicols'); ?>
	<?php
	echo $this->Form->select('Tag.tag_id', $tag, array('multiple'=>'checkbox', 'value' => $selected));
	?>
	<script type="text/javascript">

    	$('div.checkbox').multicols({
        	cols:3
      	});

		$('.header_tag').multicols({
	       	 cols:3
	     });
		
    </script>

<br>状態<br/>
<?php
	echo $this->Form->radio('visible', array('1'=>'公開', '0'=>'非公開'), array('value'=>$Event['Event']['visible'], 'separator'=>"<br/>", 'between'=>'none', 'disabled'=>false, 'legend'=>false));
?>
<br/><br>

TOPページでの推薦<br/>
<?php
	echo $this->Form->radio('recommend', array('1'=>'推薦する', '0'=>'推薦しない'), array('value'=>$Event['Event']['recommend'], 'separator'=>"<br/>", 'between'=>'none', 'disabled'=>false, 'legend'=>false));
?>
<br>
<div class="send" style="float: right;">
	<?php
	echo $this->Form->submit('送信', array( 'style' => "width: 83px;height: 30px;"));
	echo $this->Form->end();
	?>
</div>

</div>

</div>
</div>

<script type="text/javascript">

	var availableVenueTags = [
		<?php
			foreach ($auto_venue as $i) {
				echo "'".$i."',";
			}
		?>
	];

	$("#EventVenueName").autocomplete({
		source: availableVenueTags
	});

	var availableHostTags = [
		<?php
			foreach ($host as $i) {
				echo "'".$i."',";
			}
		?>
	];

	$("#EventHostName").autocomplete({
		source: availableHostTags
	});
</script>