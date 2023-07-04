<?php
/**
 * Created by PhpStorm.
 * User: Abdulkadir
 * Date: 24.10.2016
 * Time: 00:23
 */

$text = '
<div class="row">
<div class="col-lg-12">
<table id="fiyatekle" style="width: 100%;">
<thead>
<tr>


';
if(is_array($param['title']))
    foreach ($param['title'] as $title)  $text .='<th style="width: 50%; text-indent: 20px;  border-bottom: 5px solid #fff;  line-height: 40px; background-color: #ccc;">'.$title.'</th>';



$text.='
</tr>
</thead>
<tbody>

';
$fiyatlar =  json_decode($param['values']['fiyat']['value'],JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$tarihler =  json_decode($param['values']['tarih']['value'],JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


if(is_array($param['values']) and count($fiyatlar)>0):

    $text .='<tr>';

    if(count($param['values']['fiyat'])>0 and is_array($param['values']['fiyat'])):

        for ($i=1;$i<=count($fiyatlar);$i++):


            foreach ($param['items'] as $item):
                if($item['name']=='fiyat')    $text .= '<td '.((isset($item['width'])) ? 'width="'.$item['width'].'"':null).'>'.self::input(array_merge($item['param'],array('value'=>$fiyatlar[$i-1]['fiyat'.$i]))).'</td>';
                if($item['name']=='tarih')    $text .= '<td '.((isset($item['width'])) ? 'width="'.$item['width'].'"':null).'>'.self::input(array_merge($item['param'],array('value'=>$tarihler[$i-1]['tarih'.$i]))).'</td>';
            endforeach;

            $text .='</tr>';

        endfor;
    endif;
else:
    $text .='<tr>';

    foreach ($param['items'] as $item):
        $text .= '<td '.((isset($item['width'])) ? 'width="'.$item['width'].'"':null).'>'.self::input($item['param']).'</td>';
    endforeach;

    $text .='</tr>';
endif;



$text .=' 
    
                                         </tbody>      </table>
                                       <button id="eklefiyat" class="btn btn-success">Satır Ekle</button>     
                                            </div></div>
                                        <div style="display: none;" class="ornek">
                                        <table>
                                        <tr>
                                        ';

foreach ($param['items'] as $item):
    //unset($item['param']['name']);
    $text .= '<td '.((isset($item['width'])) ? 'width="'.$item['width'].'"':null).'>'.self::input($item['param']).'</td>';
endforeach;

$text .='</tr></table>
                                        
</div>    
                                            
                                            <br clear="all">';



echo $text;