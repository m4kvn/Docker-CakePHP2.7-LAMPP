<?php echo $this->Html->css("events.all");?>
<div class="view">
<div id="page_title" style="margin-bottom:15px">
<?php
  $t = substr($searchmonth, 0, 4)."-".substr($searchmonth, 4, 2)."-".substr($searchmonth, 6, 2);
?>
<?php echo date('Y年n月', strtotime($t)); ?>のイベント一覧
</div>

<div class="page_select_area">
    <div class="event_num">
      全<?php echo $eventNum;?>件中　　<?php echo count($result);?>件表示
    </div>

    <div class="select_area">
      <TABLE style="padding:0;">
        <tr style="padding:0;">
          <?php if($id > 1){?>
          <td class="pages"><a class="page" href="/hakoeve/eventdates/searchmonth/<?php echo $searchmonth; ?>/<?php echo $id - 1;?><?php if(isset($sort)) echo "&?sort=".$sort?>">＜前へ</a></td>
          <?php }else{?>
          <td class="pages"><a class="page" style=" background-color: #9fa0a0; color:#fff;">＜前へ</a></td>
          <?php } ?>
            <?php
            if(ceil($eventNum / 100/*表示件数*/) <= 5){
              for($i = 1; $i <= ceil($eventNum / 100/*表示件数*/); $i++){
                if($i != $id){
                ?>   <td class="pages"><a class="page" href="/hakoeve/eventdates/searchmonth/<?php echo $searchmonth; ?>/<?php echo $i;?><?php if(isset($sort)) echo "&?sort=".$sort;?>"><?php echo $i;?></a></td>
          <?php   }else{ ?>
                  <td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
          <?php   }
              }
            }else{
              $p = 0;
              if($id < 5) $p = 1;
              elseif($id >= ceil($eventNum / 100/*表示件数*/ ) - 2) $p = ceil($eventNum / 100/*表示件数*/ )- 4;
              else $p = $id - 2;

              for($i = $p; $i < $p + 5; $i++){ //5つだけページを表示
               ?>
             <?php
                  if($i != $id){  ?>
                    <td class="pages"><a class="page" href="/hakoeve/eventdates/searchmonth/<?php echo $searchmonth; ?>/<?php echo $i;?><?php if(isset($sort)) echo "&?sort=".$sort?>"><?php echo $i;?></a></td>
            <?php   }else{ ?>
                    <td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
            <?php   }


              }
            }
            ?>
          <?php if($id < ceil($eventNum / 100)){ ?>
            <td class="pages" style="padding-right:0;"><a class="page" href="/hakoeve/eventdates/searchmonth/<?php echo $searchmonth; ?>/<?php echo $id + 1;?><?php if(isset($sort)) echo "&?sort=".$sort?>">次へ＞</a></td>
          <?php }else{ ?>
            <td class="pages" style="padding-right:0;"><a class="page" style="background-color: #9fa0a0; color:#fff;">次へ＞</a></td>
          <?php } ?>
        </tr>
      </TABLE>

    </div>
  </div>

<?php $dispaly = array( '0' => '非表示', '1' => '表示' ); ?>

<div id="event_list">
 <TABLE BORDER="1" CELLSPACING="0" CELLPADDING="0" RULES="rows" frame="void">
<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>
  <th>日付</th><th>イベント名</th><th>開催場所</th>
  <?php foreach($result as $data): ?>

  <tr>
   <td width='180px'>
   	<?php foreach($data['Eventdate'] as $date):

   	$w = $week[date("w", strtotime(($date['date'])))];
   	  $day = date('Y年m月d日',strtotime($date['date']));
   	  if($day[12]==0){
   	  	$day = substr_replace("$day", " ", 12,1);
   	  }
   	  if($day[7]==0){
   	  $day = substr_replace("$day", " ", 7,1);
   	  }
   	echo $day.="(".$w.")";?>

   	<?php endforeach; ?>
   &nbsp;</td>
   <td width="546px"><font color="#0000ff"><Ins>
<A Href="/hakoeve/events/view/<?php echo $data['Event']['id'];?>"><B>
  <?php echo h($data['Event']['event_name']); ?>
  </B></A>
  </Ins>&nbsp;</font></td>
   <td with='20%'><?php echo h($data['Venue']['venue_name']); ?></td>
  </tr>
  <?php endforeach; ?>
 </table>

</div>

<div class="page_select_area">
    <div class="event_num">
      全<?php echo $eventNum;?>件中　　<?php echo count($result);?>件表示
    </div>

    <div class="select_area">
      <TABLE style="padding:0;">
        <tr style="padding:0;">
          <?php if($id > 1){?>
          <td class="pages"><a class="page" href="/hakoeve/eventdates/searchmonth/<?php echo $searchmonth; ?>/<?php echo $id - 1;?><?php if(isset($sort)) echo "&?sort=".$sort?>">＜前へ</a></td>
          <?php }else{?>
          <td class="pages"><a class="page" style=" background-color: #9fa0a0; color:#fff;">＜前へ</a></td>
          <?php } ?>
            <?php
            if(ceil($eventNum / 100/*表示件数*/) <= 5){
              for($i = 1; $i <= ceil($eventNum / 100/*表示件数*/); $i++){
                if($i != $id){
                ?>   <td class="pages"><a class="page" href="/hakoeve/eventdates/searchmonth/<?php echo $searchmonth; ?>/<?php echo $i;?><?php if(isset($sort)) echo "&?sort=".$sort;?>"><?php echo $i;?></a></td>
          <?php   }else{ ?>
                  <td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
          <?php   }
              }
            }else{
              $p = 0;
              if($id < 5) $p = 1;
              elseif($id >= ceil($eventNum / 100/*表示件数*/ ) - 2) $p = ceil($eventNum / 100/*表示件数*/ )- 4;
              else $p = $id - 2;

              for($i = $p; $i < $p + 5; $i++){ //5つだけページを表示
               ?>
             <?php
                  if($i != $id){  ?>
                    <td class="pages"><a class="page" href="/hakoeve/eventdates/searchmonth/<?php echo $searchmonth; ?>/<?php echo $i;?><?php if(isset($sort)) echo "&?sort=".$sort?>"><?php echo $i;?></a></td>
            <?php   }else{ ?>
                    <td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
            <?php   }


              }
            }
            ?>
          <?php if($id < ceil($eventNum / 100)){ ?>
            <td class="pages" style="padding-right:0;"><a class="page" href="/hakoeve/eventdates/searchmonth/<?php echo $searchmonth; ?>/<?php echo $id + 1;?><?php if(isset($sort)) echo "&?sort=".$sort?>">次へ＞</a></td>
          <?php }else{ ?>
            <td class="pages" style="padding-right:0;"><a class="page" style="background-color: #9fa0a0; color:#fff;">次へ＞</a></td>
          <?php } ?>
        </tr>
      </TABLE>

    </div>
  </div>
</div>
