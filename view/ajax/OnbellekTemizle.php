<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 12.05.2017
 * Time: 18:19
 */

   if(is_dir($this->settings->cache('klasor'))):

       $this->deleteDir($this->settings->cache('klasor'));

   endif;

echo 1;