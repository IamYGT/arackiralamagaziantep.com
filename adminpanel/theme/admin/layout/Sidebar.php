<?php
/**
 * Created by PhpStorm.
 * User: Abdulkadir
 * Date: 14.11.2016
 * Time: 00:47
 */

if($a==0):
    $text = '<ul class="sidebar-menu">';
else:
    $text = '';
endif;


foreach($sidebar as $side):
    if(isset($side['display']) and $side['display']):
        if(is_array($side['submenu'])):
            $text .='<li class="treeview">
                                <a href="javascript:;">
                                     <i class="'.$side['icon'].'"></i>
                                      <span class="title">'.$side['title'].'</span>

                                <i class="fa fa-angle-left pull-right"></i>
                                </a>';
            $text .='  <ul class="treeview-menu">';
            foreach($side['submenu'] as $sd):
                if(isset($sd['display']) and $sd['display'])
                    $text .='  <li class="treeview ">
                                        <a href="'.$this->BaseAdminURL($side['href'].'/'.$sd['href']).'.html" class="">
                                            <i class="'.$sd['icon'].'"></i>
                                             <span class="title">'.$sd['title'].'</span>
                                         <!--   <span class="badge badge-success">1</span> -->
                                        </a>
                                    </li>';
            endforeach;

            $text .='</ul>';
        else:

            $text .='<li class="treeview  ">
                                <a href="'.$this->BaseAdminURL($side['href']).'" class="">
                                   <i class="'.$side['icon'].'"></i>
                                <span class="title">'.$side['title'].'</span>

                                </a>';

        endif;
        $text .= '</li>';

    endif;

endforeach;

if($a==0): $text .= '</ul> '; endif;

echo  $text;
