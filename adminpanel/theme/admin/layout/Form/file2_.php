<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 27.10.2016
 * Time: 19:35
 */
$value = json_decode($a["src"],JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$values = '';
foreach($value as $val) if($val['file']) $values .= $val['file'].',';
//  $value = explode(',',$a["value"]);
$file_ext = array('zip'=>'fa-file-archive-o','rar'=>'fa-file-archive-o','xls'=>'fa-file-excell-o','xlsx'=>'fa-file-excel-o',
    'doc'=>'fa-file-word-o','docx'=>'fa-file-word-o','jpg'=>'fa-file-image-o','png'=>'fa-file-image-o','jpeg'=>'fa-file-image-o','pdf'=>'fa-file-pdf-o','odt'=>'fa-file-word-o');
$element  =  '
    	<div class="form-group '.$a["name"].'"><label class="col-md-2">'.$a["title"].((isset($param['lang'])) ? ' ['.strtoupper($param['lang']).' ]': '').'</label>
			<div class="col-md-5" style="padding-left:10px;">
            <br clear="all">
            <span class="btn btn-success fileinput-button ">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Dosyaları Seç...</span>
            <input type="file"  name="files" id="fileupload2"'.(($a["require"]) ? 'required':null).' multiple>
            <input type="hidden" name="'.$a["name"].'" class="filelist" value="'.$values.'">


    </span>
         <br clear="all">
         <p>&nbsp;</p>
      <div id="files" class="files2 col-md-8" style="min-height:150px; margin-bottom:10px;">';
foreach($value as $val):

    if(isset($file_ext[$val['type']])) $element .= '<p><i class="fa '.$file_ext[$val['type']].'">&nbsp;'.$val['file'].'</i></p>';

endforeach;

$element .='</div>
     <p>&nbsp;</p>
     <br clear="all">
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>



    <br>
	 		</div>
											</div>
    ';


return $element;
?>