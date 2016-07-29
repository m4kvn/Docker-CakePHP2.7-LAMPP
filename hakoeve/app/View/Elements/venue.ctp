<?php echo $this->Html->script("select2");?>
<?php echo $this->Html->css("select2");?>
<?php echo $this->Html->css("events.index.venue");?>

<div id="venue_search_area" class="close_venuearea">
	<div id="map_area">
		<div class="venue_title">地図から選択</div>
		<div class="venue_text">調べたい場所を地図から選択してください</div>

		<div id="map" style="width: 500px; height: 500px;"></div>

		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

	</div>

	<div id="place_name_area">
		<div class="venue_title">開催場所を選択</div>
		<div class="venue_text">調べたい開催場所を候補から選択してください</div>

			<form name="venue_form">
				<div id="place_menu">
						<select name = "venue_list" onChange="Click_center()">
						<option>開催場所を選択</option>
						<?php
						$a=0;
						foreach ($venue as $value){
					?>
							<option value = "<?php echo (float)$value['Venue']['latitude'];?>&<?php echo (float)$value['Venue']['longitude'];?>&<?php echo $a;?>&<?php echo $value['Venue']['id']?>"><?php 	echo h($value['Venue']['venue_name']);?>
							</option>
					<?php
							$a++;
						}
						?>
						</select>
				</div>
			</form>


	<div id="button_area">
<!-- 		<form method="get" action="/venues/search"> -->

		<?php
		echo $this->Form->create('Venue', array('action' => 'search', 'type' => 'get', 'name' => 'VenueSearchForm'));
		echo $this->Form->hidden('Venue.id', array('id' => 'Venue', 'value' => 0));
		?>
	<div class="tag_search_area">
		<input type="button" value="検索" id="tag_search" onclick="venue_submit()">
	</div>
	<?php
		echo $this->Form->end();?></div>

	</div>
</div>
<script type="text/javascript">
	var flag=0;
	var currentInfoWindow = null;

	var myMap = new google.maps.Map(document.getElementById('map'), {
				    zoom: 14,
				    center: new google.maps.LatLng(41.789361,140.752016),
				    scrollwheel: false,
					mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	$(function(){
		$("#map_button").click(function(){
			var outtime = 800;
			if(flag>0) outtime += 1000;
			setTimeout(function(){
    <!-- クリックした場所を地図の中心に-->
			    myMap.setCenter(new google.maps.LatLng(41.789361,140.752016));
			}, outtime);
		});
	});

	function Click_center(){
		obj = document.venue_form.venue_list;

		index = obj.selectedIndex;
		lat = obj.options[index].value.split("&")[0];
		lng = obj.options[index].value.split("&")[1];
		i = obj.options[index].value.split("&")[2];
		id = obj.options[index].value.split("&")[3];

		var infoWnd =  new google.maps.InfoWindow({
			content: data[i].content
	    });
		myMap.panTo(new google.maps.LatLng(lat,lng));
		if (currentInfoWindow) {
			currentInfoWindow.close();
		}
		infoWnd.open(myMarker[i].getMap(),myMarker[i]);
		currentInfoWindow = infoWnd;
		document.getElementById('Venue').value=id;
	}


	function attachMessage(marker, msg) {
		var infoWnd = new google.maps.InfoWindow({
        	content: msg
      	});
   		google.maps.event.addListener(marker, 'click', function(event) {
	//先に開いた情報ウィンドウがあれば、closeする
			if (currentInfoWindow) {
				currentInfoWindow.close();
			}
 			infoWnd.open(marker.getMap(), marker);
 			currentInfoWindow = infoWnd;
    	});

	}

	function venue_submit(){
		if(document.venue_form.venue_list.selectedIndex == 0){
			alert("開催場所を選択してください");
		}else{
			document.VenueSearchForm.submit();
		}
	}

// 位置情報と表示データの組み合わせ
	var data = new Array();
	var myMarker = new Array();
	<?php $r=1;?>
	<?php foreach ($venue as $value):?>

 	<?php
        $d2=0;
		$eventname=array();
		$eventdate=array();
		$eventid=array();
		$markflag=array();

		foreach($value['Event'] as $e2){
			if($e2['visible'] != 0){
				$eventname[] =$e2['event_name'];
				$eventid[] =$e2['id'];
				$markflag[] = $e2['markFlag'];
				$days=array();
				foreach($e2['Eventdate'] as $day){
					$days[] =$day['date'];
				}
				$eventdate[]=$days;
				$d2++;
			}
		}
	?>
	<!-- ここに場所ごとのイベント情報を格納できるように実装してください -->
		var event_info="<a href=\"/hakoeve/Venues/search/?id=<?php echo $value['Venue']['id'];?>\" style=\"color : #0000cc\"><font size=3px ><?php echo "開催場所　"; echo h($value['Venue']['venue_name']);?></font><br/>";
		event_info += "<font size=3px ><?php echo "所在地　"; echo h($value['Venue']['address']); ?></font></a>";
		data.push({position: new google.maps.LatLng(<?php echo (float)$value['Venue']['latitude'];?>, <?php echo (float)$value['Venue']['longitude'];?>), content: event_info});
	<?php endforeach;?>

	for (i = 0; i < data.length; i++) {
		myMarker[i] = new google.maps.Marker({
			position: data[i].position,
			map: myMap
		});
	}
	for (i = 0; i < data.length; i++) {
		attachMessage(myMarker[i], data[i].content);
	}

	$(function(){
		$("#day_button").click(function(){
			flag++;
		});
	});

	$(function(){
		$("#category_button").click(function(){
			flag++;
		});
	});

  </script>