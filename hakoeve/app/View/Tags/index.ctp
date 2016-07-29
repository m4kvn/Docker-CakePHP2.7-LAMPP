<div class="view">
<?php echo $this->Html->script('jquery-1.10.2.min'); ?>
<?php echo $this->Html->script('jquery.multicols'); ?>
  <div style="padding: 0px; margin-bottom: -12px; text-align: center;  background: #5E370D;">
   <h6><font size = '5' color = '#ffffff'>タグ検索</font></h6>
</div> 
<br>



<?php echo $this->Form->create(false,array('type'=>'post','action'=>'search')); ?>
</br>
<h1><font size='5'>タグを選択してください</font></h1>

<?php
	echo $this->Form->input( 'Tag.radio1',array(
                           'multiple'=> 'checkbox',
                           'options' =>$select1 ,
                           'div' => true,
                           'label' => false,));
?>
<script type="text/javascript">
    $('div.checkbox').multicols({  
        cols:3
      });  
    </script>

<br>
<br>
<?php
	echo $this->Form->end("検索");
	?>

	
</div>
<?php echo $this->element('action',array("flag"=>1));?>