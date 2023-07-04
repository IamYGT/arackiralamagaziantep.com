<!DOCTYPE HTML>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js"> <!--<![endif]-->
<head>

    <link href="<?=$this->themeURL?>css/style.css" rel="stylesheet" type="text/css">
 <style>
     html,body { height: 100%; width: 100%;}
     * { margin: 0px; padding:0px; border: 0px;}
     body { overflow: hidden !important;}
 </style>
</head>
<body class="main">

<?php

if($lang=="tr")
    $video = $this->teksorgu("select * from videolar where id='$id'");
else
    $video = $this->teksorgu("select * from videolar where dil='$lang' and masterid='$id'");


?>
<div style="width: 100%; text-align: center;   overflow: hidden; " class="video videoframe">
    <?=$this->temizle($video['embed'])?>
   </div>

</body>
</html>