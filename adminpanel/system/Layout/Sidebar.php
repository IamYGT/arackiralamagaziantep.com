<?php
Namespace AdminPanel;

class Sidebar extends  Settings
{
    public  $sidebar;
    public  $settings;

    public function __construct($settings,$sidebarList)
    {

        parent::__construct($settings,$sidebarList);

        $this->sidebar = $sidebarList;
        $this->settings = $settings;

    }


    public function sidebar($a=0)
    {
        return $this->_inc('Sidebar',array('a'=>$a,'sidebar'=>$this->sidebar));

    }



}





?>