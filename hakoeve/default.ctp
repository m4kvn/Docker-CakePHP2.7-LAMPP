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
 <?php echo $this->Html->charset(); ?>
 <title>
 <?php echo "HakoEve" ?>

 </title>
 <?php echo $scripts_for_layout; ?>

 <?php echo $this->Html->script('calendar2.js'); ?>
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
 <basefont face="小塚ゴシック Pro">
</head>
<body>
<div id="wrapper">
 <div id="container">


  <div id="header">

  <div class="header_background">
    <div class="header_title">
      <font color="#727171" style="font-size: 13px;">函館市近郊のイベントを検索できるサイトです。</font>>
      <a href="/../hakoeve/events/">
     <img src="/../hakoeve/img/header_logo.png" style="max-height:56px; widht: 140px;">
      </a>
    </div>
  </div>

  <div id="content">

   <?php echo $this->Session->flash(); ?>

   <?php echo $this->fetch('content'); ?>

  </div>



 <div id="footer">

 <TABLE width="965" border="0" align="right" padding="30" cellpadding="5" cellspacing="0">
<TR bgcolor="#FFFFFF" >
<TD width="168" valign="bottom" background="<?php echo $this->webroot;?>img/footbg.gif" class="txt3"><A href="/index.shtml"><IMG src="<?php echo $this->webroot;?>img/footimage.jpg" alt="概観" width="168" height="114" padding="30px" border="0"></A></TD>
<TD width="797" height="170" valign="bottom" background="<?php echo $this->webroot;?>img/footbg.gif" class="txt3">
<TABLE width="797" height="30" border="0" cellspacing="0" cellpadding="5">
<TR>
<TD width="17" class="txt2"><IMG src="<?php echo $this->webroot;?>img/footmark.jpg" width="17" height="17" ></TD>
<TD width="117" class="txt2" align="bottom"><A href="/about.html">インフォメーション</A></TD>
<TD width="17" class="txt2" align="bottom"><IMG src="<?php echo $this->webroot;?>img/footmark.jpg" width="17" height="17" ></TD>
<TD width="137" class="txt2" align="bottom"><A href="http://www.hakomachi.net/" target="_blank">まちのチカラサポート</A></TD>
<TD width="17" class="txt2" align="bottom"><IMG src="<?php echo $this->webroot;?>img/footmark.jpg" width="17" height="17" ></TD>
<TD width="108" class="txt2" align="bottom"><A href="/kankonews/index.html">函館観光情報</A></TD>
<TD width="17" class="txt2" align="bottom"><IMG src="<?php echo $this->webroot;?>img/footmark.jpg" width="17" height="17" ></TD>
<TD width="102" class="txt2" align="bottom"><A href="/iju2/">移住サポート</A></TD>
<TD width="94" align="right" class="txt2"><A href="/index.shtml"></A><IMG src="<?php echo $this->webroot;?>img/footmark.jpg" width="17" height="17" align="absmiddle"></TD>
<TD width="71" align="left"  nowrap class="txt2"><A href="/index.shtml"><B>トップページ</B></A></TD>
</TR>
</TABLE>
<A href="/index.shtml"><BR>
<IMG src="<?php echo $this->webroot;?>img/footlogo.jpg" alt="函館市地域交流まちづくりセンター" width="375" height="50" 　border="0"></A><BR>
<FONT color="#990000">〒040-0053
</FONT><A href="/access.html"><FONT color="#990000">函館市末広町4番19号</FONT></A><FONT color="#990000"> TEL:0138-22-9700／FAX 0138-22-9800</FONT>
<FONT color="#990000">
<script>

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new
Date();a=s.createElement(o),

m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-51791962-1', 'hakomachi.com');
 ga('send', 'pageview');

</script>


　<?php echo $this->Html->image('footmark.jpg',array('width'=>'17','height'=>'17','hspace'=>'2','align'=>'absmiddle')); ?><A href="/about.html">まちづくりセンターについて</A></FONT></TD>
</TR>
</TABLE>
  </div>
 </div>
 </div>
 <?php echo $this->element('sql_dump'); ?>
</body>
</html>