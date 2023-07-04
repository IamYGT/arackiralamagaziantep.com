<?php
error_reporting(0);
session_start();
include( __DIR__.'/include/Request.php');
include( __DIR__.'/include/Ayarlar.php');
$page = Request::GET('page','index');
$type = Request::GET('type','master');
$ayarlar = new \AdminPanel\Ayarlar();
$istisna =  $ayarlar->cache('istisna');
if($ayarlar->cache('durum') and $type=="master" and !in_array($page,$istisna)):
    if($ayarlar->cache('klasor') and !is_dir($ayarlar->cache('klasor'))) mkdir($ayarlar->cache('klasor'),0755);
    $pageU = substr(str_replace('/','-',$_SERVER["REQUEST_URI"]),1);
    $pageU = ($pageU) ? $pageU:'index.html';
    $pageURL = $ayarlar->cache('klasor').DIRECTORY_SEPARATOR.$pageU;
    if ($pageU and file_exists($pageURL) and (time() - (($ayarlar->cache('zamanasimi') and is_numeric($ayarlar->cache('zamanasimi'))) ? $ayarlar->cache('zamanasimi'):1800) < filemtime($pageURL))) {
        include($pageURL);
        exit;
    }
endif;

ob_start();



include 'Loader.php';
$front = new \Loader($ayarlar);

$id   = Request::GET('id',0);
$kid  = Request::GET('kid',0);
$lang = Request::GET('lang','tr');
$sayfa = Request::GET('sayfa','1');
$url = Request::GET('url','');
$urunurl = Request::GET('urunurl','');
$katurl = Request::GET('katurl','');
$front->TokenCont('uruntalep','');


if($type == "ajax"):
    $front->ajaxLoader($page);
else:
    $data =  [
        'id' => $id,
        'kid' => $kid,
        'page' =>$page,
        'lang' => $lang,
        'content' => $front->pageLoader(
            [
                'sayfa' => $sayfa,
                'page' =>$page,
                'id' => $id,
                'kid' => $kid,
                'lang' => $lang,
                'url' => $url,
                'katurl' => $katurl,
                'urunurl'=>$urunurl
            ])];



    if ($page != "e-katalog"){
        echo  $front->_include('master',$data,$front->settings->config('siteTemasi').'/');
    }

    else {
        echo  $front->_include('index',$data,$front->settings->config('siteTemasi').'/e-katalog/');
    }


endif;



?>