var number = 0;
var posterTop = 0;
var tagHeight = 0;

$(function(){
	$("#day_button").click(function(){
		if(number == 0){
			number = 1;
			if($('#day_view').hasClass('close')){
			
				if($('#poster_view').hasClass('opened')){
					var top = parseFloat($('#poster_view').css("top"));
					if($('#category_view').hasClass('open')){
						top += 500 - tagHeight;
					}else if($('#map_view').hasClass('open')){
						top -= 200;
					}else{
						posterTop = parseFloat($('#poster_view').css("top"));
						top += 500;
					}
					
					$('#poster_view').css("top",top + 'px');
				}
			
				if($('#category_view').hasClass('open')){
					//$('#day_area').removeClass("open_area").addClass("close_area");
      				$("#category_view").height(0);
					$('#tag_area').removeClass("open_tagarea").addClass("close_tagarea");
					$('#category_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");
					setTimeout(function(){
						$('#day_view').removeClass("close").addClass("open");
					},800);

					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},1300);

					setTimeout(function(){
						$('#day_area').removeClass("close_dayarea").addClass("open_dayarea");
					},1800);

				}
				else if($('#map_view').hasClass('open')){
					$('#venue_search_area').removeClass("open_venuearea").addClass("close_venuearea");
					$('#map_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");
					setTimeout(function(){
						$('#day_view').removeClass("close").addClass("open");
					},800);

					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},1300);

					setTimeout(function(){
						$('#day_area').removeClass("close_dayarea").addClass("open_dayarea");
					},1800);

				}else{
					$('#day_view').removeClass("close").addClass("open");
					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},600);

					setTimeout(function(){
						$('#day_area').removeClass("close_dayarea").addClass("open_dayarea");
					},800);

				}
				
			}else{
				
				if($('#poster_view').hasClass('opened')){
					var top = parseFloat($('#poster_view').css("top")) - 500;
					$('#poster_view').css("top",posterTop + 'px');
				}
			
				$('#day_area').removeClass("open_dayarea").addClass("close_dayarea");
				setTimeout(function(){
					$('#day_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");
				}, 500);

			}setTimeout(function(){
				//$('#day_area').removeClass("open_dayarea").addClass("close_dayarea");
				number = 0;
			}, 800);
		}
	});
});

$(function(){
	$("#category_button").click(function(){
		if(number == 0){
			number = 2;
			if($('#category_view').hasClass('close')){
			
				if($('#poster_view').hasClass('opened')){
				tagHeight = $("#tag_area").outerHeight(true) + 20;
					var top = parseFloat($('#poster_view').css("top"));
					if($('#day_view').hasClass('open')){
						top += tagHeight - 500;
					}else if($('#map_view').hasClass('open')){
						top += tagHeight - 700;
					}else{
						tagHeight = $("#tag_area").outerHeight(true) + 20;
						posterTop = parseFloat($('#poster_view').css("top"));
						top += tagHeight;
					}
					
					$('#poster_view').css("top",top + 'px');
				}
			
				if($('#day_view').hasClass('open')){
					$('#day_area').removeClass("open_dayarea").addClass("close_dayarea");
					$('#day_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");

					setTimeout(function(){
						var Height = $("#tag_area").outerHeight(true) + 20;
      					$("#category_view").height(Height);
						$('#category_view').removeClass("close").addClass("open");
					},800);
					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},1300);

					setTimeout(function(){
						$('#tag_area').removeClass("close_tagarea").addClass("open_tagarea");
					},1800);

				}
				else if($('#map_view').hasClass('open')){
					$('#venue_search_area').removeClass("open_venuearea").addClass("close_venuearea");
					$('#map_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");
					
					setTimeout(function(){
						var Height = $("#tag_area").outerHeight(true) + 20;
      					$("#category_view").height(Height);
						$('#category_view').removeClass("close").addClass("open");
					},800);

					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},1300);

					setTimeout(function(){
						$('#tag_area').removeClass("close_tagarea").addClass("open_tagarea");
					},1800);

				}else{
					var Height = $("#tag_area").outerHeight(true) + 20;
      				$("#category_view").height(Height);
					$('#category_view').removeClass("close").addClass("open");

					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},600);

					setTimeout(function(){
						$('#tag_area').removeClass("close_tagarea").addClass("open_tagarea");
					},800);

				}
				
			}else{
			
				if($('#poster_view').hasClass('opened')){
					var top = parseFloat($('#poster_view').css("top")) - 500;
					$('#poster_view').css("top",posterTop + 'px');
				}
			
				$('#tag_area').removeClass("open_tagarea").addClass("close_tagarea");

				setTimeout(function(){
      				$("#category_view").height(0);
					$('#category_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");
				}, 500);
			}
			setTimeout(function(){
				number = 0;
			}, 800);
		}
	});
});

