<div class="view">

	<!--   <div style="padding: 0px; margin-bottom: -12px; text-align: center;  background: #5E370D;">
   <h6><font size = '5' color = '#ffffff'>イベント一覧</font></h6>
</div>
<br>
<br>
<br> -->
	<head>
<!-- jQueryのためのjsファイル読み込み　flexsliderのためのjs読み込み -->

	<?php echo $this->Html->script("jquery-1.10.2.min", array( 'inline' => false ));?>
	<?php echo $this->Html->script("jquery.flexslider", array( 'inline' => false ));?>
	
	<?php echo $this->Html->css('flexslider');?>


	<?php $week = array("日", "月", "火", "水", "木", "金", "土");
			$eventNum = 0;
			?>
	<div id="slider_area">		
		<div class="flexslider">
			<ul class="slides">

				<?php foreach($recommend/*$eventList*/ as $data): ?>
				<?php if ($data['Event']['visible'] == true && $eventNum < 4): ?>
		
				<li class style="text-align:left; background: #fff;">
						
						<div id=<?php echo "recco_area" . $eventNum;?>>
							<a Href="/hakoeve/events/view/<?php echo $data['Event']['id'];?>"><div id="recc_image_area">
						<div id = "reccomend_image"><?php
						
						if($image[$eventNum]['EventImage']['img_file_name'] == "")
							echo $this->Html->image('noimage.jpg', array('width'=>'210','height'=>'210','border'=>0 , 'style'=>''));
						else 
							echo $this->upload->uploadImage($image[$eventNum], 'EventImage.img');
						 ?></div> 
				<!--	 	<img id="reccomend" src="http://hakomachi.com/hakoeve/upload/events/435/s_20140623204304_00002_original.jpg" width=210px height=210px style="float:left;"></img> -->  
						</div>

	<div id="recc_text_area">
		<h2 id="recc_title">
		<?php
		 if ( mb_strlen( $data['Event']['event_name'] ) > 40 ) {
	 		    echo mb_substr($data['Event']['event_name'],0, 40) . " ...";
			} else {
				echo $data['Event']['event_name'];
	        }						
		?>

		</h2>

		<div id="recc_text" >
			 <?php // foreach($data['Eventdate'] as $date):

// 					$w = $week[date("w", strtotime(($date['date'])))];
// 					$day = date('Y年m月d日',strtotime($date['date']));
// 					if($day[12]==0){
// 							  	$day = substr_replace("$day", " ", 12,1);
//      	 					}
//      	 					if($day[7]==0){
// 								$day = substr_replace("$day", " ", 7,1);
// 							}
// 							$day.="(".$w.")";
					
						$w = $week[date("w", strtotime(($data['Eventdate'][0]['date'])))];
						$day = date('Y年m月d日',strtotime($data['Eventdate'][0]['date']));
						if($day[12]==0){
						 	$day = substr_replace("$day", " ", 12,1);
     	 				}
     	 				if($day[7]==0){
							$day = substr_replace("$day", " ", 7,1);
						}
							$day.="(".$w.")"; 
				?>
	
	
					日時：　<?php echo $day;?><br><br>
			<?php //endforeach; ?>
		
			場所：　<?php
			 if ( mb_strlen( $data['Venue']['venue_name'] ) > 40 ) {
	 		    echo mb_substr($data['Venue']['venue_name'],0, 40) . " ...";
				} else {
				echo $data['Venue']['venue_name'];
		        }						
			?>

			<br><br>
			
			<?php  	$text = explode("内容：", $data['Event']['report']);
					if(isset($text[1]) && $text[1] != ""){
						if ( mb_strlen( $text[1] ) > 20 ) $text = mb_substr($text[1], 0, 20) . "......";
						else $text = $text[1];
					}
					else{
						if ( mb_strlen( $text[0] ) > 20 ) $text = mb_substr($text[0], 0 , 20) . "......";
						else $text = $text[0];
					}
			?>
			詳細：　<?php echo strip_tags($text); ?>
		</div>

	</div>
 
 	<div id=<?php echo "recc_access_tab" . $eventNum;?>>詳しくはこちら</div></a>
	</div>
	</li>
			<?php endif;?>
			<?php $eventNum++;?>
			<?php endforeach; ?>
	
	</body>	
	</ul>

	</div>
</div>
			
