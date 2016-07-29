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


  <div style="font-size: 29px; border-bottom: solid 1px #000; margin-top: 30px;">
   イベント詳細
</div>
<br>

<div style="word-break: break-all; "><font font size = '5';>
	<?php echo h($Event['Event']['event_name']); ?>
</font></div>
<br/>
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
		if($Image['EventImage']['img_file_name']== ''){
			echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0)),'/../hakoeve/img/noimage.jpg', array('escape' => false,'class' => 'image'));

		}else{// echo $this->Html->image($Image['EventImage']['img']['name']);}
			echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image}", array('escape' => false,'class' => 'image'));
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
	<table style="padding: 0px 0px;word-break:break-all;width:100%;">
 <TABLE BORDER="1" CELLSPACING="0" CELLPADDING="0" RULES="rows" frame="void" width="100%">
		<tr>
			<td style="width:15%";></td>
			<td>
			</td>
		</tr>
		<tr>
			<td>開催日時</td>
			<td>
	<?php
	 foreach ($Event['Eventdate'] as $date) {

	 	//print_r($date);
		   $week = array("日", "月", "火", "水", "木", "金", "土");
		   $w = $week[date("w", strtotime(($date['date'])))];
		   //print_r($w);
		   $day = date('Y年m月d日 ',strtotime($date['date']));
		   $time = date('H時i分',strtotime($date['date']));
		   $end_time = "";
		   if($date['end_time'] != null) $end_time = date('H時i分',strtotime($date['end_time']));
		   if($day[12]==0){
		   	$day = substr_replace("$day", " ", 12,1);
		   }
		   if($day[7]==0){
		   	$day = substr_replace("$day", " ", 7,1);
		   }
		      	echo $day . "(" . $w . ") " . $time . " ～ " . $end_time;

        			echo "</br>";
			} ?>
			</td>
		</tr>
		<tr>
			<td>開催場所</td>
			<td><?php
			echo h($Event['Venue']['venue_name']); ?>
			</td>
		</tr>
		<tr>
			<td>主催者</td>
			<td><?php


			echo h($Event['Host']['host_name']); ?>
			</td>
		</tr>
		<tr>
			<td>連絡先</td>
			<td><?php
			echo h($Event['Host']['contact']); ?>
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

			foreach ($Event['Tag'] as  $value) {
?>

<?php echo $value['tag_name']?>&nbsp;
　
	<?php
	 }
?>

			</td>
		</tr>
</TABLE>
	</table>

<btn>

 <a href="/hakoeve/events/edit/<?php echo $Event['Event']['id']?>" class="css_btn_class">イベント編集</a>
 <a href="javascript:DeleteArc('/hakoeve/events/delete/<?php echo $Event['Event']['id']?>','本当に削除しますか？');" class="css_btn_class">イベント削除</a>

 </btn>
<?php if($Event['Event']['visible']==0) {?>
<h1><font size = 3>※このイベントは非公開設定にされています</font></h1>
<?php }?>

	</div>
</div>