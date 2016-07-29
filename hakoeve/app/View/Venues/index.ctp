<?php echo $this->Html->css('manage'); ?>
<?php echo $this->Html->css('venue'); ?>
<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">開催場所管理</div>
<?php echo $this->element('actionmanage')?>

	<div class="venue_manage">
  <div style="border-bottom: solid 1px #000000; margin-top: 30px;">
  <font color = '#000000' style="font-size: 22px;">開催場所一覧</font>
</div>

	<div id="top">
	<table>
	<tr class="venue_data">
		<td style="font-size: 17px;">優先度</td><td style="font-size: 17px;">開催場所名</td><td style="font-size: 17px;">編集</td><td style="font-size: 17px;">削除</td>
	</tr>

		<?php foreach($data as $venue): ?>
		<tr class="venue_data">
			<td width="70px"><?php echo h($venue['Venue']['priority']); ?></td>
			<td width="800px"><?php echo h($venue['Venue']['venue_name']); ?></td>
			<td width="50px"><?php echo $this->Html->link('編集',array('action'=>'edit',$venue['Venue']['id']));?></td>
		<?php if($venue['Venue']['delete_flag']==1){ ?>
			<td width="50px"><?php echo $this->Html->link('削除',array('action'=>'delete',$venue['Venue']['id']),null,'本当に削除しますか？');?></td>
		<?php }else{?>
		<td width="50px"></td>
		<?php }?>
		</tr>
		<?php endforeach; ?>
	</table>
	</div>
</div>
</div>