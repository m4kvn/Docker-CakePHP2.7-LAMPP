<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">イベント管理</div>
<?php echo $this->element('actionmanage')?>

<div class="view">
	<script type="text/javascript">
function DeleteArc(url,message){
	if(confirm(message)){
		location.href = url;
	}
}
</script>

	<?php echo $this->Html->script('jquery.magnific-popup.min'); ?>
	<?php echo $this->Html->css('magnific-popup');?>
	<?php echo $this->Html->css('event_viewmanage'); ?>

	<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>
	  <div style="font-size: 29px; border-bottom: solid 1px #000; margin-top: 30px;">
	   この内容で登録してもよろしいですか？
	</div>
	<br> <font size='5'><?php echo h($Event['Event']['event_name']); ?> </font>
	<br />

<div class="event_poster">
	<?php
	if($Image == array()) echo '<div class="one_image">';
	else{
		if($Image['EventImage']['img3_file_name']!= '') echo '<div class="three_image">';
		elseif($Image['EventImage']['img2_file_name']!= '') echo '<div class="two_image">';
		else echo '<div class="one_image">';
	}
	?>

	<!-- <h16> --> <?php

	if($Image != array()){
 		$image=str_replace('.', '_original.',$Image['EventImage']['img_file_name']);
	}
/*		$image2=str_replace('.', '_original.',$Image['EventImage']['img2_file_name']);
		$image3=str_replace('.', '_original.',$Image['EventImage']['img3_file_name']);
*/
		if($Image['EventImage']['img_file_name']== '' && $Image['EventImage']['img2_file_name']== '' && $Image['EventImage']['img3_file_name']== ''){
			echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0)),'/../hakoeve/img/noimage.jpg', array('escape' => false,'class' => 'image'));

		}else{// echo $this->Html->image($Image['EventImage']['img']['name']);}
			if($Image['EventImage']['img_file_name']!= ''){
				echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image}", array('escape' => false,'class' => 'image'));
			}
			
			if($Image['EventImage']['img2_file_name']!= ''){
				echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img2'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image}", array('escape' => false,'class' => 'image'));
			} 
			
			if($Image['EventImage']['img3_file_name']!= ''){
				echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img3'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image}", array('escape' => false,'class' => 'image'));
			} 
		}

		echo "</div>";