$(function(){
	$("#map_button").click(function(){
		if(number == 0){
			number = 3;
			if($('#map_view').hasClass('close')){
			
				if($('#poster_view').hasClass('opened')){
					var top = parseFloat($('#poster_view').css("top"));
					if($('#day_view').hasClass('open')){
						top += 200;
					}else if($('#category_view').hasClass('open')){
						top += 700 - tagHeight;
					}else{
						posterTop = parseFloat($('#poster_view').css("top"));
						top += 700;
					}
					
					$('#poster_view').css("top",top + 'px');
				}
			
				if($('#day_view').hasClass('open')){
					$('#day_area').removeClass("open_dayarea").addClass("close_dayarea");
					$('#day_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");
					setTimeout(function(){
						$('#map_view').removeClass("close").addClass("open");
					},800);
					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},1300);

					setTimeout(function(){
						$('#venue_search_area').removeClass("close_venuearea").addClass("open_venuearea");
						google.maps.event.trigger(map, 'resize');
					},1800);


				}
				else if($('#category_view').hasClass('open')){
					$("#category_view").height(0);
					$('#tag_area').removeClass("open_tagarea").addClass("close_tagarea");
					$('#category_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");
					setTimeout(function(){
						$('#map_view').removeClass("close").addClass("open");
					},800);

					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},1300);

					setTimeout(function(){
						$('#venue_search_area').removeClass("close_venuearea").addClass("open_venuearea");
						google.maps.event.trigger(map, 'resize');
					},1800);


				}else{
					$('#map_view').removeClass("close").addClass("open");
					setTimeout(function(){
						$('#close_button').removeClass("close_view").addClass("open_view");
					},600);

					setTimeout(function(){
						$('#venue_search_area').removeClass("close_venuearea").addClass("open_venuearea");
						google.maps.event.trigger(map, 'resize');
					},800);

				}
				
			}else{
			
				if($('#poster_view').hasClass('opened')){
					var top = parseFloat($('#poster_view').css("top")) - 700;
					$('#poster_view').css("top",posterTop + 'px');
				}
			
				$('#venue_search_area').removeClass("open_venuearea").addClass("close_venuearea");
				setTimeout(function(){
					$('#map_view').removeClass("open").addClass("close");
					$('#close_button').removeClass("open_view").addClass("close_view");
				}, 500);
			}

			setTimeout(function(){
				number = 0;
			}, 800);
		}
	});
});


$(function(){
	$("#close_button").click(function(){
		if(number == 0){
			number = 1;

			if($('#day_view').hasClass('open')){
			
				if($('#poster_view').hasClass('opened')){
					$('#poster_view').css("top",posterTop + 'px');
				}
				
				$('#day_area').removeClass("open_dayarea").addClass("close_dayarea");
				$('#day_view').removeClass("open").addClass("close");
				$('#close_button').removeClass("open_view").addClass("close_view");
			}

			if($('#category_view').hasClass('open')){
			
				if($('#poster_view').hasClass('opened')){
					$('#poster_view').css("top",posterTop + 'px');
				}
				$("#category_view").height(0);
				$('#tag_area').removeClass("open_tagarea").addClass("close_tagarea");
				$('#category_view').removeClass("open").addClass("close");
				$('#close_button').removeClass("open_view").addClass("close_view");
			}

			if($('#map_view').hasClass('open')){
			
				if($('#poster_view').hasClass('opened')){
					$('#poster_view').css("top",posterTop + 'px');
				}
			
				$('#venue_search_area').removeClass("open_venuearea").addClass("close_venuearea");
				$('#map_view').removeClass("open").addClass("close");
				$('#close_button').removeClass("open_view").addClass("close_view");
			}

			setTimeout(function(){
				number = 0;
			}, 800);
		}
	});
});
