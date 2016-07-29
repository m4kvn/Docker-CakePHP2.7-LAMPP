<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (coffee) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (coffee) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->meta('icon'); ?>
</head>

<a name="pagetop"></a>
 <?php echo $this->Html->charset(); ?>
 <title>
 <?php echo $title_for_layout;/*echo "イベント検索サービス HakoEve";*/ ?>

 </title>
 <?php echo $scripts_for_layout; ?>

 <?php
 echo $this->Html->script('calendar2.js');
 echo $this->Html->script('changeColor');
  echo $this->Html->script('jquery-1.10.2.min.js');
echo $this->Html->script('accodion.tab.js');
 ?>
 <?php echo $this->Html->css('day_search'); ?>
   <?php echo $this->Html->css('events.index.venue'); ?>
<?php echo $this->Html->script('day_display'); ?>
<?php echo $this->Html->script('jquery.exresize.0.1.0'); ?>

 <?php
  echo $this->Html->meta('icon', '/cake/hakoeve/img/favicon.ico');



  echo $this->Html->css('cake.generic');
  echo $this->Html->css('header');

//   echo $this->Html->css('styles');
//   echo $this->Html->css('blog');
//   echo $this->Html->css('design');
//   echo $this->Html->css('screen');

  echo $this->fetch('meta');
  echo $this->fetch('css');
  echo $this->fetch('script');

 ?>

<!-- SEO対策 ここから -->
<meta name="keywords" content="はこいぶ,ハコイブ,イベント,函館,はこイブ,はこイヴ,はこイベ">
<meta name="description" content="イベント検索サービス HakoEve(はこイブ)は函館市近郊のイベントを検索できるサイトです。誰でも簡単に函館市近郊のイベントを探すことができます。このサイトは函館市地域交流まちづくりセンターが運営しています。">
<!-- SEO対策 ここまで -->

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.css" />

 <script type="text/javascript">

      $('#jqtab-example3 > ul').tabs({ fxSlide: true });

  </script>
 <!--
 <basefont face="小塚ゴシック Pro">
 -->



<body>



  <div id="header">

  <div class="header_background">
    <div class="header_title">

      <!--
      <font color="#727171" style="font-size: 13px; top:10px">
      函館市近郊のイベントを検索できるサイトです。
      </font>
    -->

      <a href="http://hakomachi.com/">
        <font color="#727171" style="font-size: 13px; float: right;padding-left: 15px; margin-top: 5px;">
        ▶︎函館市地域交流まちづくりセンター
        </font>
      </a>

      <a href="/../hakoeve/events/about">
        <font color="#727171" style="font-size: 13px; float: right; padding-left: 15px; margin-top: 5px;">
        ▶︎HakoEveについて
        </font>
      </a>

      <a href="/../hakoeve/events/about_add">
        <font color="#727171" style="font-size: 13px; float: right; padding-left: 15px; margin-top: 5px;">
        ▶︎イベント登録したい方はこちら</font>
      </a>

      <a href="/../hakoeve/events/">
        <font color="#727171" style="font-size: 13px; float: right; margin-top:5px;">
        ▶︎HOME
        </font>
      </a>


      <a href="/../hakoeve/events/">
        <img src="/../hakoeve/img/header_logo.png" style="height:auto; width: 240px; position: absolute; top: 10px;">
      </a>

      <div id="header_text">
         <font color="#727171" style="font-size: 13px; float: right; text-align: right; line-height:1.5em;">

          函館市近郊のイベントを検索できるサイトです。
         <br>
          このサイトは函館市地域交流まちづくりセンターが運営しています。
        </font>
      </div>

    </div>
  </div>

  <div class="header_background2">
  </div>

  <div class="header_search_background">
    <div class="header_search">
      <ul style="padding: 0px; margin: 0px;">
        <li class="search_button" style="width:228px; margin: 0px;">
          <div class="search_title" style="width: 228px; margin-bottom: 10px;">キーワードから探す</div>
          <form novalidate="novalidate" id="searchform4" method="post" action="/hakoeve/events" accept-charset="utf-8">
            <input name="data[Event][keyword]" id="keywords4" value="" type="text" placeholder="キーワードを入力"/>
            <input type="image" src="/../hakoeve/img/btn4.gif" alt="検索" name="searchBtn4" id="searchBtn4"/>
          </form>
        </li><!--
     --><li class="search_button" id="day_button">
          <div class="search_line" id="day_line"></div>
          <div class="search_title">日付から探す</div>
          <div class="search_detail">DAYS</div>
          <img src="/../hakoeve/img/search_arrow_off.png" class="search_arrow" id="day_arrow">
        </li><!--
      --><li class="search_button" id="category_button">
          <div class="search_line" id="category_line"></div>
          <div class="search_title">ジャンルから探す</div>
          <div class="search_detail">CATEGORIES</div>
          <img src="/../hakoeve/img/search_arrow_off.png" class="search_arrow" id="category_arrow">
        </li><!--
     --><li class="search_button" id="map_button">
          <div class="search_line" id="map_line"></div>
          <div class="search_title">場所から探す</div>
          <div class="search_detail">MAPS</div>
          <img src="/../hakoeve/img/search_arrow_off.png" class="search_arrow" id="map_arrow">
        </li><!--
     --><a href="/../hakoeve/eventImages/index"><li class="search_button" id="poster_button">
          <div class="search_line" id="poster_line"></div>
          <div class="search_title">ポスター一覧</div>
          <div class="search_detail">POSTERS</div>
        </li></a><!--
     --><a href="/../hakoeve/events/all/1"><li class="search_button" id="all_button" style="border-right: solid 1px #c9caca;">
          <div class="search_line" id="all_line"></div>
          <div class="search_title">イベント一覧</div>
          <div class="search_detail">ALL</div>
        </li></a>
      </ul>
    </div>
  </div>
  <div class="menu">
        <div id="day_view" class="close">
          <?php echo $this->element('day_search'); ?>
        </div>
        <div id="category_view" class="close">
		 	    <?php echo $this->element('tag');?>
        </div>
        <div id="map_view" class="close" >
          <?php echo $this->element('venue');?>
        </div>
      </div>
  </div>
  <div class="close_view" id="close_button">
  ✕　閉じる
  </div>
</div>

  <div id="content">

   <?php echo $this->Session->flash(); ?>

   <?php echo $this->fetch('content'); ?>

  </div>




<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new
Date();a=s.createElement(o),

m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-51791962-1', 'hakomachi.com');
 ga('send', 'pageview');

</script>

<?php echo $this->element('footer'); ?>



  </div>


 <?php echo $this->element('sql_dump'); ?>
</body>
</html>