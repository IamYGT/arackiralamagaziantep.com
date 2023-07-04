<?php
$image_file = ((isset($src)) ? ((self::isJSON($src)) ? json_decode($src,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES): array('crop'=>false,'image'=>$src)):array());

$file_allow = $this->settings->file('allow_image_type');
$filea  = ' ';
if(is_array($file_allow))
    foreach ($file_allow as $file)  $filea .= str_replace('image/','',$file).', ';


?>
<br clear="all">
		<div class="form-group fileupload"  id="<?=(isset($name) ? $name:'').((isset($lang)) ? '_'.$lang:'')?>">

            <label class="col-md-3 control-label" for="form_control_1"  >
                <?=((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).(isset($title) ? $title:null)?>
            </label>
   <div class="col-md-9" style="max-width:550px;">
         <?=((isset($image_file['image']) and $image_file['image']) ?
            '<img src="'.((isset($url)) ? $url:'')."/".((isset($image_file['image']) and $image_file['image']) ?
            (($image_file['crop']=="true") ? 'crop_':'').$image_file['image']:'').'" class="img-prev" style="max-width:300px; margin-bottom:10px;">':
            '<img src="" class="img-prev" style="display:none; max-width:200px; margin-bottom:10px;">' )?>
            <br clear="all">
	   <div id="<?=(isset($image_file['name']) ? $image_file['name']:'')?>" class="files col-md-6"><?=(isset($image_file['image']) ? $image_file['image']:'')?></div>
    <span class="btn btn-success fileinput-button ">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Yükle..</span>
            <input type="file"
                   name="files"
                   id="<?=(isset($name) ? $name:'').((isset($lang)) ? '_'.$lang:'')?>"
                   <?=((isset($require)) ? 'required':null)?> >

            <input type="hidden"
                   id="<?=(isset($name) ? $name:null).((isset($lang)) ? '_'.$lang:'')?>"
                   class="image_val"
                   name="<?=(isset($name) ? $name:null).((isset($lang)) ? '_'.$lang:'')?>"
                   value="<?=(isset($image_file['image']) ? $image_file['image']:'')?>">

            <input type="hidden"
                   id="<?=(isset($name) ? $name:null).((isset($lang)) ? '_'.$lang:'')?>"
                   class="crop"
                   name="crop_<?=(isset($name) ? $name:null).((isset($lang)) ? '_'.$lang:'')?>"
                   value="<?=((isset($image_file['crop']) and $image_file['crop']=="true") ? 'true':'false')?>">

            <input type="hidden"
                   id="fotoResim_folder"
                   class="image_folder"
                   name="<?=(isset($name) ? $name:null).((isset($lang)) ? '_'.$lang:'')?>_folder"
                   value="<?=((isset($folder)) ? $folder:null)?>">
      </span>

       <span class="btn btn-success crop_file" data-id="<?=((isset($resimBoyut))? $resimBoyut:0)?>">
        <i class="glyphicon glyphicon-resize-small "></i>
        <span>Resmi Kırp... </span>
       </span>
       <br>  <br>
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
      <br>

       <div class="form-control-focus"> </div>
       <span class="help-block"><?=((isset($help) ? $help :'Önerilen Resim Boyutu :'.$resimBoyut.' / İzin Verilen Resim Formatları:'.strtoupper($filea)))?></span>

	 		</div>
											</div><br clear="all">
