<?php echo $this->Html->css('manage'); ?>
<div class="manage_view">
<div class="manage_tittle">イベント管理</div>

<?php echo $this->element('actionmanage'); ?>

<div class="view">

<div class="sub_tittle">イベント一覧</div>
  <div style="padding: 0px; margin-bottom: -12px; text-align: center;  background: #5E370D;">
</div> 
<br>


<div class="section">
<div id="top">
 <table>
<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>

   <td><b>日付</b></td><td><b>イベント名</b></td><td><b>開催場所</b></td>

  <?php foreach($eventList as $data): ?>
  <tr class="tr_color">
   <td width='160px' >
   <?php $i = 0;?>
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
   	<?php if($i < (count($data['Eventdate']) - 1) ) echo "<br>";?>
   	<?php $i++; ?>		
   	<?php endforeach;?>
   &nbsp;</td>
   <td width='370px'><font color="#0000ff"><Ins>
<A Href="/hakoeve/events/viewmanagement/<?php echo $data['Event']['id'];?>"><B> 
  <?php echo h($data['Event']['event_name']); ?>
  </B></A>
  </Ins>&nbsp;</font></td>
   <td with='320px'><?php echo h($data['Venue']['venue_name']); ?></td>
  </tr>
  
  
  <?php endforeach; ?>
 </table>
 </div>
</div>


<div class="paginateLinks">

 
</div>

<?php echo $this->Html->css('shop_index', null, array( 'inline' => false )); ?>
</div>

</div>
