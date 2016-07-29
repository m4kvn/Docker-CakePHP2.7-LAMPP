<body style="background-color: #FFF;">
<div style="width:380px; padding: 5px;">
<?php #echo $today; ?>
<?php
	$num = 15;
    echo "<ul>";
	for($i=0; $i<count($newerEventList) && $i<$num; $i++){
		for($d=0; $d<count($newerEventList[$i]["Eventdate"]); $d++){
			if(strtotime($newerEventList[$i]["Eventdate"][$d]["date"]) >= strtotime($today)) break;
		}
		echo "<li style='line-height:85%; margin: 0 2px 10px 2px;'>";
		//date
        echo "<span style='font-size: 10pt'>";
		if($d < count($newerEventList[$i]["Eventdate"])) echo date('n/j', strtotime($newerEventList[$i]["Eventdate"][$d]["date"]));
		else echo date('n/j', strtotime($newerEventList[$i]["Eventdate"][$d - 1]["date"]));
		echo " ";
		
        //event name
        echo "<a target='_parent' href=/hakoeve/events/view/".$newerEventList[$i]["Event"]["id"]."/>";
		echo $newerEventList[$i]["Event"]["event_name"];
		echo "</a></span>";
		
        //venue name
        echo " <span style='font-size: 8pt'>";
		echo $newerEventList[$i]["Venue"]["venue_name"];
		echo "</span></li>";
	}
    echo "</ul>";
?>
</div>
</body>