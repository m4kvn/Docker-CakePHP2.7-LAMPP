/**
 *  jquery.multicols.js for CakePHP
 *  
 *  you can get align your favorite form elements columns.
 *
 *  Copyright (c) 2010 Ogaaaan. 
 *  ogaaaan@yahoo.co.jp
 *  LGPL License
 */
(function($) {
  $.fn.multicols = function(options){
    var defaults = {
      cols: 3,
    };
    var options = $.extend(defaults, options); 
    var len = $(this).size();
    if(len<1) return false;
    var column = Math.ceil(len/options.cols);
    $(this).parent().append('<div style="clear:left" class="clerfix"></div>');
    for(j=0;j<options.cols;j++) {
      $(this).slice(j*column, j*column+column).wrapAll('<div style="float:left"></div>');
    }
  }
})(jQuery);
