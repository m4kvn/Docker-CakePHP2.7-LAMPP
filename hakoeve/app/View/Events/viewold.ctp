<div class="view">

<?php echo $this->Html->script('jquery-1.10.2.min'); ?>
<?php echo $this->Html->script('jquery.magnific-popup.min'); ?>
<?php echo $this->Html->script('lightbox_plus'); ?>
<?php echo $this->Html->css('magnific-popup');?>
<?php echo $this->Html->css('lightbox');?>
<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>
  <div style="padding: 0px; margin-bottom: -12px; text-align: center;  background: #5E370D;">
   <h6><font size = '5' color = '#ffffff'>イベント詳細</font></h6>

</div>
<br>
<div class='new'>

<?php if($Event['Event']['visible']!=0) {?>
  <?php if($Event['Event']['markFlag']==0){ echo $this->Html->image('new.png');
  }else if($Event['Event']['markFlag']==1){  echo $this->Html->image('up.png'); }?>
  </div>
<font size = '5'><?php echo h($Event['Event']['event_name']); ?></font>
<br/>
	<?php 
	if($Image == array()) echo "<h14>";
	else{
		if($Image['EventImage']['img3_file_name']!= '') echo "<h16>";
		elseif($Image['EventImage']['img2_file_name']!= '') echo "<h15>";
		else echo "<h14>";
	}
	?>

	<!-- <h16> --> <?php 

	if($Image != array()){	
 		$image=str_replace('.', '_original.',$Image['EventImage']['img_file_name']);
	}
/*		$image2=str_replace('.', '_original.',$Image['EventImage']['img2_file_name']);
		$image3=str_replace('.', '_original.',$Image['EventImage']['img3_file_name']);
*/		
		if($Image == array()/*$Image['EventImage']['img_file_name']== ''*/){
			echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0)),'/../hakoeve/img/noimage.jpg', array('escape' => false, 'rel' => 'lightbox'));		
		}else{// echo $this->Html->image($Image['EventImage']['img']['name']);}
			echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image}", array('escape' => false, 'rel' => 'lightbox'));
			if($Image['EventImage']['img2_file_name']!= ''){
				echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img2'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image}", array('escape' => false, 'rel' => 'lightbox'));
			}
			if($Image['EventImage']['img3_file_name']!= ''){
				echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img3'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image}", array('escape' => false, 'rel' => 'lightbox'));
			}
		}		
		if($Image == array()) echo "</h14>";
		else{
			if($Image['EventImage']['img3_file_name']!= '') echo "</h16>";
			elseif($Image['EventImage']['img2_file_name']!= '') echo "</h15>";
			else echo "</h14>";
		}
