
<!DOCTYPE HTML>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js"> <!--<![endif]-->
<head>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700,900&subset=latin-ext" rel="stylesheet">

    <style>
        body { font-family: 'Raleway', sans-serif; }
        /* entire container, keeps perspective */
        .flip-container {
            perspective: 1000px;
       margin-bottom:50px;
        }
        /* flip the pane when hovered */
        .flip-container:hover .flipper, .flip-container.hover .flipper {
            transform: rotateY(180deg);
        }

        .flip-container, .front, .back {
            width: 400px;
            height: 100%;

        }

        /* flip speed goes here */
        .flipper {
            transition: 0.6s;
            transform-style: preserve-3d;
            height: 100%;
            position: relative;
        }

        /* hide back of pane during swap */
        .front, .back {
            backface-visibility: hidden;

            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            align-items: flex-end;
        }

        /* front pane, placed above back */
        .front {
            z-index: 2;
            /* for firefox 31 */
            transform: rotateY(0deg);
        }

        /* back, initially hidden pane */
        .back {
            transform: rotateY(180deg);
        }

        html,body { height: 100%;}

    </style>
    <script type="text/javascript" src="<?=$this->themeURL?>js/jquery.js"></script>
    <script type="text/javascript" src="<?=$this->themeURL?>js/jquery-migrate.min.js"></script>
</head>
<body style="overflow: hidden !important;">
<div style="height: 100%; position: relative;  display: inline-block; width: 100%;display: flex;
	align-items: flex-end;
	justify-content: center; " class="onarka">

  <? if($arka):?>
      <div class="yon" style="position: absolute; padding: 20px; background-color: #000; color:#fff; right: 0px; top:0px;  min-width: 60px; font-weight: bold;" >Ön</div>
    <div class="flip-container">
    <div class="flipper">
        <div class="front">
            <img src="<?=$this->BaseURL($this->settings->config('folder').'urunler/'.$resimurl)?>" style="max-height:400px; height: 80%;">
        </div>
        <div class="back">
            <img src="<?=$this->BaseURL($this->settings->config('folder').$arka)?>" style="max-height:400px; height: 80%;">
        </div>
    </div>
</div>
<a href="javascript:void(0);" onclick="jQuery('.flip-container').toggleClass('hover')"  class="arka" style="position: absolute; right:0px; bottom:20px;  width:150px; height:40px; background-color:#00a65a;  line-height: 40px; text-decoration: none; color:#fff; font-size: 14px; display: inline-block; z-index: 9999; padding-left: 10px;">Arka Tarafını Göster </a>
    <?else:?>
      <img src="<?=$this->BaseURL($this->settings->config('folder').'urunler/'.$resimurl)?>" style="max-height:400px;  height: 80%; ">
    <?endif;?>

<script>





    jQuery(".arka").toggle(function (){
        jQuery(this).text("Ön Tarafını Göster")
            .stop();
        jQuery('.yon').text('Arka');
    }, function(){
        jQuery(this).text("Arka Tarafını Göster")
            .stop();
        jQuery('.yon').text('Ön');
    });


    jQuery('.flip-container').hover(
        function() {
            var $this = jQuery('.yon'); // caching $(this)
            $this.data('initialText', $this.text());
            $this.text("Arka");
        },
        function() {
            var $this = jQuery('.yon'); // caching $(this)
            $this.text($this.data('initialText'));
        }
    );

    jQuery(document).ready(function (e) {

   //     console.log(parent.jQuery('.fancybox-iframe').outerHeight());
      //  jQuery('.onarka,.front,.back').height(parent.jQuery('.fancybox-iframe').outerHeight()+'px');

    });

</script>

</div>
</body>
</html>