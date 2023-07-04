
<div class="box <?=(($this->get_element('BoxColor')) ? $this->get_element('BoxColor'):null)?>">
    <div class="box-header with-border">
        <h3 class="box-title"><?=((isset($param['icbaslik'])) ? $param['icbaslik']:null)?></h3>


    </div>
    <div class="box-body">
        <div class="row">

            <?
                $pageUrl = $this->BaseAdminURL()."/?cmd=".$_GET["cmd"];

                if (isset($_GET["kelime"])){
                    $pageUrl.="&kelime=".$_GET["kelime"];
                }
                        $sayfa = (isset($_GET["sayfa"])) ? $this->kirlet(intval($_GET['sayfa'])) : 1;
                        if (isset($param["toplamVeri"])){


                            $toplamVeri = $param["toplamVeri"];



                            if (!is_numeric($sayfa)){
                                $sayfa = 1;
                            }

                            $sayfaLimit = isset($param["sayfaLimit"]) ? $param["sayfaLimit"] : $this->settings->config('veriLimit');

                            $toplamSayfa = ceil($toplamVeri / $sayfaLimit);

                            if ($sayfa > $toplamSayfa)
                            {
                                $sayfa = 1;
                            }


                        }
            ?>
            <div class="col-lg-12">
            <?php
                if(isset($param['flitpage']) and is_array($param['flitpage'])):

                $form =   new AdminPanel\Form($this->settings);
               echo   '<div class="col-lg-6">'.$form->select(array('title'=>(isset($param['flitpage']['title'])) ?  $param['flitpage']['title']:null,'name'=>(isset($param['flitpage']['name'])) ?  $param['flitpage']['name']:'katfild','data'=> $form->parent(array('sql'=>((isset($param['flitpage']['sql'])) ? $param['flitpage']['sql']:null),'option'=>((isset($param['flitpage']['option'])) ? $param['flitpage']['option']:array('value'=>'id','title'=>'kategori')),'kat'=>((isset($param['flitpage']['kat'])) ? $param['flitpage']['kat']:null),'selected'=>((isset($param['id'])) ? $param['id'] :'')),0,0))).'</div>';
           endif;

               echo'<div class="col-lg-6 pull-right" style="text-align: right">';
                    if(isset($param['button']) and is_array($param['button'])):

                    foreach($param['button'] as $button):

                   echo'<a style="margin-right:20px;" ';
                    if(isset($button['data']) and is_array($button['data']))
                    foreach ($button['data'] as $key=>$value):
                   echo "data-".$key.'="'.$value.'"';
                    endforeach;

                   echo'href="'.((isset($button['href'])) ? $button['href'] : '').'" id="'.((isset($button['id'])) ? $button['id'] : '').'" class="btn sbold '.((isset($button['color'])) ? $button['color'] : '').' pull-right"> <i class="'.((isset($button['icon'])) ? $button['icon'] : 'fa fa-plus').'"></i> '.((isset($button['title'])) ? $button['title'] : '').'</a>';

                    endforeach;
                    endif;
