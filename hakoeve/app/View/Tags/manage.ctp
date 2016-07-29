<?php echo $this->Html->css('manage'); ?>
<?php echo $this->Html->css('tag'); ?>
<div class="manage_view">
<div style="border-bottom: solid 1px #000000; font-size: 29px; color: #ff5514; ">タグ管理</div>
<?php echo $this->element('actionmanage')?>

	<div class="tag_manage">
  <div style="border-bottom: solid 1px #000000; margin-top: 30px;">
  <font color = '#000000' style="font-size: 22px;">タグ一覧</font>
</div>
	<div id ="top">
	<table>
	<tr class="tag_data">
		<td style="font-size: 17px;">優先度</td><td style="font-size: 17px;">タグ名</td><td style="font-size: 17px;">編集</td><td style="font-size: 17px;">削除</td>
	</tr>
		<?php foreach($data as $tag): ?>
		<tr class="tag_data">
			<td width="100px"><?php echo h($tag['Tag']['priority']); ?></td>
			<td width="710px"><?php echo h($tag['Tag']['tag_name']); ?></td>
			<td width="80px"><?php echo $this->Html->link('編集',array('action'=>'edit',$tag['Tag']['id']));?></td>
		<?php if($tag['Tag']['delete_flag']==1){ ?>
			<td width="80px"><?php echo  $this->Html->link('削除', array('action' => 'delete', $tag['Tag']['id']),null,'本当に削除しますか？');?></td>
		<?php }else{?>
		<td width="80px"></td>
		<?php }?>
		</tr>
		<?php endforeach; ?>
	</table>
	</div>
	</div>
</div>