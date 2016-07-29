<?php echo $this->Html->css('view');?>
<?php echo $this->Html->css('magnific-popup');?>
<?php echo $this->Html->css('lightbox');?>
<?php echo $this->Html->script('jquery-1.10.2.min'); ?>
<?php echo $this->Html->script('jquery.magnific-popup.min'); ?>
<?php echo $this->Html->script('lightbox_plus'); ?>
<?php echo $this->Html->css('poster.list');?>

<div class="ajax">
	<div class="img">
	<?php
		if($Image == array()){
			echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0)),'/../hakoeve/events/view/{$Image["EventImage"]["event_id"]}', array
('escape' => false));
		}else{
			echo $this->Html->link($this->upload->uploadImage($Image, 'EventImage.img'),"/../hakoeve/events/view/{$Image["EventImage"]["event_id"]}", array(
'escape' => false));
		}
	?>
	</div>
	<div class="detail">
		<div class="title">
			<?php
			echo h($Event['Event']['event_name']);
			?>
		</div>
		<table>
		<div class="date">
			<tr>
				<td>開催日時</td>
				<td>
				<?php
				$loop = 0;
				 foreach ($Event['Eventdate'] as $date) {
			 		//print_r($date);
			 		if($loop >= 2) break;
					$week = array("日", "月", "火", "水", "木", "金", "土");
					$w = $week[date("w", strtotime(($date['date'])))];
					//print_r($w);
					$day = date('Y年m月d日 ',strtotime($date['date']));
					$time = date('H時i分',strtotime($date['date']));
					if($time == "00時00分") $time = "";
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
	        		$loop++;
				} ?>
				</td>
			</tr>
		</div>
		</table>
		<table>
		<div class="place">
			<tr>
				<td>開催場所</td>
				<td>
				<a class="popup-gmaps" href="https://maps.google.com/maps?q=<?php
					echo h($Event['Venue']['latitude']);?>,<?php
					echo h($Event['Venue']['longitude']); ?>&z=16"><?php
					echo h($Event['Venue']['venue_name']); ?> </a></br>
				</td>
			</tr>
		</div>
		</table>
		<a class="event_view" href="/../hakoeve/events/view/<?php echo $Image["EventImage"]["event_id"]; ?>">
			<div id="detail_link">
				詳細はこちら
			</div>
		</a>
		<div class="recommend">
			<div style="padding-left: 30px; margin-buttom: 25px;">関連イベント</div>
			<div class="recommend_img">
			<?php
			$i = 1;$ImageNum = 0;
			foreach( $recommend as $event ): ?>
			<?php
				$image=str_replace('.', '_original.',$event['Event']['thumbnail_file_name']);
				if(!isset($ReccoImage[$ImageNum]['EventImage'])){
 					echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0)),"/../hakoeve/events/view/{$event['Event']['id']}", array(
'escape' => false, 'class' => 'recommend_space'));

				}else{ echo$this->Html->link($this->upload->uploadImage($ReccoImage[$ImageNum],'EventImage.img'),"/../hakoeve/events/view/
{$event['Event']['id']}", array('escape' => false, 'class' => 'recommend_space')); }
			?>
			<?php $ImageNum++;?>
			<?php endforeach;?>
			</div>
		</div>
	</div>
</div>