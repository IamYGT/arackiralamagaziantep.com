
    <div class="form-group form-md-line-input">
        <label class="col-md-3 control-label" for="form_control_1" style="padding-left: 0px !important;">
            <?=(isset($title) ? ((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).$title:null)?>
            <?=(isset($required)) ? '<span class="required">*</span>':null?>
        </label>
        <div class="<?=((isset($title)) ? 'col-md-9':'col-md-12')?>"

            <?=((isset($title)) ? '':'style="padding:0px !important; padding-right:5px !important"')?> >

            <input type="checkbox"
                   value="1"
                   id="<?=((isset($id) ? $id :'')).((isset($lang)) ? '_'.$lang:'')?>"
                   class="<?=((isset($class) ? $class :''))?>"
                   <?=((isset($value) and $value == 1) ? 'checked':'')?>
                   placeholder=""
                   name="<?=((isset($name) ? $name :'')).((isset($lang) and $lang) ? '_'.$lang:'')?>"
                <?=((isset($button)) ? 'style="width:90%; float:left;"':null)?>    >

            <?=((isset($button) ? '<a style="float:left; width:10%; height:34px; cursor:pointer; border-top-left-radius:0px; border-bottom-left-radius:0px;" data-lang="'.((isset($lang) and $lang) ? $lang:'').'"  class="btn btn-success '.((isset($button['id'])) ? $button['id']:null).'">'.((isset($button['text'])) ? $button['text']:null).'</a>' :''))?>
            <div class="form-control-focus"> </div>
            <span class="help-block" style="clear: both; width: 100%;"><?=((isset($help) ? $help :''))?></span>
        </div>

    </div>
    <br clear="all">




