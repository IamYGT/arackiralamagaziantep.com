
<!DOCTYPE html>
<html lang="tr">
<head>
     <!-- Bootstrap Core CSS -->
    <link href="<?=$this->BaseAdmin()?>/theme/dosya/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=$this->BaseAdmin()?>/theme/dosya/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="<?=$this->BaseAdmin()?>/theme/dosya/dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.2.0 -->
    <script src="<?=$this->BaseAdmin()?>/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <!-- Bootstrap 3.3.6 -->

    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <link rel="stylesheet" type="text/css" href="<?=$this->BaseAdmin()?>/assets/jquery.fancybox.css" media="screen" />
    <script src="<?=$this->BaseAdmin()?>/assets/jquery.fancybox.js"></script>


    <script type="text/javascript" src="<?=$this->BaseAdmin()?>/theme/dosya/pl_upload/plupload.full.min.js"></script>
 <style>

     #sirala { list-style-type: none; margin: 0; padding: 0; width: 100%; }
     #sirala li { margin: 0 3px 3px 3px;  font-size: 1.4em; height: 68px; }


 </style>

</head>

<body style="height: 400px">



<div class="container-fluid-full" style="padding:0px">
    <div class="row-fluid">



        <div class="col-md-9">
            <div class="panel panel-primary" >
                <div class="panel-heading">
                    <?=((isset($control['baslik'])) ? $control['baslik']:null)?> | Liste
                </div>
                <div class="box-icon">

                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
                </div>
            </div>






            <div class="panel-body">

                <div id="hycucdemosbody">
                    <div id="wrapper">
                        <ul class="list-group" id="sirala" data-id="dosya">

                            <?php

                          if(is_array($control['data']))
                           foreach($control['data'] as $r2)
                            {


                                $sid=$r2["id"];
                                $ad=$this->kirlet($r2["detay"]);
                                $dosya=$r2["dosya"];
                                $resimalv="";
                                //$resimalv = "../images/resimyok.jpg";
                                if($dosya!="" and file_exists(base64_decode($control['folder']).$dosya))
                                {
                                    $resimalv = $this->resimal2(0,40,$dosya,base64_decode($control['folder'])); //w,h,resim
                                }


                                ?>
                                <li class="list-group-item"  data-id="<?=$sid?>">
                                    <table class="table table-striped table-bordered" style="margin-bottom:-1px">

                                        <tbody>
                                        <tr>

                                            <td class="center">

                                                <img src="<?=$resimalv;?>">&nbsp;   <?=$ad?>
                                            </td>
                                            <td width="10%" colspan="2" style="text-align:right">

                                                 <a class="btn btn-warning" href="#" title="Taşı" data-rel="tooltip"><i class="fa fa-arrows"></i></a>


                                                <a class="btn btn-danger" href="<?=$this->BaseAdminURL('Dosya/sil')?>&gelenid=<?=((isset($control['gelenid'])) ? $control['gelenid']:null)?>&folder=<?=((isset($control['folder'])) ? $control['folder']:null)?>&modul=<?=((isset($control['modul'])) ? $control['modul']:null)?>&id=<?=$sid?>" title="Kayıtı Sil" data-confirm="Kayıt Silinecektir Eminmisiniz?" data-rel="tooltip">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </li>

                            <? } ?>

                        </ul>
                        <div class="spacer"></div>
                        <div id="showmsg"></div>
                    </div>
                </div>


            </div>







        </div><!--/span-->

        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading"> Resim Ekle</div>
                <div class="box-icon">

                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
                </div>
            </div>
            <div class="box-content">


                <div class="control-group">


                    <div id="dosyayukle">

                        <a id="pickfiles" class="btn btn-small btn-danger" href="javascript:;"><i class="halflings-icon plus white"></i> Resim Seç</a>
                        <a id="uploadfiles" href="javascript:;" class="hidden">[ Yükle ]</a>

                        <div id="yukleme"></div>

                    </div>

                    <div id="filelist"></div>
                    <div id="console" class="alert-error"></div>



                </div>

            </div>
        </div>

        <!--/span-->




        <div class="clearfix"></div>


    </div></div>


<script type="text/javascript">
    
    $(window).ready(function (e) {

        $("#sirala").sortable({
            items:'li',
            cursorAt: { left: 0, top: 0 },
            cursor: "move",

            update : function (ev,ui) {
                //  var ilkID = (ui.item[0].nextElementSibling) ? $(ui.item[0].nextElementSibling).data('id'):null;
                //  var sonID = (ui.item[0].previousElementSibling) ? $(ui.item[0].previousElementSibling).data('id'):null;

                var sayfa = $('#sirala').data('id');
                var sirala = [];

                $('#sirala  li').each(function(index, element) {
                    sirala[index] = $(this).data('id');
                });


                $("#showmsg").load('<?=$control->BaseAdminURL('Sirala/')?>'+sayfa+'&sirala='+sirala);


            }

        });
        
        
    });
    
    

    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'pickfiles', // you can pass in id...
        container: document.getElementById('container'), // ... or DOM Element itself
        chunk_size : '1mb',  // partlı olarak yukler
        multi_selection : true,
        multipart: true,
        urlstream_upload: true,
        url : '<?=$this->BaseAdminURL('Dosya/yukle')?>&son_id=<?=((isset($control['gelenid'])) ? $control['gelenid']:null)?>&folder=<?=((isset($control['folder'])) ? $control['folder']:null)?>&modul=<?=((isset($control['modul'])) ? $control['modul']:null)?>&baslik=<?=((isset($control['gelen_baslik'])) ? $control['gelen_baslik']:null)?>',
        flash_swf_url : 'js/pl_upload/Moxie.swf',
        silverlight_xap_url : 'js/pl_upload/Moxie.xap',
        filters : {
            max_file_size : '15mb',
            mime_types: [
                {title : "Resimler", extensions : "jpg,jpeg,gif,png"},
                {title : "Dosyalar", extensions : "zip,rar,doc,docx,pdf,xls,xlsx,txt,tiff,tif"}
            ]
        },

        init: {
            PostInit: function() {
                document.getElementById('filelist').innerHTML = '';

                document.getElementById('uploadfiles').onclick = function() {
                    uploader.start();
                    return false;
                };
            },

            // Automaticly upload files when files selected
            QueueChanged: function(up, file) {
                if ( up.files.length > 0 && uploader.state != 2) {
                    uploader.start();

                }
            },


            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                });
            },
            /*UploadProgress: function(up, file) {
             document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";

             },*/

            UploadProgress: function(up, file) {
                $("#"+file.id+" b").html('<div class="progress progress-striped progress-success active"><div class="bar" style="width:' + file.percent + '%;"></div></div>');

                if(file.percent==100) $("#"+file.id).hide();

                //document.getElementById('yukleme').innerHTML='Dosyalar Yüklendi. <img height="60" src="../upload/resimler/'+ file.name +'">';

                //alert("A");
            },

            Error: function(up, err) {
                document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            }
            /*FileUploaded: function(up, file, response){
             },*/

        }
    });

    uploader.bind('FileUploaded', function(up, file, response){
        var res = $.parseJSON(response.response);
        setTimeout(function(){},300);
        //window.location.reload();
        document.getElementById('yukleme').innerHTML='Dosyalar Yüklendi.';

    });
    uploader.bind('UploadComplete', function(up, files){

        //console.log(up);
        //console.log(files);

        window.location.reload();

    });


    uploader.init();
</script>


</body>
</html>