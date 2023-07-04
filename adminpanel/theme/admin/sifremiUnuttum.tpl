
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Yönetim Paneli</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{$settings->config('cdnURL')}admin/assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{$control->ThemeFile()}/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{$control->ThemeFile()}/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{$control->ThemeFile()}/css/custom.css">
    <link rel="stylesheet" href="{$settings->config('cdnURL')}admin/assets/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Yönetim</b>Paneli</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"></p>

        <form action="{$settings->config('cdnURL')}admin/{$modulName}/mailgonder.html" method="post" id="loginCheck">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Kullanıcı Adı" name="user">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="mail" class="form-control" placeholder="E-posta" name="eposta">
                <span class="glyphicon glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="row">

                <div class="col-xs-6">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">E-posta Gönder</button>
                </div>
                <!-- /.col -->
            </div>

        </form>




    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="{$settings->config('cdnURL')}admin/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{$settings->config('cdnURL')}admin/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{$settings->config('cdnURL')}admin/assets/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
       $(window).ready(function(e){


          $("#loginCheck").submit(function(e){



              $.ajax({
                  url :  $(this).attr('action'),
                  type: $(this).attr('method'),
                  data: $(this).serialize(),
                  success:function(g)
                  {

                      if(g==1)  $('.login-box-msg').css('color','#c20000').html('Yeni şifrenizi almanız için gereken link E-posta adresinize gönderilmiştir.');
                      else {
                        $('.login-box-msg').css('color','#c20000').html('E-posta veya Kullanıcı Adı Hatalı').fadeOut(5000);


                      }

                   }



              })


              return false;
          });


       });

    });
</script>