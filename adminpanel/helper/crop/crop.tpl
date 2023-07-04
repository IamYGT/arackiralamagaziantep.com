<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<title>Crop Image</title>
    <link rel="stylesheet" href="{$settings->config('cdnURL')}admin/assets/plugins/cropper/cropper.css" type="text/css" />
    <link rel="stylesheet" href="{$settings->config('cdnURL')}admin/assets/bootstrap/css/bootstrap.min.css">
    <script src="{$settings->config('cdnURL')}admin/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{$settings->config('cdnURL')}admin/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="{$settings->config('cdnURL')}admin/assets/plugins/cropper/cropper.js"></script>

</head>
 
<body>
 <form action="{$control->BaseAdminURL('Files/croped/')}" method="POST">

<div class="img-container" style="width:800px; height:600px;">
  <img src="{$control->BaseURL()}upload/{if isset($folder) and $folder}{$folder}/{/if}{if isset($image) and $image}{$image}{/if}" alt="" width="100%">

</div>
    <input type='hidden' id='classname' name='classname' value="{if isset($classname) and $classname}{$classname}{/if}"/>
    <input type='hidden' id='dataX' name='dataX' />
    <input type='hidden' id='dataY' name='dataY' />
    <input type='hidden' id='dataHeight' name='dataHeight' />
    <input type='hidden' id='dataWidth' name='dataWidth' />
    <input type='hidden' id='dataRotate' name='dataRotate' />
    <input type='hidden' id='dataScaleX' name='dataScaleX' />
    <input type='hidden' id='dataScaleY' name='dataScaleY' />
    <input type='hidden' id='folder' name='folder' value="{if isset($folder) and $folder}{$folder}{/if}" />
    <input type='hidden' id='width' name='width'  value="{if isset($width) and $width}{$width}{else}800{/if}"/>
    <input type='hidden' id='height' name='height' value="{if isset($height) and $height}{$height}{else}600{/if}" />
    <input type='hidden' id='source_image' name='source_image' value="{if isset($image) and $image}{$image}{/if}" />
    <button class='btn btn-block btn-success' type='submit'>Kırp</button>
</form>
<script type='text/javascript'>

    $(".img-container > img").cropper({
        aspectRatio: {if isset($width) and $width}{$width}{else}250{/if}/{if isset($height) and $height}{$height}{else}250{/if},
        preview: ".img-preview",
        crop: function(e) {
            $("#dataX").val(Math.round(e.x));
            $("#dataY").val(Math.round(e.y));
            $("#dataHeight").val(Math.round(e.height));
            $("#dataWidth").val(Math.round(e.width));
            $("#dataRotate").val(e.rotate);
            $("#dataScaleX").val(e.scaleX);
            $("#dataScaleY").val(e.scaleY);
        }
    });
 
</script>
</body>
</html>