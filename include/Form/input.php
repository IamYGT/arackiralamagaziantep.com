<?php if(isset($type) and $type=="hidden"): ?>
<input <?php
         echo((isset($type)) ? ' type="'.$type.'"' :null)
            .((isset($value)) ? ' value="'.$value.'"' :null)
            .((isset($id)) ? ' id="'.$id.'"' :null)
            .((isset($style)) ? ' style="'.$style.'"' :null)
            .((isset($class)) ? ' class="form-control '.$class.'"' :null)
            .((isset($placeholder)) ? ' placeholder="'.$placeholder.'"':null)
            .((isset($required) and  $required) ? ' required':'')
            .((isset($name) ? ' name="'.$name.'"' :''))?>"><?=PHP_EOL?><?=PHP_EOL?>
<?php elseif(isset($type) and $type=="submit"): ?>
<?php if(isset($div) and $div) echo '<div class="form-group form-md-line-input">'?>
<?php if(isset($div) and $div) echo '<div class="col-md-3">&nbsp;</div><div class="'.((isset($divClass)) ? $divClass:'col-md-12').'" >';?>
<input type="submit" <?php echo
     ((isset($value)) ? ' value="'.$value.'"' :null)
    .((isset($id)) ? ' id="'.$id.'"' :null)
    .((isset($style)) ? ' style="'.$style.'"' :null)
    .((isset($class)) ? ' class="form-control '.$class.'"' :null)
    .((isset($required) and  $required) ? ' required':'')
    .((isset($name)) ? ' name="'.$name.'"' :'')?>><?=PHP_EOL?><?=PHP_EOL?>
<?php if(isset($div) and $div) echo '</div></div>';?>
<?php else: ?>
<?php if(isset($div) and $div) echo '<div class="form-group form-md-line-input">'?>
<?php if(isset($label)) Form::Label([
                'label'=>((isset($label)) ? $label:''),
                'style'=>((isset($labelStyle)) ? $labelStyle:null),
                'for'=>((isset($name)) ? $name:''),
                'required'=>((isset($required) and $required) ? $required:false),
                'class'=>((isset($lclass)) ? $lclass:((isset($labelClass)) ? $labelClass:null)),
                'div' => ((isset($div) and $div) ? $div:null)
                           ])?>
<? if(isset($div) and $div) echo '<div class="'.((isset($divClass)) ? $divClass:null).'" >'?>
<input type="<?=((isset($type)) ? ''.$type :'text').'"'
            .((isset($value)) ? ' value="'.$value.'"' :null)
            .((isset($id)) ? ' id="'.$id.'"' :null)
            .((isset($style)) ? ' style="'.$style.'"' :null)
            .((isset($class)) ? ' class="form-control '.$class.'"' :null)
            .((isset($placeholder)) ? ' placeholder="'.$placeholder.'"':null)
            .((isset($name)) ? ' name="'.$name.'"' :'')
            .((isset($required) and  $required) ? ' required':'')?>><?=PHP_EOL?><?=PHP_EOL?>
<?php if(isset($div) and $div) echo '<div class="form-control-focus"> </div>'; ?>
<?php Form::Helper(['helper'=>((isset($helper) ? $helper:null))]);?>
<?php if(isset($div) and $div) echo '</div></div>';?>
<?php  endif; ?>
