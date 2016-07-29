
  jQuery(document).ready(function ($) {
    $('#calender').jCal({
      day:      new Date( (new Date()).setMonth( (new Date()).getMonth()) ),
      days:     1,
      showMonths:   1,
      monthSelect:  true,
      dow: ['日', '月', '火', '水', '木', '金', '土'],
      ml: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
    });
  });

  var list1, list2;

  jQuery(function($) {
    $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
    $( "#datepicker1" ).datepicker({
      onSelect: function(span1, inst){
        list1 = span1.split( '/' );
      }
    });
  });

  jQuery(function($) {
    $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
    $( "#datepicker2" ).datepicker({
      onSelect: function(span2, inst){
        list2 = span2.split( '/' );
      }
    });
  });

jQuery(function ($) {
    $("#span_search").click(function(){
      if($( "#datepicker1" ).val() != "" && $( "#datepicker2" ).val() != "") {
        var url = list1[0] + list1[1] + list1[2] + "/" + list2[0] + list2[1] + list2[2];
        location.href = "/../hakoeve/eventdates/searchspan/" + url;
      }
    });
  });

jQuery(function ($) {
    $("#span_clear").click(function(){
      $( "#datepicker1" ).val(""); 
      $( "#datepicker2" ).val(""); 
    });
  });
