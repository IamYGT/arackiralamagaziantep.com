<div class="form-group form-md-line-input">
          <label class="col-md-3 control-label" for="form_control_1" style="padding-left: 0px !important;">
              <?=((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).((isset($title) ? $title :''))?>
           <span class="required">*</span>
                </label>
           <div class="col-md-9">
          <a href="<?=((isset($url) ? $url :'')).'&name='.((isset($name) ? $name :'')).((isset($lang)) ? '_'.$lang:'')?>"
           class="fancy fancybox.iframe" style="font-size:14px;">Haritayı Görüntüle</a><br>
            <label for="<?=((isset($name) ? $name :''))?>"
             class="yaz1" style="color:#745807;">Şuanki Kayıtlı Konum :
                <?=((isset($value) ? $value :''))?> </label>
           <input type="hidden" value="<?=((isset($value) ? $value :''))?>"
                  id="<?=((isset($id) ? $id :''))?>"
                  class="form-control <?=((isset($class) ? $class :''))?>"
                  placeholder=""
                  name="<?=((isset($name) ? $name :''))?>">
                  <div class="form-control-focus"> </div>
                  <span class="help-block"><?=((isset($help) ? $help :''))?>
            </div>
         </div>
<br clear="all">