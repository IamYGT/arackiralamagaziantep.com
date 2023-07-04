<div class="form-group form-md-line-input">
    <label class="col-md-3 control-label" for="form_control_1" style="padding-left: 0px !important;">
        <?=((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).((isset($title) ? $title :''))?>
        <span class="required">*</span>
     </label>
    <div class="col-md-9">
        <textarea type="text"  id="<?=((isset($id) ? $id :'')).((isset($lang)) ? '_'.$lang:'')?>"
           style="height:<?=((isset($height) ? $height :'120')).'px'?>"
           class="form-control <?=((isset($class) ? $class :''))?>"
           placeholder="" name="<?=((isset($name) ? $name :'')).((isset($lang)) ? '_'.$lang:'')?>"><?=((isset($value) ? $value :''))?></textarea>
          <div class="form-control-focus"> </div>
        <span class="help-block"><?=((isset($help) ? $help :''))?></span>
    </div>
</div>
<br clear="all">