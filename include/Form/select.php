<?php if(isset($div) and $div) echo '<div class="form-group form-md-line-input">'?>
<?php if(isset($label)) Form::Label([
    'label'=>((isset($label)) ? $label:''),
    'style'=>((isset($labelStyle)) ? $labelStyle:null),
    'for'=>((isset($name)) ? $name:''),
    'required'=>((isset($required) and $required) ? $required:false),
    'class'=>((isset($lclass)) ? $lclass:((isset($labelClass)) ? $labelClass:null)),
    'div' => ((isset($div) and $div) ? $div:null)
])?>
<? if(isset($div) and $div) echo 'class="'.((isset($class))   ? $class:((isset($divClass)) ? $divClass:null)).'" >'?>
<select type="<?=((isset($type)) ? ''.$type :'text').'"'
.((isset($id)) ? 'id="'.$id.'"' :null)
.((isset($class)) ? 'class="form-control '.$class.'"' :null)
.((isset($name)) ? 'name="'.$name.'"' :'')
.((isset($style)) ? ' style="'.$style.'"' :null)
.((isset($required) and  $required) ? 'required':'')?>>
<option value=""><?=((isset($value)) ? $value :null)?></option>
<?
if(is_array($data))
    foreach ($data as $name=>$value):
        echo '<option value="'.$name.'">'.$value.'</option>'.PHP_EOL;
        endforeach;
?>
</select><?=PHP_EOL?><?=PHP_EOL?>
<?php if(isset($div) and $div) echo '<div class="form-control-focus"> </div>'; ?>
<?php Form::Helper(['helper'=>((isset($helper) ? $helper:null))]);?>
<?php if(isset($div) and $div) echo '</div></div>';?>