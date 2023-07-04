<?php
Namespace AdminPanel;

class Layout
{

    private  $settings;
    private  $sidebar;



    public function __construct($settings,$sidebarList)
    {
       // parent:__construct($settings,$sidebarList);

        $this->settings = $settings;
        $this->sidebar = $sidebarList;


    }

    public function sidebar($a=0)
    {

        if($a==0):
            $text = '
                       <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">';
        else:
            $text = '';
        endif;


        foreach($this->sidebar as $side):
            if(isset($side['display']) and $side['display']):
            if(is_array($side['submenu'])):
                $text .='<li class="nav-item   ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                     <i class="'.$side['icon'].'"></i>
                                      <span class="title">'.$side['title'].'</span>

                                    <span class="arrow"></span>
                                </a>';
                $text .='  <ul class="sub-menu">';
                foreach($side['submenu'] as $sd):
                    if(isset($sd['display']) and $sd['display'])
                    $text .='  <li class="nav-item ">
                                        <a href="'.$_SESSION['settings']['url'].$_SESSION['settings']['adminfolder'].(($_SESSION['settings']['adminSeo']) ?  '/':'?cmd=').$side['href'].'/'.$sd['href'].'.html" class="nav-link  ">
                                            <i class="'.$sd['icon'].'"></i>
                                             <span class="title">'.$sd['title'].'</span>
                                         <!--   <span class="badge badge-success">1</span> -->
                                        </a>
                                    </li>';
                endforeach;

                $text .='</ul>';
            else:

                $text .='<li class="nav-item  ">
                                <a href="'.$_SESSION['settings']['url'].$_SESSION['settings']['adminfolder'].(($_SESSION['settings']['adminSeo']) ?  '/':'?cmd=').$side['href'].'" class="nav-link nav-toggle">
                                   <i class="'.$side['icon'].'"></i>
                                <span class="title">'.$side['title'].'</span>

                                </a>';

            endif;
            $text .= '</li>';

                endif;

        endforeach;

        if($a==0): $text .= '</ul> '; endif;

        return $text;

    }



}





?>