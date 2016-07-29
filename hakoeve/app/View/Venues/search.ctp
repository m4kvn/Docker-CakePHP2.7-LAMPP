<?php echo $this->Html->css('results');
ini_set('memory_limit', '512M');
?>
<div class="view">



<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>
<br/>
<br/>

<div id= "page_title">検索結果</div>


<h2><font color="black">
<?php
// if($searchdate!=null){
//   	$w = $week[date("w", strtotime(($searchdate)))];
//    	  $day = date('Y年m月d日',strtotime($searchdate));
//    	  if($day[12]==0){
//    	  	$day = substr_replace("$day", " ", 12,1);
//    	  }
//    	  if($day[7]==0){
//    	  $day = substr_replace("$day", " ", 7,1);
//    	  }
//    	echo $day.="(".$w.")に開催されるイベント";
// }else{
?>

 <font size='5'>
 	<?php

//  $keyword.=$searchkeyword;
//  echo $keyword;
echo $eventList[0]['Venue']['venue_name'];
if(!count($eventList)) echo $venueName['Venue']['venue_name'];
 ?>

 </font>

<font size='3'> 
で検索しています
</font>
</font>
<font size='5'>
 <?php //}?>
   	</font></h2>

<?php
if(count($eventList)) {
?>
<div class= 'rect'>
<div style="float: left; height: 15px; margin-top: 10px;">
全<?php  echo $eventNum;?>件中&nbsp;&nbsp;<?php echo count($eventList);?>件表示</div>
<div class="page_select_area" style="width: 400px;float: right;">
<div id="ps_box">
   <TABLE style="padding:0; float: right; margin-top: 5px;">
    <tr style="padding:0;">
     <?php if($id > 1){?>
     <td class="pages"><a class="page" href="/hakoeve/venues/search?id=<?php echo $eventList[0]['Event']['venue_id'];?>&page=<?php echo $id - 1;?>">＜前へ</a></td>
     <?php }else{?>
     <td class="pages"><a class="page" style=" background-color: #9fa0a0; color:#fff;">＜前へ</a></td>
     <?php } ?>
      <?php
      if(ceil($eventNum / 20/*表示件数*/) <= 5){
       for($i = 1; $i <= ceil($eventNum / 20/*表示件数*/); $i++){
        if($id != $i){
        ?>   <td class="pages"><a class="page" href="/hakoeve/venues/search?id=<?php echo $eventList[0]['Event']['venue_id'];?>&page=<?php echo $i;?>"><?php echo $i;?></a></td>
  <?php }else{?>
  <td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
 <?php }
    }
     }else{
		$p = 0;
		if($id < 5) $p = 1;
		elseif($id >= ceil($eventNum / 20/*表示件数*/ ) - 2) $p = ceil($eventNum / 20/*表示件数*/ )- 4;
		else $p = $id - 2;

        for($i = $p; $i < $p + 5; $i++){ //5つだけページを表示
        ?>
        <?php if($id != $i){?>
       <td class="pages"><a class="page" href="/hakoeve/venues/search?id=<?php echo $eventList[0]['Event']['venue_id'];?>&page=<?php echo $i;?>"><?php echo $i;?></a></td>
     <?php }else{ ?>
       <td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
 <?php  }
  }
      }
      ?>
     <?php if($id < ceil($eventNum / 20)){ ?>
      <td class="pages" style="padding-right:0;"><a class="page" href="/hakoeve/venues/search?id=<?php echo $eventList[0]['Event']['venue_id'];?>&page=<?php echo $id + 1;?>">次へ＞</a></td>
      <?php }else{ ?>
      <td class="pages" style="padding-right:0;"><a class="page" style="background-color: #9fa0a0; color:#fff;">次へ＞</a></td>
     <?php }
     ?>
    </tr>
   </TABLE>

  </div>
</div>
</div>

<?php } else { ?>
	<br><br><br><br>
	<font size='3'> 
	<?php echo $venueName['Venue']['venue_name']?>
	に一致するイベントは見つかりませんでした。
	<br><br><br><br><br><br><br>
	</font>
<?php }?>

  <!--イベント一覧を表示-->
  <?php $ImageNum = 0;?>
 <?php if($eventList != null) foreach ($eventList as $value): ?>
<div class="image">
<hr style="border-top: 1px dotted #d3d3d3;width: 100%;">

<?php

//	$image=str_replace('.', '_original.',$value['Event']['thumbnail_file_name']);
	if(!isset($image[$ImageNum]['EventImage']) || $image[$ImageNum]['EventImage']['img_file_name'] == ""){
		 echo $this->Html->link($this->Html->image('noimage.jpg', array('border' => 0)),"/../hakoeve/events/view/{$value['Event']['id']}", array('escape' => false));

	}else{ echo$this->Html->link($this->upload->uploadImage($image[$ImageNum],'EventImage.img'),"/../hakoeve/events/view/{$value['Event']['id']}", array('escape' => false)); }

	?>
</div>

<h9>

<!--<table >-->


