<form <?php
     echo((isset($action) ? 'action="'.$action.'"' :''))
        .((isset($id) ? 'id="'.$id.'"' :''))
        .((isset($name) ? 'name="'.$name.'"' :''))
        .((isset($class) ? ' class="'.$class.'"' :''))
        .'method="'.((isset($method) ? $method :'post')).'"'
        .((isset($fileUpload) ? 'enctype="multipart/form-data"' :''))?>>
<?php  if(isset($token) and $token) echo '<input type="hidden" name="token" value="'.$token_value.'" />';?><?=PHP_EOL?><?=PHP_EOL?>