<script type="text/javascript" charset="utf-8">

	$(window).load(function() {

	$('.flexslider').flexslider();
		$('.flexslider').flexslider();
		$('.flexslider').css('width', '80%');
		$('.flexslider').css('height', '360');
		$('.flexslider').css('margin', '0px auto');
		$('.flexslider').css('border', 'none');
		$('.flexslider').css('box-shadow', 'none');
	//	$('.flexslider').css('margin-top', '0');
	//	$('.flexslider').css('margin-bottom', '0');
		$('.flexslider').css('background', '#c9caca');
		$('.slides').css('margin', 'auto');
		$('.flex-control-nav').css('bottom' ,'320px');
		$('.flex-control-nav').css('left' ,'990px');
		$('.flex-control-nav').css('width' ,'auto');
		$('.flex-control-nav').css('min-width' ,'100px');
	
		$('.flex-direction-nav li a').css('height' ,'80px');
		$('.flex-direction-nav li a').css('width' ,'51px');
		
		$('.flex-control-nav li a').css('color' ,'#727171');
		$('.flex-control-nav li flex-active').css('color' ,'#ff5514');
		$('.flexslider .slides li').css('width' ,"100%");
		$('.flexslider .slides li').css('height', '284px');
		$('.flexslider .slides li').css('margin-top' ,"44px");
		$('.flexslider .slides li').css('margin-left' ,"0px");
		$('.flexslider .slides li').css('background', '#c9caca');
	//	$('.flexslider .slides li').css('margin' ,"44px auto 0");
		$('.flexslider .slides li img').css('width', 'auto');
		$('.flexslider .slides li img').css('height', '250');
	});

</script>
	<?php echo $this->Html->css('events.index');?>
	
	<div id="lists">
	<!-- 近日開催のイベントの一覧実装部分 -->
	<div class="near">
		<h1 class="title">近日開催のイベント</h1>


		<br />
		<table style="width:100%;">
			<?php $week = array("日", "月", "火", "水", "木", "金", "土");
			$eventNum = 0;
			?>


			<?php foreach($eventList as $data): ?>
			<?php if ($data['Event']['visible'] == true && $eventNum < 10): ?>
			<tr>
				<td class="eventitem"><A class="event"
					Href="/hakoeve/events/view/<?php echo $data['Event']['id'];?>"><B>
							<?php /*echo h($data['Event']['event_name']); */
						 if ( mb_strlen( $data['Event']['event_name'] ) > 45 ) {
           		 		    echo mb_substr($data['Event']['event_name'],0, 45) . " ...";
           					} else {
               				echo $data['Event']['event_name'];
     				        }						
						?>
					</B> </A> <br /> <?php foreach($data['Eventdate'] as $date):

					$w = $week[date("w", strtotime(($date['date'])))];
					$day = date('Y年m月d日',strtotime($date['date']));
					if($day[12]==0){
							  	$day = substr_replace("$day", " ", 12,1);
     	 					}
     	 					if($day[7]==0){
								$day = substr_replace("$day", " ", 7,1);
							}
							$day.="(".$w.")";
							echo "開催日　　" . $day;?> <?php endforeach; ?> <br> <?php
							echo "開催場所　";
							echo h($data['Venue']['venue_name']);
							?>
				</td>
			</tr>

			<?php endif;?>
			<?php $eventNum++;?>
			<?php endforeach; ?>
		</table>
		
		
		
		<a class="more" Href="/hakoeve/events/all/1"><img id="arrow"
			src="/../hakoeve/img/arrow.png" width="10px"
			height="10px" style="width: 13px;min-width: 10px;">もっと見る</a>
	</div>

	<!-- 新着のイベントの一覧実装部分 -->
	<div class="new">
		<h1 class="title">新着のイベント</h1>
		<br>

		<table style="width:100%;">
			<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>
			<?php $eventNum = 0;?>

			<?php foreach($newerEventList as $data): ?>
			<?php if ($data['Event']['visible'] == true && $eventNum < 10): ?>
			<tr>
				<td class="eventitem"><A class="event"
					Href="/hakoeve/events/view/<?php echo $data['Event']['id'];?>"><B>
							<?php /*echo h($data['Event']['event_name']); */
						 if ( mb_strlen( $data['Event']['event_name'] ) > 45 ) {
           		 		    echo mb_substr($data['Event']['event_name'],0, 45) . " ...";
           					} else {
               				echo $data['Event']['event_name'];
     				        }						
							?>
							<?php $i = 0;?>
					</B> </A> <br /> <?php foreach($data['Eventdate'] as $date):
					if($i >= 1){
						echo "...";
						break;
					}

					$w = $week[date("w", strtotime(($date['date'])))];
					$day = date('Y年m月d日',strtotime($date['date']));
					if($day[12]==0){
							  	$day = substr_replace("$day", " ", 12,1);
     	 					}
     	 					if($day[7]==0){
								$day = substr_replace("$day", " ", 7,1);
							}
							$day.="(".$w.")";
							echo "開催日　　" . $day;?><?php $i++; ?> <?php endforeach; ?> <br> <?php
							echo "開催場所　";
							echo h($data['Venue']['venue_name']); ?>
							
				</td>
			</tr>

			<?php endif;?>
			<?php $eventNum++;?>
			<?php endforeach; ?>


		</table>

	</div>
	</div>
</div>
