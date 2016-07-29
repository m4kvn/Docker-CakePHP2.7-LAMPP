<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">イベント管理</div>
<?php echo $this->element('actionmanage')?>

<?php echo $this->Html->css('manage'); ?>

<div class="view">

  <div style="font-size: 29px; border-bottom: solid 1px #000; margin-top: 30px;">
   検索結果<?php echo count($result);?>件
</div>


<div class="section">
<div id="top">
 <table>
<?php $week = array("日", "月", "火", "水", "木", "金", "土");?>



  <?php foreach ($result as $value): ?>
  <tr>
   <td width='138px' >
   <?php foreach ($value['Eventdate'] as $date):

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
   <td width='418px'><font color="#0000ff"><Ins>
<A Href="/hakoeve/events/viewmanagement/<?php echo h($value['Event']['id']);?>"><B>
  <?php echo h($value['Event']['event_name']);?>
  </B></A>
  </Ins>&nbsp;</font></td>
   <td with='300px'><?php echo h($value['Venue']['venue_name']);?></td>
  </tr>


  <?php endforeach; ?>
 </table>
</div>
</div>



<?php echo $this->Html->css('shop_index', null, array( 'inline' => false )); ?>
</div>
</div>