?> <!-- </h16> -->
	<!-- magnific-popup.cssでスタイルシートの定義を行ってください -->
	<script type="text/javascript">
	$('.image').magnificPopup({
		type: 'iframe',
		iframe: {
			  markup: '<div class="mfp-iframe-scaler">'+
	          '<div class="mfp-close"></div>'+
	          '<iframe class="mfp-iframe" frameborder="0" marginwidth="275px"></iframe>'+
	          '</div>',
	        },
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
			<td style="vertical-align: top;">開催日時</td>
			<td><?php
			 foreach ($Event['Eventdate'] as $date) {


   $w = $week[date("w", strtotime(($date['date'])))];
   $day = date('Y年m月d日 H時i分',strtotime($date['date']));
   if($day[12]==0){
   	$day = substr_replace("$day", " ", 12,1);
   }
   if($day[7]==0){
   	$day = substr_replace("$day", " ", 7,1);
   }
      	echo $day.="(".$w.")";

				echo "</br>";
			}   ?>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">開催場所</td>
			<td>
			<a class="popup-gmaps" href="https://maps.google.com/maps?q=<?php
			echo h($Event['Venue']['latitude']); ?>,<?php
			echo h($Event['Venue']['longitude']); ?>&z=16"><?php
			echo h($Event['Venue']['venue_name']); ?> </a>

<script type="text/javascript">
$('.popup-gmaps').magnificPopup({
	disableOn: 700,
	type: 'iframe',
	mainClass: 'mfp-fade',
	removalDelay: 160,
	preloader: false,

	fixedContentPos: false
});
</script>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">所在地</td>
			<td><?php
			echo h($Event['Venue']['address']); ?>
			</td>
		</tr>

		<tr>

			<td style="vertical-align: top;">主催者</td>
			<td><?php


			echo h($Event['Host']['host_name']); ?>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">連絡先</td>
			<td><?php
			echo h($Event['Host']['contact']); ?>
			</td>
		</tr>

		<tr>
			<td style="vertical-align: top;">詳細</td>
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

	 	<a Href="/hakoeve/tags/search/<?php echo $value['id']?>"><?php echo $value['tag_name']?></a>&nbsp;
　
	<?php
	 }
?>

			</td>
		</tr>
		<?php if(h($Event['Event']['link']!=null)){?>
		<tr>
			<td>
			<a Href="<?php echo h($Event['Event']['link']); ?>">外部リンク</a>
			</td>
		</tr>
		<?php }?>
	</table>


<br><br><br>
	<div
		style="padding: 0px; margin-bottom: -12px; text-align: center; background: #5E370D;">
		<h7> <font size='5' color = '#ffffff'>おすすめのイベント   </font></h7>

	</div>
</br>

	<?php foreach( $recommend as $event ): ?>
	<div class="image"><?php

	$image=str_replace('.', '_original.',$event['Event']['thumbnail_file_name']);
	if($event['Event']['thumbnail_file_name']== ''){
		 echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0)),"/../hakoeve/events/view/{$event['Event']['id']}", array('escape' => false));

	}else{ echo$this->Html->link($this->upload->uploadImage($event['Event'],'Event.thumbnail'),"/../hakoeve/events/view/{$event['Event']['id']}", array('escape' => false)); }

	?> </div>

	<h9>
	<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>
	<table >
	 <TABLE BORDER="1" CELLSPACING="0" CELLPADDING="0" RULES="rows" frame="void" width="69%">
		<tr>

		<th colspan="2">
			<div class='new'>
  <?php if($event['Event']['markFlag']==0){ echo $this->Html->image('new.png');
  }else if($event['Event']['markFlag']==1){  echo $this->Html->image('up.png'); }?>
  </div>
<font color='blue' size='4'><a href="/hakoeve/events/view/<?php echo $event['Event']['id'];?>"><?php echo h($event['Event']['event_name']);?></a></font></th>
		</tr>
		<tr>
			<td style="vertical-align: top; width:85px;">開催日時</td>
			<td><?php foreach ($event['Eventdate'] as $date) {

  $w = $week[date("w", strtotime(($date['date'])))];
   $day = date('Y年m月d日',strtotime($date['date']));
   if($day[12]==0){
   	$day = substr_replace("$day", " ", 12,1);
   }
   if($day[7]==0){
   	$day = substr_replace("$day", " ", 7,1);
   }
      	echo $day.="(".$w.")";
				echo "</br>";
			}   ?>


			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">開催場所</td>
			<td><?php echo $event['Venue']['venue_name']; ?>
			</td>
		</tr>
			<td>タグ</td>
			<td><?php

			foreach ($event['Tag'] as  $value) {
?>

	 	<a Href="/hakoeve/tags/search/<?php echo $value['id']?>"><?php echo $value['tag_name']?></a>&nbsp;
　
	<?php
	 }
?>
			</td>
		</tr>
				</tr>
<tr>
		<td><a href="/hakoeve/events/view/<?php echo $event['Event']['id'];?>">詳細はこちら</a>

		</td>

	</tr>
	</table></h9>
	<?php endforeach;?>
<?php } else { ?>
	<br>
	<h1><font size = 5>※このイベントは非公開設定にされています</font></h1>
	</table>
	</h9>
	</table>
	</div>
<?php }?>


</div>
<?php echo $this->element('action',array("flag"=>1));?>
<br><br>