?>
</div>
            </div>
        </div>
        <br clear="all">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold"><?=((isset($param['title'])) ? $param['title'] : '')?></span>
                                <?
                                    if (isset($param["veri"])){
                                ?>
                                    <br><input style="display:inline-block; width: auto !important; margin-top:10px;" type="text" value="<?=$param["veri"]["sifre"]?>" id="teknik_sifre" class="form-control" name="teknik_sifre">
                                    <a href="<?=$this->BaseAdminURL()."/?cmd=".$param["page"]."/degistir"?>" id="sifreGuncelle" class="btn sbold blue " <?=isset($param["veri"]["id"])?>> <i class="fa fa-retweet"></i> Güncelle</a>
                                <?
                                    }
                                ?>
                </div>
                <div class="tools">
                        <?
                        if (isset($param["search"])){
                        ?>
                            <div class="col-md-12">

                            <?

                                switch ($param["page"]) {
                                    case "Urun":
                                        $place = "Ürün adı veya Kodu Giriniz";
                                    break;

                                    case "Referanslar":
                                        $place = "FİRMA ADI GİRİNİZ";
                                    break;

                                    case "haberler":
                                        $place = "HABER BAŞLIĞI GİRİNİZ";
                                    break;

                                    case "urunGrubu":
                                        $place = "KATEGORİ ADI GİRİNİZ";
                                    break;
                                    case "Projeler":
                                        $place = "BAŞLIK GİRİNİZ";
                                    break;
                                    case "Teknik":
                                    case "Temsilcilik":
                                        $place = "Firma Adı / Kişi Adı / Email Giriniz";
                                    break;

                                    default:
                                    // code...
                                    break;
                                }
                            ?>
                              <input style="display:inline-block; width: auto !important;" data-url="<?=$pageUrl?><?=(isset($_GET["sayfa"])) ? '&sayfa='.$_GET["sayfa"] : '&sayfa=1'?>" type="text"
                              value="<?=(isset($_GET["kelime"])) ? $_GET['kelime'] : ''?>" placeholder="<?=$place?>" id="kelime" class="form-control "  name="kelime">
                              <a style="margin-right:0px; margin-top: -3px;" href="#" id="araButon" class="btn sbold blue-madison"> <i class="fa fa-search"></i> ARA</a>
                                <? if (isset($_GET["kelime"])) {?>
                              <br><br><a href="<?=$this->BaseAdminURL()."/?cmd=".$_GET["cmd"]?>" class="btn sbold red " style="margin-right:15px;"> <i class="fa fa-remove"></i> Aramayı Temizle</a><br>
                              <span class="caption-subject bold"><?=$toplamVeri?> Adet Sonuç Bulundu.</span>
                                <? } ?>



                        </div>



                        <?
                        }
                        ?>

                </div>
            </div>
            <div class="portlet-body">
                <br clear="all">
                <table class="table table-striped table-bordered table-hover sorted_table" data-page="<?=$sayfa?>" id="sortable" <?=((isset($param['page'])) ? 'data-id="'.$param['page'].'"':null)?>>
                <thead>
                <tr>

                    <?
                        if (isset($param["resim"]) && is_array($param["resim"])){
                    ?>

                    <th class="resimBlok"  style="width: 7%"> Resim</th>

                    <? } ?>
<?php
                    if(isset($param['baslik']) and is_array($param['baslik']))
                    foreach($param['baslik'] as $baslik):
                       echo'
                        <th style="'.((isset($baslik['width']) ? 'width:'.$baslik['width'].';':'')).'"> '.$baslik['title'].' </th>
                        ';
                    endforeach;


?>



                    <th style="width: 15%">Araçlar</th>
                </tr>
                </thead>

                <tbody>

                <?php

                if(isset($param['p']) and is_array($param['p'])):
                if(isset($param['pdata']) and is_array($param['pdata'])):
                foreach($param['pdata'] as $pdata):

                    if ($param["page"] != "Teknik" && $param["page"] != "Temsilcilik"){
                         echo'   <tr '.((isset($pdata['id'])) ? 'data-id="'.$pdata['id'].'"':null).'>';
                    }
                    else {
                         echo'   <tr '.((isset($pdata['id'])) ? 'data-id="'.$pdata['id'].'"':null).' class="goruldu_'.$pdata["goruldu"].'">';
                    }



                    if (isset($param["resim"]) && is_array($param["resim"])){
                        $resim = $this->resimGet($pdata[$param["resim"]["dosya"]]);
                        $dizin = $param["resim"]["dizin"];
                        if ($resim && file_exists($dizin.$resim)){
                            $resAl = $this->BaseURL($this->resimal(0,50,$resim,$dizin));
                            echo "<td  align='center'><a class='popImage' rel='list_".$param["page"]."' href='".$dizin.$resim."'><img src='".$resAl."'></a></td>";
                        }
                        else {
                            $resAl = $this->BaseAdminURL()."/img/noimage.png";
                            echo "<td  align='center'><img src='".$resAl."'></td>";
                        }

                    }


                foreach($param['p'] as $p) if(is_array($p))echo'<td class="'.((isset($p['class'])) ? $p['class'] : '').'" tabindex="'.((isset($p['tabindex'])) ? $p['tabindex'] : '').'" data-itemsayfa="'.$sayfa.'">
                    '.((isset($p['dataTitle'])) ? ((isset($p['type']) and $p['type']=='date') ? date('d-m-Y',$pdata[$p['dataTitle']]):$this->temizle($pdata[$p['dataTitle']])) : '').((isset($p['ek']) && $p['ek']!='') ? ' | <b>'.$pdata[$p["ek"]]."<b>" : '').'</td>';
                else echo'<td> '.$p.' </td>';

                if(isset($param['buton']) and is_array($param['buton'])):
                foreach($param['buton'] as $but):

                if(isset($but['type']))
                switch($but['type']):
                    case 'radio':
            echo '<td style="width: 5%">
