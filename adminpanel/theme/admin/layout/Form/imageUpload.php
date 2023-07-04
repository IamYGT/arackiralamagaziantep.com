<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 27.10.2016
 * Time: 19:37
 */

$image = ((isset($param['src']) and $param['src']) ? json_decode($param['src']):array());

return '                <div class="form-group last">
                                                <label class="control-label col-md-3" style="padding-left: 0px !important;">'.((isset($lang) ? ' <img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$lang.'.png" width="25px" style="margin-right:10px;"> ':null)).((isset($param['title']) ? $param['title'] :'')).'</label>
                                                <div class="col-md-9">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" >
                                                            <img src="'.((isset($image[0]) and $image[0] and file_exists('../upload/'.$image[0])) ? $param['url'].'/upload/'.$image[0] :'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=Resim+Yok').'" alt="" /> </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                        <div>
                                                            <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Resim Seç </span>
                                                                <span class="fileinput-exists"> Değiştir </span>
                                                                <input type="file" name="'.((isset($param['name']) ? $param['name'] :'')).'">
																 </span>
                                                            <a href="#" onClick="resimkaldir(this);" class="btn red  kaldir  '.((isset($image[0]) and $image[0] and file_exists('../upload/'.$image[0])) ? '':'fileinput-exists').'" data-dismiss="fileinput"> Kaldır </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         										  <input type="hidden" name="old'.((isset($param['name'])) ? $param['name']:'').'" value="'.((isset($param['src'])) ? base64_encode($param['src']):'').'" class="eskiresim">

                                            <br clear="all"> <br clear="all">';
?>