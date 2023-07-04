<?php
	session_start();
    include('../vendor/autoload.php');
	include('system/AutoLoader.php');
    include('system/class.fileuploader.php');
	include '../include/Ayarlar.php';
    include('../include/Smap.php');
    include('../include/Functions.php');
    include('../include/Database.php');
	include('system/Modules.php');
	include('system/Settings.php');
    include('system/ThemeLoader.php');


    $settings = new AdminPanel\Ayarlar('../include/');
    $controller_loader = new AdminPanel\AutoLoader('controller');
    $modules_loader = new AdminPanel\AutoLoader('modules');
    $layout_loader = new AdminPanel\AutoLoader('system/');
    spl_autoload_register(array($controller_loader, 'autoload'));
    spl_autoload_register(array($layout_loader, 'layout'));
    spl_autoload_register(array($modules_loader, 'autoload'));
    $theme = new AdminPanel\Theme($settings,$settings->sidebar());
    $control = new AdminPanel\Controller(((isset($_GET['cmd'])) ? $_GET['cmd']:'Index'),$settings);
    $modul = explode('/',((isset($_GET['cmd'])) ? $_GET['cmd']:'Index'));
    $sistem = array('Files','Sirala','Dosya','Login');
    if(!in_array($modul[0],$sistem)):
      $theme->load('theme/'.$settings->config('adminTheme').'/master',
          array(
          'settings'=> $settings,
          'control' => $control,
          'sidebar'=>$theme
          )
      );
    endif;

?>