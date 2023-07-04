<? if(isset($type) and $type=="hidden"):?>

    <input type="<?=((isset($type) ? $type :'text'))?>"
           value="<?=((isset($value) ? $value :''))?>"
           id="<?=((isset($id) ? $id :'')).((isset($lang)) ? '_'.$lang:'')?>"
           class="form-control <?=((isset($class) ? $class :''))?>"
           placeholder=""
           name="<?=((isset($name) ? $name :'')).((isset($lang)) ? '_'.$lang:'')?>">
<? elseif(isset($type) and $type=="date"): ?>
    <!-- Date -->
    <div class="form-group">
        <label class="col-md-3 control-label" for="form_control_1" style="padding-left: 0px !important;">
        <?=(isset($title) ? ((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).$title:null)?>
 <?=(isset($required)) ? '<span class="required">*</span>':null?>
        </label>

        <div class="input-group date <?=((isset($title)) ? 'col-md-9':'col-md-12')?>" style="padding-left: 15px; padding-right:  15px;">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text"
                   value="<?=((isset($value)) ? $value :'')?>"
                   id="datepicker"
                   class="form-control pull-right <?=((isset($class) ? $class :''))?>"
                   placeholder=""
                   name="<?=((isset($name) ? $name :'')).((isset($lang) and $lang) ? '_'.$lang:'')?>"
                <?=((isset($button)) ? 'style="width:90%; float:left;"':null)?>>
        </div>

        <!-- /.input group -->
    </div>
    <!-- /.form group -->

 <? elseif(isset($type) and $type=="link"): ?>
    <!-- Date -->
    <div class="form-group">
        <label class="col-md-3 control-label" for="form_control_1" style="padding-left: 0px !important;">
            <?=(isset($title) ? ((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).$title:null)?>
            <?=(isset($required)) ? '<span class="required">*</span>':null?>
        </label>

        <div class="input-group date <?=((isset($title)) ? 'col-md-9':'col-md-12')?>" style="padding-left: 15px; padding-right:  15px;">
            <div class="input-group-addon">
                <i class="fa fa-link"></i>
            </div>
            <input type="url"
                   value="<?=((isset($value)) ? $value :'')?>"
                   class="form-control pull-right <?=((isset($class) ? $class :''))?>"
                   placeholder=""
                   name="<?=((isset($name) ? $name :'')).((isset($lang) and $lang) ? '_'.$lang:'')?>"
                <?=((isset($button)) ? 'style="width:90%; float:left;"':null)?>>
        </div>

        <!-- /.input group -->
    </div>
    <!-- /.form group -->
<? else:?>

    <div class="form-group form-md-line-input">
        <label class="col-md-3 control-label" for="form_control_1" style="padding-left: 0px !important;">
            <?=(isset($title) ? ((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).$title:null)?>
            <?=(isset($required)) ? '<span class="required">*</span>':null?>
        </label>
        <div class="<?=((isset($title)) ? 'col-md-9':'col-md-12')?>"

            <?=((isset($title)) ? '':'style="padding:0px !important; padding-right:5px !important"')?> >
            <?=((isset($image) and $image) ?  '<img src="'.((isset($value)) ? $value :'').'" class="imgresim">' :'')?>
            <input type="<?=((isset($type) ? $type :'text'))?>"
                   value="<?=((isset($value)) ? $value :'')?>"
                   id="<?=((isset($id) ? $id :'')).((isset($lang)) ? '_'.$lang:'')?>"
                   class="form-control <?=isset($lang) ? $lang : ''?> <?=((isset($class) ? $class :''))?>"
                   placeholder=""
                   name="<?=((isset($name) ? $name :'')).((isset($lang) and $lang) ? '_'.$lang:'')?>"
            <?=((isset($button)) ? 'style="width:90%; float:left;"':null)?>    >

            <?=((isset($button) ? '<a style="float:left; width:10%; height:34px; cursor:pointer; border-top-left-radius:0px; border-bottom-left-radius:0px;" data-lang="'.((isset($lang) and $lang) ? $lang:'').'"  class="btn btn-success '.((isset($button['id'])) ? $button['id']:null).'">'.((isset($button['text'])) ? $button['text']:null).'</a>' :''))?>
            <div class="form-control-focus"> </div>
            <span class="help-block" style="clear: both; width: 100%;"><?=((isset($help) ? $help :''))?></span>
        </div>

    </div>
    <br clear="all">
<? endif; ?>



