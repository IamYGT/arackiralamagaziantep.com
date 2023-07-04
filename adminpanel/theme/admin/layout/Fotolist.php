 <div class="box <?=(($this->get_element('BoxColor')) ? $this->get_element('BoxColor'):null)?> ">
        <div class="box-header with-border">
          <h3 class="box-title"><?=((isset($param['icbaslik'])) ? $param['icbaslik']:null)?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
<div class="row">
<div class="col-lg-12">
<?php
if(isset($param['flitpage']) and is_array($param['flitpage'])):
    $form =   new Adminpanel\Form($this->settings);
   echo   '<div class="col-lg-6">'.$form->select(array('title'=>(isset($param['flitpage']['title'])) ?  $param['flitpage']['title']:null,'name'=>(isset($param['flitpage']['name'])) ?  $param['flitpage']['name']:'katfild','data'=> $form->parent(array('sql'=>((isset($param['flitpage']['sql'])) ? $param['flitpage']['sql']:null),'option'=>((isset($param['flitpage']['option'])) ? $param['flitpage']['option']:array('value'=>'id','title'=>'kategori')),'kat'=>((isset($param['flitpage']['kat'])) ? $param['flitpage']['kat']:null),'selected'=>((isset($param['id'])) ? $param['id'] :'')),0,0))).'</div>';
endif;
?>
    <div class="col-lg-6 pull-right" style="text-align: right">
        <div class="control-group">


                    <div id="dosyayukle">

           

                        <div id="yukleme"></div>
                        
                    <a id="pickfiles" class="<?=((isset($param['yukle']['class']) ? $param['yukle']['class'] :''))?>" href="javascript:;"
                        data-id="<?=((isset($param['id'])) ? $param['id']:0)?>"
                        data-url="<?=((isset($param['yukle']['folder']) ? base64_encode($param['yukle']['folder']) :''))?>"
                        data-type="<?=((isset($param['yukle']['modul']) ? $param['yukle']['modul'] :''))?>"
                        data-name="<?=((isset($param['yukle']['name']) ? $param['yukle']['name'] :''))?>" >
                        <i class="halflings-icon plus white"></i><?=((isset($param['yukle']['title']) ? $param['yukle']['title'] :''))?></a>
                        <a id="uploadfiles" href="javascript:;" class="hidden">[ Yükle ]</a>

                    </div>

                    <div id="filelist"></div>
                    <div id="console" class="alert-error"></div>


                </div>


<?php

if(isset($param['button']) and is_array($param['button'])):
    foreach($param['button'] as $button):
       echo'<a  href="'.((isset($button['href'])) ? $button['href'] : '').'" id="'.((isset($button['id'])) ? $button['id'] : '').'" class="btn sbold '.((isset($button['color'])) ? $button['color'] : '').' pull-right"> '.((isset($button['title'])) ? $button['title'] : '').'
                     <i class="fa fa-plus"></i></a>';
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
                                     </div>
                                    <div class="tools"> </div>
                                </div>
                                <div class="portlet-body">
                                 <br clear="all">
                             <table class="table table-striped table-bordered table-hover sorted_table" id="sortable" <?=((isset($param['page'])) ? 'data-id="'.$param['page'].'"':null)?>>
                                        <thead>
                                            <tr>
                                       <!--     <th class="sorting_asc" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" data-column-index="0" aria-sort="ascending" aria-label=" Rendering engine : activate to sort column descending" style="width: 277px;"> Rendering engine </th> -->
         <?php
if(isset($param['baslik']) and is_array($param['baslik']))
    foreach($param['baslik'] as $baslik):
       echo'
                                         <th style="'.((isset($baslik['width']) ? 'width:'.$baslik['width'].';':'')).'"> '.$baslik['title'].' </th>
 ';                                   endforeach;

 ?>
                               <th style="width: 15%">Araçlar</th>
                                     </tr>
                                        </thead>

                                        <tbody> <?

