<label class="control-label <?php echo ((isset($class)) ? $class :'')?>"<?php
       echo ((isset($style)) ? 'style="'.$style.'"' :'');
       echo ((isset($for)) ? 'for="'.$for.'"' :'')?>>
    <?php
       echo ((isset($label)) ? $label :'')?>
<?php  echo ((isset($required) and $required) ? '<span class="required">*</span>' :'')?>
</label><?=PHP_EOL?><?=PHP_EOL?>