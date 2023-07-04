<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 02.03.2016
 * Time: 14:18
 */

namespace AdminPanel;

class AutoLoader
{
    private $directory_name;

    public function __construct($directory_name=null)
    {
        $this->directory_name = $directory_name;
    }

    public function autoload($class_name)
    {
       $filename =  explode("\\",$class_name);
       $filename = $filename[count($filename)-1];

        $file_name = ucwords(strtolower($filename)).'.php';

        $file = $this->directory_name.'/'.$file_name;

        if (file_exists($file) == false)
        {
            return false;
        }
        include ($file);
    }


    public function Layout($class_name)
    {
        $filename =  explode("\\",$class_name);
        $filename = $filename[count($filename)-1];

        $file_name = 'Layout/'.ucwords(strtolower($filename)).'.php';

        $file = $this->directory_name.'/'.$file_name;

        if (file_exists($file) == false)
        {
            return false;
        }
        include ($file);
    }




}




?>