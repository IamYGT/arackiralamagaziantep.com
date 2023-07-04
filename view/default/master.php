
<!DOCTYPE HTML>
<html lang="<?=$lang?>">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title><?=$this->sayfaBaslik?></title>
    <base url="<?php echo $this->BaseURL()?>">
    <meta name="description" content="<?=$this->ayarlar('description_'.$lang)?>" />
    <meta name="keywords" content="<?=$this->ayarlar('keywords_'.$lang)?>" />
    <meta name="author" content="Digital Küre" />

    <meta property="og:description" content="<?=$this->ayarlar('title_'.$lang)?>">
    <meta property="og:image" content="index.html">
    <meta property="og:site_name" content="<?=$this->ayarlar('title_'.$lang)?>">
    <meta property="og:title" content="<?=$this->ayarlar('description_'.$lang)?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="index.html">

    <link rel="shortcut icon" href="<?=$this->themeURL?>images/favicon.png">
    <link rel="apple-touch-icon" href="<?=$this->themeURL?>images/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=$this->themeURL?>images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes=114x114 href="<?=$this->themeURL?>images/apple-touch-icon-114x114.png">
    <link rel="stylesheet" href="<?=$this->themeURL?>css/animate.css" />
    <link href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"> </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"> </script>
    <script src="<?=$this->themeURL?>instashow/elfsight-instagram-feed.js"> </script>
    <link rel=stylesheet href="<?=$this->themeURL?>css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


    <script>
        var ThemeURL = '<?=$this->themeURL?>';
        var BaseURL = '<?=$this->BaseURL()?>';
    </script>
</head>
<body class="<?=$lang?>">

    <?=$content?>



  
    <script type="text/javascript" src="<?=$this->themeURL?>js/jquery.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"> </script>
    <script type="text/javascript" src="<?=$this->themeURL?>js/wow.min.js"> </script>
    <script type="text/javascript" src="<?=$this->themeURL?>js/app.js"> </script>

<!-- <script type="text/javascript">
    $(".open-dialog").fancybox({width:1200});
</script> -->
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>

</body>
</html>