?> <!-- </h16> -->
</div>

	<script type="text/javascript">
	$('.image').magnificPopup({
    type: 'image'
});
	</script>

	<table style="padding: 0px 0px; word-break: break-all; width: 100%;">
		<TABLE BORDER="1" CELLSPACING="0" CELLPADDING="0" RULES="rows"
			frame="void" width="100%">
			<tr>
				<td style="width: 15%";></td>
				<td></td>
			</tr>
			<tr>
				<td>開催日時</td>
				<td><?php
			 foreach ($Event['Eventdate'] as $date) {
			 	$d = $date['date']['year']."-".$date['date']['month']."-".$date['date']['day'];
			 	$w = $week[date("w", strtotime(($d)))];
				$end_time_str = "";
				if($date['end_time']['hour'] != "") $end_time_str .= $date['end_time']['hour']."時";
				if($date['end_time']['min'] != "") $end_time_str .= $date['end_time']['min']."分";
				echo $date['date']['year']."年".$date['date']['month']."月".$date['date']['day']."日"."(".$w.")"." ".$date['date']['hour']."時".$date['date']['min']."分 ～ ".$end_time_str;
			 	echo "</br>";
			}   ?></td>
			</tr>
			<tr>
				<td>開催場所</td>
				<td><?php
			echo $Venue['Venue']['venue_name'];
			?>
				</td>
			</tr>
			<tr>
				<td>主催者</td>
				<td><?php
				echo $Host['Host']['host_name'];
				?>
				</td>
			</tr>
			<tr>
				<td>連絡先</td>
				<td><?php
				echo $Host['Host']['contact'];
				?>
				</td>
			</tr>
			<tr>
				<td>外部リンク</td>
				<td><?php
				echo h($Event['Event']['link'])
				?>
				</td>
			</tr>
			<tr>
				<td>詳細</td>
				<td><?php
				$report = str_replace('
', '<br/>',$Event['Event']['report']);
echo $report;?>
				</td>
			</tr>
			<tr>
				<td>タグ</td>
				<td><?php
				//print_r($Tag['tag_name']);
				//echo $Tag['tag_name']
				foreach ($Tag as  $value) {
?> <?php echo $value['Tag']['tag_name']?>&nbsp; <?php
	 }
	 ?>
				</td>
			</tr>
			</TABLE>

		</table>


		<?php
		echo $this->Form->create('Event',array('type'=>'file'));
		//print_r($Event['Tag']);
		//ここのhidden達を一括出力するヘルパーがあるけど、Cake2に対応してるか不明なので直書き
		echo $this->Form->hidden('Event.event_name', array('value' => $Event['Event']['event_name']));
		echo $this->Form->hidden('Event.venue_id', array('value' => $Venue['Venue']['id']));
		echo $this->Form->hidden('Event.host_id', array('value' => $Host['Host']['id']));
		echo $this->Form->hidden('Event.link', array('value' => $Event['Event']['link']));
		echo $this->Form->hidden('Event.report', array('value' => $Event['Event']['report']));
		echo $this->Form->hidden('EventImage.id', array('value' => $Image['EventImage']['id']));
		echo $this->Form->hidden('Event.thumbnail.name', array('value' => $Event['Event']['thumbnail'][0]['name']));
		echo $this->Form->hidden('Event.thumbnail.type', array('value' => $Event['Event']['thumbnail'][0]['type']));
		echo $this->Form->hidden('Event.thumbnail.tmp_name', array('value' => $Event['Event']['thumbnail'][0]['tmp_name']));
		echo $this->Form->hidden('Event.thumbnail.error', array('value' => $Event['Event']['thumbnail'][0]['error']));
		echo $this->Form->hidden('Event.thumbnail.size', array('value' => $Event['Event']['thumbnail'][0]['size']));
		$i = 0;
		foreach ($Event['Eventdate'] as $date) {
			echo $this->Form->hidden('Eventdate.'. $i .'.date.year', array('value' => $date['date']['year']));
			echo $this->Form->hidden('Eventdate.'. $i .'.date.month', array('value' => $date['date']['month']));
			echo $this->Form->hidden('Eventdate.'. $i .'.date.day', array('value' => $date['date']['day']));
			echo $this->Form->hidden('Eventdate.'. $i .'.date.hour', array('value' => $date['date']['hour']));
			echo $this->Form->hidden('Eventdate.'. $i .'.date.min', array('value' => $date['date']['min']));
			
			echo $this->Form->hidden('Eventdate.'. $i .'.end_time.hour', array('value' => $date['end_time']['hour']));
			echo $this->Form->hidden('Eventdate.'. $i .'.end_time.min', array('value' => $date['end_time']['min']));
			$i++;
		}
		
$j = 0;
foreach ($Event['Tag']['tag_id'] as  $value) {
echo $this->Form->hidden('Tag.tag_id.'. $j, array('value' => $value));
$j++;
}
		echo $this->Form->hidden('Event.visible',array('value' => $Event['Event']['visible']));
		echo $this->Form->hidden('Event.recommend',array('value' => $Event['Event']['recommend']));
?>
	<table style="length: 400px;; margin: auto;">
		<tr><div style="font-size: 93%;">※画像は「戻る」を押すと、セキュリティの都合上リセットされてしまいますので、ご注意ください。</div><tr>
	
		<tr>
		<?php
		echo "<td>";
		echo $this->Form->submit('戻る', array('name' => 'back', "style" => array("float:right; width: 150px; height:40px; font-size: 130%;")));
		echo "</td><td></td>  <td>";
		// 面倒なのでJavaScriptで戻す。こうすると入力画面に戻っても内容は消えない。
		echo $this->Form->submit('送信', array("name" => "add", "style" => array("float:right; width: 150px; height:40px; font-size: 130%;"))); //押せばsubmitアクションへ
		echo "</td>";
	echo $this->Form->end();
?>
		</tr>
	</table>


		</div>
</div>