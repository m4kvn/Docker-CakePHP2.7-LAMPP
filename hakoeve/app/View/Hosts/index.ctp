<?php echo $this->Html->css('manage'); ?>
<?php echo $this->Html->css('host'); ?>
<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514;">主催者管理</div>
<?php echo $this->element('actionmanage')?>

<div class="host_manage">
	<div style="border-bottom: solid 1px #000000; margin-top: 30px;">
	<font color = '#000000' style="font-size: 22px;">主催者一覧</font>
	</div>

	<div id ="top">
	<table>
	<tr class="host_data">
	 <td style="font-size: 17px; border-bottom: dotted 1px #000;">優先度</td><td style="font-size: 22px;">主催者</td><td style="font-size: 17px;">編集</td><td style="font-size: 17px;">削除</td>
	 </tr>
		<?php foreach($data as $host): ?>
		<tr class="host_data">
			<td width="100px"><?php echo h($host['Host']['priority']); ?></td>
			<td width="710px"><?php echo h($host['Host']['host_name']); ?></td>
			<td width="80px"><?php echo $this->Html->link('編集',array('action'=>'edit',$host['Host']['id']));?></td>
			<?php if($host['Host']['delete_flag']==1){ ?>
			<td width="58px"><?php echo $this->Html->link('削除',array('action'=>'delete',$host['Host']['id']),null,'本当に削除しますか？');?></td>
		<?php }else{?>
		<td width="58px"></td>
		<?php }?>
		</tr>
		<?php endforeach; ?>
	</table>
	</div>
	</div>
</div>