<?php echo $this->Html->css("events.all");?>
<div id="event_all">
	<div id="page_title">
	イベント一覧
	</div>

	<div id="page_subtitle">
	<?php $firstDate = $eventList[0]['Eventdate'][0]['date'];
		  $day = date('m月d日',strtotime($firstDate));
	//	  if($day[0]==0){
	//		$day = substr_replace("$day", "", 0,1);
	//	  }
	//	  if($day[4]==0){
	//	  	$day = substr_replace("$day", "", 4,1);
	//	  }
	?>
		<div style="font-weight: bold; float:left;"><?php echo $day;?></div> 以降のイベント
	</div>
	<div class="page_select_area">
		<div class="event_num">
			全<?php echo $eventNum;?>件中　　<?php echo count($eventList);?>件表示
		</div>

		<div class="select_area">
			<TABLE style="padding:0;">
				<tr style="padding:0;">
					<?php if($id > 1){?>
					<td class="pages"><a class="page" href="/hakoeve/events/all/<?php echo $id - 1;?><?php if(isset($sort)) echo "&?sort=".$sort?>">＜前へ</a></td>
					<?php }else{?>
					<td class="pages"><a class="page" style=" background-color: #9fa0a0; color:#fff;">＜前へ</a></td>
					<?php } ?>
						<?php
						if(ceil($eventNum / 100/*表示件数*/) <= 5){
							for($i = 1; $i <= ceil($eventNum / 100/*表示件数*/); $i++){
								if($i != $id){
								?>   <td class="pages"><a class="page" href="/hakoeve/events/all/<?php echo $i;?><?php if(isset($sort)) echo "&?sort=".$sort;?>"><?php echo $i;?></a></td>
					<?php		}else{ ?>
									<td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
					<?php		}
							}
						}else{
							$p = 0;
							if($id < 5) $p = 1;
							elseif($id >= ceil($eventNum / 100/*表示件数*/ ) - 2) $p = ceil($eventNum / 100/*表示件数*/ )- 4;
							else $p = $id - 2;

						 	for($i = $p; $i < $p + 5; $i++){ //5つだけページを表示
							 ?>
						 <?php
									if($i != $id){	?>
										<td class="pages"><a class="page" href="/hakoeve/events/all/<?php echo $i;?><?php if(isset($sort)) echo "&?sort=".$sort?>"><?php echo $i;?></a></td>
						<?php	 	}else{ ?>
										<td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
						<?php		}


							}
						}
						?>
					<?php if($id < ceil($eventNum / 100)){ ?>
						<td class="pages" style="padding-right:0;"><a class="page" href="/hakoeve/events/all/<?php echo $id + 1;?><?php if(isset($sort)) echo "&?sort=".$sort?>">次へ＞</a></td>
					<?php }else{ ?>
						<td class="pages" style="padding-right:0;"><a class="page" style="background-color: #9fa0a0; color:#fff;">次へ＞</a></td>
					<?php } ?>
				</tr>
			</TABLE>

		</div>
	</div>
<!--
	<div id="sort_area">
	<!--<label for="poster_list_submenu_sort" id="sort_label">表示順序：</label>
				<select id="poster_list_submenu_sort" onChange="location.href=value;">
					<option value="#">表示順序を選んでください</option>
					<option value="http://localhost/hakoeve/events/all/1?sort=1">開催日時が早い順</option>
					<option value="http://localhost/hakoeve/events/all/1?sort=0">開催日時が遅い順</option>
					<option value="http://localhost/hakoeve/events/all/1?sort=2">五十音順</option>
				</select>-->
	</div>

	<div id="event_list">
		<TABLE style="width: 100%;">
			<tr>
				<th>日付</th>

				<th>イベント名</th>

				<th>開催場所</th>
			</tr>

			<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>
			<?php foreach ($eventList as $data):?>
				<tr>
					<td width="180px">
						<?php foreach($data['Eventdate'] as $date):

							$w = $week[date("w", strtotime(($date['date'])))];
							$day = date('Y年m月d日',strtotime($date['date']));
							if($day[12]==0){
									  	$day = substr_replace("$day", " ", 12,1);
     	 					}
     	 					if($day[7]==0){
								$day = substr_replace("$day", " ", 7,1);
							}
							$day.="(".$w.")";
							echo $day;?>
						<?php endforeach; ?>
					</td>

					<td style="width=80px">
						<a href="/hakoeve/events/view/<?php echo $data['Event']['id'];?>">
						<?php
						 if ( mb_strlen( $data['Event']['event_name'] ) > 40 ) {
           		 		    echo mb_substr($data['Event']['event_name'],0, 40) . " ...";
           					} else {
               				echo $data['Event']['event_name'];
     				        }
						?>
					</a>
					</td>

					<td style="width: 20%;">
						<?php
						 if ( mb_strlen( $data['Venue']['venue_name'] ) > 40 ) {
           		 		    echo mb_substr($data['Venue']['venue_name'],0, 40) . " ...";
           					} else {
               				echo $data['Venue']['venue_name'];
     				        }
						?>
					</td>
				</tr>
			<?php 	endforeach;?>

		</TABLE>
		</div>

		<div class="page_select_area">
		<div class="event_num">
			全<?php echo $eventNum;?>件中　　<?php echo count($eventList);?>件表示
		</div>


			<TABLE style="padding:0,;margin:100px,0px,0px,0px; float:right;">
				<tr style="padding:0;">
					<?php if($id > 1){?>
					<td class="pages"><a class="page" href="/hakoeve/events/all/<?php echo $id - 1;?>">＜前へ</a></td>
					<?php }else{?>
					<td class="pages"><a class="page" style=" background-color: #9fa0a0; color:#fff;">＜前へ</a></td>
					<?php } ?>
						<?php
						if(ceil($eventNum / 100/*表示件数*/) <= 5){
							for($i = 1; $i <= ceil($eventNum / 100/*表示件数*/); $i++){
								if($i != $id){
								?>   <td class="pages"><a class="page" href="/hakoeve/events/all/<?php echo $i;?>"><?php echo $i;?></a></td>
					<?php		}else{ ?>
									<td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
					<?php		}
							}
						}else{
							$p = 0;
							if($id < 5) $p = 1;
							elseif($id >= ceil($eventNum / 100/*表示件数*/ ) - 2) $p = ceil($eventNum / 100/*表示件数*/ )- 4;
							else $p = $id - 2;

						 	for($i = $p; $i < $p + 5; $i++){ //5つだけページを表示
							 ?>
						 <?php
									if($i != $id){	?>
										<td class="pages"><a class="page" href="/hakoeve/events/all/<?php echo $i;?>"><?php echo $i;?></a></td>
						<?php	 	}else{ ?>
										<td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
						<?php		}


							}
						}
						?>
					<?php if($id < ceil($eventNum / 100)){ ?>
						<td class="pages" style="padding-right:0;"><a class="page" href="/hakoeve/events/all/<?php echo $id + 1;?>">次へ＞</a></td>
					<?php }else{ ?>
						<td class="pages" style="padding-right:0;"><a class="page" style="background-color: #9fa0a0; color:#fff;">次へ＞</a></td>
					<?php } ?>
				</tr>
			</TABLE>

		</div>





</div>