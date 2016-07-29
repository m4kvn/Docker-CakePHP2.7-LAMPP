<?php echo $this->Html->css("poster.list");?>
<?php echo $this->Html->css("GITheWall");?>
<?php echo $this->Html->script("jQuery.GI.TheWall"); ?>
<?php echo $this->Html->script("event_images"); ?>

  <link rel="stylesheet" href="http://highlightjs.org/static/styles/github.css">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.0/highlight.min.js"></script>
  <link href="http://fast.fonts.net/cssapi/4bedbdc9-7261-43be-b2e9-f34abce90975.css" media="all" type="text/css" rel="stylesheet">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" media="all" type="text/css" rel="stylesheet">
  <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-11754034-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>

<div id="poster_List">
	<div id="poster_list_title">ポスターを選択</div>
	<div id="poster_list_subtitle">ポスターからイベントの詳細を知ることができます</div>

	<div id="poster_list_area">
		<!--
		<div id="poster_list_submenu">
			
			<div id="poster_list_submenu_sort_area">
				<label for="poster_list_submenu_sort" id="sort_label">表示順序：</label>
				<select id="poster_list_submenu_sort">
					<option>開催日時が早い順</option>
					<option>開催日時が遅い順</option>
					<option>五十音順</option>
				</select>
 			</div>


 		<div class="past_checkbox">
 			<div class="checkbox">
 				<input id="PastRadio" type="checkbox" value="" name=""></input>
 				<label for="PastRadio" id="past_text">
 				過去のイベントも表示
 				</label>
 			</div><!-- checkbox -->
 		<!--</div> <!-- past_checkbox -->

		<!--</div>
		-->
		<div id="poster_list_image_area" class="GITheWall">
		<ul>

		<?php
			$loopID = 0;
			for($loopID; $loopID < $eventNum; $loopID++){
				if($imageList[$loopID]['EventImage']['img_file_name'] == ""){
					echo "<li data-contenttype='ajax' data-href='/../hakoeve/eventImages/poster/".$imageList[$loopID]['EventImage']['event_id']."' id='".$loopID."'>";
					echo "<img src='/../hakoeve/img/noimage.jpg'></li>";
				}else{
					$finename_array = explode(".", $imageList[$loopID]['EventImage']['img_file_name']);
					$filename = $finename_array[0]."_original.".$finename_array[1];
					echo "<li data-contenttype='ajax' data-href='/../hakoeve/eventImages/poster/".$imageList[$loopID]['EventImage']['event_id']."' id='".$loopID."'>";
					echo $this->upload->uploadImage($imageList[$loopID]['EventImage'], 'EventImage.img')."</li>";
				}

			}
		?>
		</ul>
		</div>
		<div id="poster_list_more_area">
			<div id="poster_list_more_button">ポスターをもっと表示</div>
		</div>
	</div>
</div>

<script type="text/javascript">
  $('.GITheWall').GITheWall({
      nextButtonClass: 'fa fa-arrow-right',
      prevButtonClass: 'fa fa-arrow-left',
      closeButtonClass: 'fa fa-times'
  });
</script>

  <script type="text/javascript">
	$(document).ready(function(){
		var poster_list = <?php echo $eventNum; ?>;
		var view = 18;
		for (var i = 0; i < poster_list; i++) {
			if(i < view){
				$("#"+i).css("display","inline-block");
			}else{
				$("#"+i).css("display","none");
			}
		};
		if (view >= poster_list){
				$("#poster_list_more_button").css("display", "none")
		}
	});

	$(function(){
		$("#poster_list_more_button").click(function(){
			if($("#poster_view").hasClass("GI_TW_expander opened")) return;
			var poster_list = <?php echo $eventNum; ?>;
			var	limit = 0;
			var view = 18;
			for (var i = 0; i < poster_list && limit < view; i++) {
				if($("#"+i).css("display") == "none"){
					$("#"+i).css("display","inline-block");
					limit++;
				};
			};
			
			if (limit < view){
				$("#poster_list_more_button").css("display", "none")
			}
		});
	});
  </script>