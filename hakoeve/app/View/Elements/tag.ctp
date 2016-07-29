
<?php echo $this->Html->script('jquery-1.10.2.min'); ?>
<?php echo $this->Html->script('jquery.multicols'); ?>
<?php echo $this->Html->css("events.index.tag");?>

<div id="tag_area" class="close_tagarea">
	<div id="tag_title">
		ジャンルを選択
	</div>
	<div id="text">
		調べたいジャンルを選択してください

	</div>



	<?php echo $this->Form->create('Tag',array('type'=>'post','action'=>'search', 'name' => 'TagSearchForm')); ?>
	<div id="tag_list">
		<?php
			echo $this->Form->input( 'Tag.radio1',array(
                           'multiple'=> 'checkbox',
						   'class' => 'header_tag',
                           'options' =>$select1 ,
                           'div' => true,
                           'label' => false,));
		?>
		<script type="text/javascript">
	    	$('.header_tag').multicols({
	       	 cols:3
	     	});
	    </script>
	</div>
	<div class="tag_search_area">
		<input type="button" value="検索" id="tag_search" onclick="tag_submit()">
		<?php echo $this->Form->end();?>
	</div>
</div>


<script type="text/javascript">
	function tag_submit() {
		var tags = document.getElementById('TagSearchForm').elements['data[Tag][radio1][]'];
		var i;
		for(i=0 ; i<tags.length ; i++){
			if(tags[i].checked){
				break;
			}
		}
		if(i != tags.length){
			document.TagSearchForm.submit();
		}else{
			alert("ジャンルを1つ以上を選択してください");
		}
	}
</script>