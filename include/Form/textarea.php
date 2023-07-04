<div class="form-group form-md-line-input">
<?php if(isset($label)) Form::Label([
        'label'=>((isset($label)) ? $label:''),
        'for'=>((isset($name)) ? $name:''),
        'required'=>((isset($required) and $required) ? $required:false),
        'class'=>((isset($labelClass)) ? $labelClass:null),
        'style' => ((isset($labelStyle)) ? ' style="'.$labelStyle.'"' :null)
    ])?>
<? if(isset($div) and $div) echo '<div class="'.((isset($class))   ? $class:((isset($divClass)) ? $divClass:null)).'" >'?>
<textarea type="<?=((isset($type)) ? ''.$type :'text').'"'
        .((isset($id)) ? 'id="'.$id.'"' :null)
        .((isset($class)) ? 'class="form-control '.$class.'"' :null)
        .((isset($style)) ? ' style="'.$style.'"' :null)
        .((isset($placeholder)) ? 'placeholder="'.$placeholder.'"':null)
        .((isset($required) and  $required) ? 'required ':'')
        .((isset($name)) ? ' name="'.$name.'"' :'')?>><?php echo ((isset($value)) ? $value:null)?></textarea><?=PHP_EOL?><?=PHP_EOL?>
<?php if(isset($div) and $div) echo '<div class="form-control-focus"> </div>'; ?>
<?php Form::Helper(['helper'=>((isset($helper) ? $helper:null))]);?>
<?php if(isset($div) and $div) echo '</div></div>';?>