<th colspan="2">
<div class='new'>
  <?php if($value['Event']['markFlag']==0){ echo $this->Html->image('new.png');
  }else if($value['Event']['markFlag']==1){  echo $this->Html->image('up.png'); }
  ?>
  </div>
  <br>
  <font color='#00bfff' size='5'><a href="/hakoeve/events/view/<?php echo $value['Event']['id'];?>">

    <?php
     if ( strlen( $value['Event']['event_name'] ) > 40 ) {
          echo mb_substr($value['Event']['event_name'],0, 40) . " ...";
        } else {
        echo $value['Event']['event_name'];
            }
      ?>

  </a></font>
<br><br><br>
</th>開催日&nbsp;&nbsp;&nbsp;
<?php
  $i = 0;
  foreach ($value['Eventdate'] as $date=>$key) {

    if($i < 5) {
      $w = $week[date("w", strtotime(($key['date'])))];
          $day = date('m月d',strtotime($key['date']));
          $year = date('Y年',strtotime($key['date']));
      if($i == 0)
        echo $year . " ";
      if($day[0]=="0"){
        $day = substr_replace("$day", "", 0, 1);
      }
      if($day[4]=="0"){
        $day = substr_replace("$day", "", 4, 1);
      }


    echo $day.="日(".$w.")";
    //echo count($value);
    if($i < count($value['Eventdate']) - 1 && $i < 4)
    echo ",   ";
}
   $i++;
   if($i == 6) echo " ......";
 }

 ?>
		</td>
	</tr>

		<br><br><td>開催場所&nbsp;
		<td><?php echo h($value['Venue']['venue_name']);?></td><br>




	<tr>
		<td><a href="/hakoeve/events/view/<?php echo $value['Event']['id'];?>"></a>

		</td>

	</tr>

	</h9>
<?php $ImageNum++; ?>
<?php endforeach;?>

<!--   ここはのちのち使います
<h12>
<div class="paginateLinks">

	<?php echo $this->Paginator->prev(); ?>
	&nbsp;
	<?php echo $this->Paginator->numbers(); ?>
	&nbsp;
	<?php echo $this->Paginator->next(); ?>

</div>
</h12>
	-->

<?php echo $this->Html->css('shop_index', null, array( 'inline' => false )); ?>

<?php if(count($eventList)) { ?>
<div class= 'rect'>
<div style="float: left; height: 15px; margin-top: 10px;">
全<?php  echo $eventNum;?>件中&nbsp;&nbsp;<?php echo count($eventList);?>件表示</div>
<div class="page_select_area" style="width: 400px;float: right;">
<div id="ps_box">

   <TABLE style="padding:0; float: right; margin-top: 5px;">
    <tr style="padding:0;">
     <?php if($id > 1){?>
     <td class="pages"><a class="page" href="/hakoeve/venues/search?id=<?php echo $eventList[0]['Event']['venue_id'];?>&?page=<?php echo $id - 1;?>">＜前へ</a></td>
     <?php }else{?>
     <td class="pages"><a class="page" style=" background-color: #9fa0a0; color:#fff;">＜前へ</a></td>
     <?php } ?>
      <?php
      if(ceil($eventNum / 20/*表示件数*/) <= 5){
       for($i = 1; $i <= ceil($eventNum / 20/*表示件数*/); $i++){
        if($id != $i){
        ?>   <td class="pages"><a class="page" href="/hakoeve/venues/search?id=<?php echo $eventList[0]['Event']['venue_id'];?>&?page=<?php echo $i;?>"><?php echo $i;?></a></td>
  <?php }else{?>
  <td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
 <?php }
    }
     }else{
		$p = 0;
		if($id < 5) $p = 1;
		elseif($id >= ceil($eventNum / 20/*表示件数*/ ) - 2) $p = ceil($eventNum / 20/*表示件数*/ )- 4;
		else $p = $id - 2;

        for($i = $p; $i < $p + 5; $i++){ //5つだけページを表示
        ?>
        <?php if($id != $i){?>
       <td class="pages"><a class="page" href="/hakoeve/venues/search?id=<?php echo $eventList[0]['Event']['venue_id'];?>&?page=<?php echo $i ?>"><?php echo $i;?></a></td>
     <?php }else{ ?>
       <td class="pages"><a class="page" style="background-color:#9fa0a0; color:#fff;"><?php echo $i;?></a></td>
 <?php  }
  }
      }
      ?>
     <?php if($id < ceil($eventNum / 20)){ ?>
      <td class="pages" style="padding-right:0;"><a class="page" href="/hakoeve/venues/search?id=<?php echo $eventList[0]['Event']['venue_id'];?>&?page=<?php echo $id + 1;?>">次へ＞</a></td>
      <?php }else{ ?>
      <td class="pages" style="padding-right:0;"><a class="page" style="background-color: #9fa0a0; color:#fff;">次へ＞</a></td>
     <?php } ?>
    </tr>
   </TABLE>
   </div>
  </div>
 </div>
</div>
<?php } ?>
</div>

</div>