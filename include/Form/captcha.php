<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="g-recaptcha"  <?php    echo ((isset($id)) ? ' id="'.$id.'"' :null)
    .((isset($class)) ? ' class="'.$class.'"' :null)
    .((isset($style)) ? ' style="'.$style.'"' :null)
?>data-sitekey="<?=($key) ? $key:null?>"></div><?=PHP_EOL?><?=PHP_EOL?>