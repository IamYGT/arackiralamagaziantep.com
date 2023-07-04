 <div class="form-group form-md-line-input form-md-floating-label ">
               <label class="control-label" style="color: #888; padding-left: 0px !important;">
                   <?=((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).((isset($title) ? $title :''))?>
                   </label>
               <br clear="all">
               <textarea
                   name="<?=((isset($name) ? $name :'')).((isset($lang)) ? '_'.$lang:'')?>"
                   style="height:<?=((isset($height) ? $height :'140')).'px'?>"
                   id="<?=((isset($id) ? $id:'')).((isset($lang)) ? '_'.$lang:'')?>"
                   class="<?=((isset($class) ? $class :''))?> editor">
                   <?=((isset($value) ? $value :''))?></textarea>
               </div>
