<?php echo $this->Html->css('view');?>
<?php echo $this->Html->css('magnific-popup');?>
<?php echo $this->Html->css('lightbox');?>
<?php echo $this->Html->script('jquery-1.10.2.min'); ?>
<?php echo $this->Html->script('jquery.magnific-popup.min'); ?>
<?php echo $this->Html->script('lightbox_plus'); ?>

<div class="event_detail">
	<div class="content_event">
		イベント詳細
	</div>
	<div class="event_title">
		<div class='new'>
		<?php if($Event['Event']['markFlag']==0){ echo $this->Html->image('new.png');
		}else if($Event['Event']['markFlag']==1){  echo $this->Html->image('up.png'); }
		?>
		</div>
		<?php echo h($Event['Event']['event_name']); ?>
	</div>
	<div class="event_poster">
	<?php
	if($Image == array()) echo '<div class="one_image">';
	else{
		if($Image['EventImage']['img3_file_name']!= '') echo '<div class="three_image">';
		elseif($Image['EventImage']['img2_file_name']!= '') echo '<div class="two_image">';
		else echo '<div class="one_image">';
	}
	?>

<?php
	if($Image != array()){
 		$image=str_replace('.', '_original.',$Image['EventImage']['img_file_name']);

		$image2=str_replace('.', '_original.',$Image['EventImage']['img2_file_name']);
		$image3=str_replace('.', '_original.',$Image['EventImage']['img3_file_name']);
		}
		//print_r($Image);
		if(/*$Image == array()*/$Image['EventImage']['img_file_name']== ''){
			echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0)),'/../hakoeve/img/noimage.jpg', array('escape' => false, 'rel' => 'lightbox'));
		}else{// echo $this->Html->image($Image['EventImage']['img']['name']);}
			echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image}", array('escape' => false, 'rel' => 'lightbox'));
			if($Image['EventImage']['img2_file_name']!= ''){
				echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img2'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image2}", array('escape' => false, 'rel' => 'lightbox'));
			}
			if($Image['EventImage']['img3_file_name']!= ''){
				echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img3'),"/../hakoeve/upload/event_images/{$Image['EventImage']['id']}/{$image3}", array('escape' => false, 'rel' => 'lightbox'));
			}
		}
		echo '</sdiv>'