<input type="checkbox" name="state" data-off-color="warning" onchange="$.panel.durum(this,\''.((isset($pdata['id']) ? $pdata['id']:0)).'\',\''.((isset($but['url'])) ?$but['url']:null).'\')"  data-on-color="success" data-on-text="Aktif" data-off-text="Pasif" value="'.((isset($pdata[$but['dataname']])) ? $pdata[$but['dataname']]:0).'" '.((isset($pdata[$but['dataname']]) and $pdata[$but['dataname']]==1) ? 'checked':'null').'></td>';
             break;
                    case 'checkbox':
                    echo  '<td>check</td>';
                    break;
                    case 'button':
    echo  '<td><a href="'.((isset($but['url']) ? $but['url'] :'')).'&folder='.((isset($but['folder']) ? base64_encode($but['folder']) :'')).'&modul='.((isset($but['modul']) ? $but['modul'] :'')).'&gelenid='.((isset($pdata['id']))? $pdata['id']:null).'" class="dosya fancybox.iframe '.((isset($but['class']) ? $but['class'] :'')).'" >'.((isset($but['title']) ? $but['title'] :'')).'</a> </td>';
;
                        break;
           case 'button2':
            echo   '<td><a   href="'.((isset($but['url']) ? $but['url'] :'')).$pdata['id'].'" class="'.((isset($but['class']) ? $but['class'] :'')).'" >'.((isset($but['title']) ? $but['title'] :'')).'</a> </td>';


                        break;

                endswitch;
                endforeach;

                endif;

               echo'<td>';

                foreach($param['tools'] as $tool):
                   echo' <a href="'.((isset($tool['url'])) ? $tool['url'].$pdata['id']: 'javascript:;').'" class="btn btn-sm btn-outline '.((isset($tool['color'])) ? $tool['color']: '').'">
                        <i class="'.((isset($tool['icon'])) ? $tool['icon']: '').'"></i> '.((isset($tool['title'])) ? $tool['title']: '').'</a>';

                    endforeach;
                echo '</td> </tr>';

                endforeach;
                endif;
                endif;
              ?>
                </tbody>  </table>    </div>
        </div>

        <div id="showmsg">

        </div>
        <div class="sayfalama">
                        <?
                            if (isset($param["toplamVeri"])){


                             if ($toplamSayfa > 1){
                        ?>


                    <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                        <ul class="pagination">
                            <?
                            if( $sayfa > 1 )
                            {
                                $ilk = $pageUrl;

                                $onceki = $pageUrl."&sayfa=".($sayfa - 1);
                                echo '<li class="paginate_button previous" id="example2_previous"><a href="'.$ilk.'" aria-controls="example2" data-dt-idx="0" tabindex="0">İlk Sayfa</a></li>';
                                echo '<li class="paginate_button previous" id="example2_previous"><a href="'.$onceki.'" aria-controls="example2" data-dt-idx="0" tabindex="0">Önceki</a></li>';
                            }
                            ?>

                    <?
                    for( $i = $sayfa - 3; $i < $sayfa + 4; $i++ )
                    {
                        if( $i > 0 && $i <= $toplamSayfa )
                        {
                            $url = $pageUrl."&sayfa=".$i;
                    ?>

                        <li class="paginate_button <?=($i == $sayfa) ? 'active' : ''?>"><a href="<?=$url?>" aria-controls="example2"><?=$i?></a></li>

                    <?
                        }
                    }

                    if( $sayfa != $toplamSayfa )
                    {

                        $sonraki = $pageUrl."&sayfa=".($sayfa + 1);
                        $son = $pageUrl."&sayfa=".$toplamSayfa;

                        echo '<li class="paginate_button next" id="example2_next"><a href="'.$sonraki.'" aria-controls="example2" data-dt-idx="7" tabindex="0">Sonraki</a></li>';

                        echo '<li class="paginate_button next" id="example2_next"><a href="'.$son.'" aria-controls="example2" data-dt-idx="7" tabindex="0">Son Sayfa</a></li>';
                    }
                ?>





                        </ul>
                    </div>

                    <?
                        }
                    }
                    ?>
        </div>
    </div>
    <!-- /.box-body -->

    <!-- /.box-footer-->
</div>
