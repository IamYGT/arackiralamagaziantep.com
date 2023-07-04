<div class="form-group form-md-line-input">
               <label class="col-md-3 control-label" for="form_control_1" style="padding-left: 0px !important;">
                   <?=((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).((isset($title) ? $title :''))?>
                 <span class="help-block"><?=((isset($help) ? $help :''))?></span>
                 </label>
                 <div class="col-md-9">
                  <select class="form-control" name="<?=((isset($name) ? $name :'')).((isset($lang)) ? '_'.$lang:'')?>">
                        <option value="0" >Lütfen Seçiniz</option>
                                 <?=(isset($data) ? $data:null)?>
                  </select>
                  <div class="form-control-focus"> </div>
                  </div>
                  </div>
<div clear="all" style="margin-bottom: 10px; display: inherit; clear: both;">

</div>