?>
	</div><!-- poster -->
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
	<table class="detail">
		<tr>
			<td class="event_day">
			開催日時
			</td>
			<td class="event_day">
			<?php
	 foreach ($Event['Eventdate'] as $date) {

	 	//print_r($date);
		   $week = array("日", "月", "火", "水", "木", "金", "土");
		   $w = $week[date("w", strtotime(($date['date'])))];
		   //print_r($w);
		   $day = date('Y年m月d日 ',strtotime($date['date']));
		   $time = date('H時i分',strtotime($date['date']));
		   if($time == "00時00分") $time = "";
		   $end_time = "";
		   if($date['end_time'] != null) $end_time = date('H時i分',strtotime($date['end_time']));
		   if($end_time == "00時00分") $end_time = "";
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
			<td class="event_place">
			開催場所
			</td>
			<td class="event_place">
				<a class="popup-gmaps" href="https://maps.google.com/maps?q=<?php
				echo urlencode($Event['Venue']['address']);?><?php
			//	echo h($Event['Venue']['latitude']);?><?php
			//	echo h($Event['Venue']['longitude']); ?>&z=16"><?php
				echo h($Event['Venue']['venue_name']); ?> </a></br>
				(<?php echo h($Event['Venue']['address']); ?>)
			</td>
		</tr>
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

	<tr>
		<td class="event_organizer">
		主催者
		</td>
		<td class="event_organizer">
		<?php echo h($Event['Host']['host_name']); ?>
		</td>
	</tr>

	<tr>
		<td class="event_contact">
		連絡先
		</td>
		<td class="event_contact">
		<?php echo h($Event['Host']['contact']); ?>
		</td>
	</tr>

	<tr>
		<td class="event_text">
		詳細
		</td>
		<td class="event_text">
		<pre><?php
			$report = $Event['Event']['report'];
echo $report;?></pre>
		</td>
	</tr>

	<tr>
		<td class="event_tag">
		ジャンル
		</td>
		<td class="event_tag">
		<?php foreach ($Event['Tag'] as  $value) { ?>
	 		<a Href="/hakoeve/tags/search/?id=1&tagid%5B0%5D=<?php echo $value['id']?>"><?php echo $value['tag_name']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php } ?>
		</td>
	</tr>
	</table>
	<div class="event_link">
		<?php if(h($Event['Event']['link']!=null)){?>
		<a href="<?php echo h($Event['Event']['link']); ?>">外部リンク</a>
		<?php }?>
	</div>
</div>
<!-- .event_detail -->


<script type="text/javascript">
$(function(){
	$(window).load(function(){
	    var biggestHeight = "0";
	    $(".recommend_area1").each(function(){
	        if ($(this).height() > biggestHeight ) {
	            biggestHeight = $(this).height()
	        }
	    });
	    $(".recommend_area2").each(function(){
	        if ($(this).height() > biggestHeight ) {
	            biggestHeight = $(this).height()
	        }
	    });
	    $(".recommend_area3").each(function(){
	        if ($(this).height() > biggestHeight ) {
	            biggestHeight = $(this).height()
	        }
	    });
	    $(".recommend_detail").height(biggestHeight);
	});
});
</script>

<div class="event_recommend">
	<div class="recommend_title">
		あなたにおすすめのイベント
	</div>
	<div class="recommend_detail">
		<?php
		$i = 1;$ImageNum = 0;
		foreach( $recommend as $event ): ?>
			<div class="recommend_area<?php echo $i++; ?>">
				<div class="image" style="width: 300px;">
					<?php
						$image=str_replace('.', '_original.',$event['Event']['thumbnail_file_name']);
						if(!isset($ReccoImage[$ImageNum]['EventImage'])){
		 					echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0, 'class' => 'recommend_img')),"/../hakoeve/events/view/{$event['Event']['id']}", array('escape' => false));

						}else{ echo$this->Html->link($this->upload->uploadImage($ReccoImage[$ImageNum],'EventImage.img'),"/../hakoeve/events/view/{$event['Event']['id']}", array('escape' => false)); }
					?>
				</div>
				<table style="width: 270px;">
					<tr>
						<td colspan="2">
							<a href="/hakoeve/events/view/<?php echo $event['Event']['id'];?>" style="font-size:17px;"><?php echo h($event['Event']['event_name']);?></a>
						</td>
					</tr>
					<tr>
						<td class="event_day">開催日</td>
						<td class="event_day" style="font-size: 13px;">
								<?php
									$j = 0;
			 						foreach ($event['Eventdate'] as $date) {
				   						if($j < 5) {
				   						$week = array("日", "月", "火", "水", "木", "金", "土");
				   						$w = $week[date("w", strtotime(($date['date'])))];
				   						$day = date('Y年m月d日',strtotime($date['date']));
				   						if($day[12]==0){
				   							$day = substr_replace("$day", " ", 12,1);
				   						}
				   						if($day[7]==0){
				   							$day = substr_replace("$day", " ", 7,1);
				   						}
				      					echo $day.="(".$w.")";
		        						if($j == 4) echo " ......";
		        						echo "</br>";
		        						//$day = date('H時i分',strtotime($date['date']));
		        						//echo $day."〜";
		        						//echo "</br>";
		        						}
		        						$j++;
									}
								?>
						</td>
					</tr>
					<tr>
						<td class="event_place">開催場所</td>
						<td class="event_place" style="font-size: 13px;"><?php echo h($event['Venue']['venue_name']); ?>
					</tr>
					<tr>
						<td class="event_place">ジャンル</td>
						<td class="event_place" style="font-size: 13px;">
							<?php foreach ($event['Tag'] as  $value) { ?>
							<a Href="/hakoeve/tags/search/?id=1&tagid%5B0%5D=<?php echo $value['id']?>"><?php echo $value['tag_name']?></a><br>
							<?php } ?>
						</td>
					</tr>
				</table>
				<div class="recommend_link" style="height:100%;">
					<a href="/hakoeve/events/view/<?php echo $event['Event']['id'];?>">詳細情報</a>
				</div>
			</div>
			<?php $ImageNum++;?>
		<?php endforeach;?>
	</div>
</div><!-- .event_recommend -->