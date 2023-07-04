<?php
$select = (isset($seleted)) ? json_decode($seleted,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES):0;
?>
 <br clear="all">
<div class="form-group form-md-line-input">
 <label class="col-md-3 control-label" for="form_control_1" style="padding-left: 0px !important;">
     <?=((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).(isset($title) ? $title:null)?></label>
          	<div class="col-md-6">
           <select class="form-control select2"
                   multiple="multiple"
                   data-placeholder="Seçiniz..."
                   name="<?=((isset($name))? $name:null).((isset($lang)) ? '_'.$lang:'')?>[]"
                   id="<?=((isset($name))? $name:null).((isset($lang)) ? '_'.$lang:'')?>"
                   <?=((isset($require)) ? 'required' : null)?>  >
                   <?=(isset($data) ? $data:null)?>
           </select>
                <span class="help-block" style="clear: both; width: 100%;"><?=((isset($help) ? $help :''))?></span>
            </div>


			</div>


        <br clear="all">
 <br clear="all">