if(isset($param['p']) and is_array($param['p'])):
    if(isset($param['pdata']) and is_array($param['pdata'])):
        foreach($param['pdata'] as $pdata):

           echo'   <tr '.((isset($pdata['id'])) ? 'data-id="'.$pdata['id'].'"':null).'>';
            if (isset($param["pfolder"])){
               
              foreach($param['p'] as $p){
                $resim  = $this->resimGet($pdata[$p["dataTitle"]]);
                if(is_array($p)){
                  echo'<td class="'.((isset($p['class'])) ? $p['class'] : '').'" tabindex="'.((isset($p['tabindex'])) ? $p['tabindex'] : '').'">';
                  if ($p["dataTitle"] == "dosya"){
                    if (file_exists($param["pfolder"].$resim)){
                      $resAl = $this->BaseURL($this->resimal(0,100,$resim,"../".$this->settings->config('folder').$param["pfolder"]."/"));
                ?>
                  <a href="<?=$param["pfolder"].$resim?>" class="popImage" rel="example_group">
                    <img style="height:100px;" src="<?=$resAl?>"></a>
                <?
              }
              elseif(file_exists('../'.$this->settings->config('folder').$resim)) {

                $resAl = $this->BaseURL($this->resimal(0,100,$resim,"../".$this->settings->config('folder')));
              
              ?>
                    <a href="<?=$param["pfolder"].$resim?>" class="popImage" rel="example_group">
                      <img style="height:100px;" class="second" src="<?=$resAl?>">
                    </a>
                <?
              }
                  }
                  else {
                    echo $pdata["sira"];
                  }
                  echo "</td>";
                }
              }
            }
            else {
              foreach($param['p'] as $p) if(is_array($p))echo'<td class="'.((isset($p['class'])) ? $p['class'] : '').'" tabindex="'.((isset($p['tabindex'])) ? $p['tabindex'] : '').'">
                                        '.((isset($p['dataTitle']) and $pdata[$p['dataTitle']]) ? $pdata[$p['dataTitle']] : $pdata['dosya']).'</td>';
              else echo'<td> '.$p.' </td>';

            }
            

            if(isset($param['buton']) and is_array($param['buton'])):
                foreach($param['buton'] as $but):

                    if(isset($but['type']))
                        switch($but['type']):
                            case 'radio':
                                echo '<td style="width: 5%">
<input type="checkbox" name="state" data-off-color="warning" onchange="$.panel.durum(this,\''.((isset($pdata['id']) ? $pdata['id']:0)).'\',\''.((isset($but['url'])) ?$but['url']:null).'\')"  data-on-color="success" data-on-text="'.((isset($but['item']['aktif'])) ? $but['item']['aktif']:'Aktif').'" data-off-text="'.((isset($but['item']['pasif'])) ? $but['item']['pasif']:'Pasif').'" value="'.((isset($pdata[$but['dataname']])) ? $pdata[$but['dataname']]:0).'" '.((isset($pdata[$but['dataname']]) and $pdata[$but['dataname']]==1) ? 'checked':'null').'></td>';
                                break;
                            case 'checkbox':
                                echo  '<td>check</td>';
                                break;
                            case 'button':
                                echo  '<td><a href="'.((isset($but['url']) ? $but['url'] :'')).'&folder='.((isset($but['folder']) ? base64_encode($but['folder']) :'')).'&modul='.((isset($but['modul']) ? $but['modul'] :'')).'&gelenid='.((isset($pdata['id']))? $pdata['id']:null).'" class="dosya fancybox.iframe '.((isset($but['class']) ? $but['class'] :'')).'" >'.((isset($but['title']) ? $but['title'] :'')).'</a> </td>';
                                ;
                                break;
                            case 'button2':
                                echo   '<td><a href="'.((isset($but['url']) ? $but['url'] :'')).$pdata['id'].'" class="'.((isset($but['class']) ? $but['class'] :'')).'" >'.((isset($but['title']) ? $but['title'] :'')).'</a> </td>';


                                break;
                        endswitch;
                endforeach;



            endif;

           echo'   <td>';




            foreach($param['tools'] as $tool):
               echo' <a href="'.((isset($tool['url'])) ? $tool['url'].$pdata['id']: 'javascript:;').'" class="btn btn-sm btn-outline '.((isset($tool['color'])) ? $tool['color']: '').'">
                   <i class="'.((isset($tool['icon'])) ? $tool['icon']: '').'"></i> '.((isset($tool['title'])) ? $tool['title']: '').'</a>';

            endforeach;



           echo'</td> </tr>';
        endforeach;
    endif;

endif;
?>
                                   </tbody>  </table>    </div>
                            </div>
                              <div id="showmsg"></div>
                              </div>
        <!-- /.box-body -->

        <!-- /.box-footer-->
      </div>
