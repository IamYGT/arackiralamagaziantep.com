
$(document).ready(function() {


    $('#kelime').on('keydown', function(e) {
        if (e.which == 13) {
            var kelime = $(this).val();
            var sayfaUrl = $(this).data("url");
            if (kelime != 0 && kelime != ""){
                location.href=sayfaUrl+"&kelime="+kelime;
            }
        }
    });

    $("#araButon").on("click", function(e){
            e.preventDefault();
            var kelime = $("#kelime").val();
            var sayfaUrl = $("#kelime").data("url");
            if (kelime != 0 && kelime != ""){
                location.href=sayfaUrl+"&kelime="+kelime;
            }
    });

    $("#sifreGuncelle").on("click", function(e){
        e.preventDefault();
        var sifre = $("#teknik_sifre").val();
        var sayfaUrl = $(this).attr("href");
        sayfaUrl+="&sifre="+sifre;


        if (sifre != 0 && sifre != ""){
            $.ajax({
                url: sayfaUrl,
                type: 'GET',
                success:function(g)
                {
                    alert("Şifre Güncellendi");

                }
            });
        }
    });



    $(".sendEmail").on("click", function(e){
        e.preventDefault();

        var sayfaUrl = $(this).attr("href");


        if (confirm("İlgili hesaba onay emaili gönderilecektir. Devam etmek istiyor musunuz ?")){

          $.ajax({
              url: sayfaUrl,
              type: 'GET',
              success:function(g)
              {
                  if (g == 1){
                    alert("Email Başarıyla Gönderildi.");
                  }
                  else {
                    alert("Hata Oluştu");
                  }
              }
          });

        }

        else {
          return false;
        }

    });


    $('.buttonTemizle').click(function (e) {

        $.ajax({

            url: '../ajax/OnbellekTemizle.html',
            type: 'POST',
            success:function(g)
            {
                if(g==1) alert('Önbellek Temizlendi');
            }
        });

        return false;
    });


    // enable fileuploader plugin
    $('#fileuploader input[name="files"]').fileuploader({
        changeInput: '<div class="fileuploader-input">' +
        '<div class="fileuploader-input-inner">' +
        '<img src="'+BaseAdminURL+'/theme/admin/img/fileuploader-dragdrop-icon.png">' +
        '<div class="fileuploader-input-caption"><span>Sürükleyip Bırak</span></div>' +
        '<p>veya</p>' +
        '<div class="fileuploader-input-button"><span>Dosya Seç</span></div>' +
        '</div>' +
        '</div>',
        theme: 'dragdrop',
        fileMaxSize:2,
        extensions : ['jpg','jpeg','png','gif', 'pdf'],
        upload: {
            url: BaseAdminURL +'/?cmd=Dosya/YukleWidget',
            data: {'id':$('#fileuploader input[name=id]').val(),'name':$("input[name="+$('#fileuploader input[name=baslik]').val()+"]").val(),'modul':$('#fileuploader input[name=modul]').val(),'folder':$('#fileuploader input[name=folder]').val()},
            type: 'POST',
            enctype: 'multipart/form-data',
            start: true,
            synchron: true,
            beforeSend: null,
            onSuccess: function(result, item) {
                var data = JSON.parse(result);

                // if success
                if (data.isSuccess && data.files[0]) {
                    item.name = data.files[0].name;

                    item.html.find('.column-title div').animate({opacity: 0}, 400);
                    item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>');
                    setTimeout(function() {
                        item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({opacity: 1}, 400);
                        item.html.find('.progress-bar2').fadeOut(400);
                    }, 400);
                }

                // if warnings
                if (data.hasWarnings) {
                    for (var warning in data.warnings) {
                        alert(data.warnings);
                    }

                    item.html.removeClass('upload-successful').addClass('upload-failed');
                    // go out from success function by calling onError function
                    // in this case we have a animation there
                    // you can also response in PHP with 404
                    return this.onError ? this.onError(item) : null;
                }

                item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Kaldır"><i></i></a>');
                setTimeout(function() {
                    item.html.find('.progress-bar2').fadeOut(400);
                }, 400);
            },
            onError: function(item) {
                var progressBar = item.html.find('.progress-bar2');

                if(progressBar.length > 0) {
                    progressBar.find('span').html(0 + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                    item.html.find('.progress-bar2').fadeOut(400);
                }

                item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                    '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                ) : null;
            },
            onProgress: function(data, item) {
                var progressBar = item.html.find('.progress-bar2');

                if(progressBar.length > 0) {
                    progressBar.show();
                    progressBar.find('span').html(data.percentage + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                }
            },
            onComplete: null,
        },
        onRemove: function(item) {
            $.post(BaseAdminURL +'/?cmd=Dosya/RemoveWidget', {
                 file: item.name,
                 id:$('#fileuploader input[name=id]').val(),
                 modul:$('#fileuploader input[name=modul]').val(),
                 folder:$('#fileuploader input[name=folder]').val()

            });
        },
        captions: {
            feedback: 'Sürükleyip Bırak',
            feedback2: 'Sürükleyip Bırak',
            drop: 'Sürükleyip Bırak',
            errors: {
                filesLimit: 'Only ${limit} files are allowed to be uploaded.',
                filesType: '${extensions} Dosya türlerine izin verilmektedir.',
                fileSize: '${name} çok büyük! ${fileMaxSize}MB daha az boyutta dosya yükleyin.',
                filesSizeAll: 'Files that you choosed are too large! Please upload files up to ${maxSize} MB.',
                fileName: 'File with the name ${name} is already selected.',
                folderUpload: 'You are not allowed to upload folders.'
            }
        },
    });

});

function resimkaldir(t)
{



    var bos  = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=Resim+Yok";
    var resim =  $(".eskiresim").val();


    $.ajax({

        url:BaseAdminURL+'?cmd=Ayarlar/Dosyasil.html',
        type:'POST',
        data : 'resim='+resim ,
        success:function(g)
        {
            if(g==1)
            {
                $('.fileinput ').find('.thumbnail img').attr('src',bos);
                $('.eskiresim').val('NULL');
                $('.kaldir').addClass('fileinput-exists');

            }

        }


    })


    return false;
}

/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:

    var file_ext = {'.zip':'fa-file-archive-o','.rar':'fa-file-archive-o','.xls':'fa-file-excel-o','.xlsx':'fa-file-excell-o','.doc':'fa-file-word-o','.docx':'fa-file-word-o',
        '.jpg':'fa-file-image-o','.png':'fa-file-image-o','.jpeg':'fa-file-image-o','.pdf':'fa-file-pdf-o','.odt':'fa-file-word-o'};


    $('#fileupload2').fileupload({
        url: BaseAdminURL + '/?cmd=Files/upload2',
        dataType: 'json',
        done: function (e,data) {

            //  console.log(data._response.result.files);

            $('<p/>').html('<i class="fa '+file_ext[data._response.result.files.filename]+'"> &nbsp;'+data._response.result.files.filename).appendTo('#files');
            $('.filelist').val(data._response.result.files.filename+','+$('.filelist').val());

        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});

$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:


    $('.fileupload').each(function(index, element){


        var resimid = "#"+$(this).find('input[type=file]').attr('id');

        var id = "div#"+$(this).attr('id');

        var imageurl =  $('#fotoResim_folder').val();

        if (imageurl == undefined){
            imageurl = "";
        }





        $(resimid).fileupload({
            url: BaseAdminURL+'/?cmd=Files/upload&folder='+imageurl,
            dataType: 'json',


            done: function (e, data) {

            if(data._response.result.error)
            { alert(data._response.result.error.replace('<p>','').replace('</p>',''));}
            else
            {

                $(id).find('.files').html(data._response.result.files.filename);

                $(id).find('.image_val').val(data._response.result.files.filename);
                $(id).find('.img-prev').attr('src','../upload/'+imageurl+"/"+data._response.result.files.filename).show();
                $(id).find('.crop').val('false');
            }

        },
        error: function (e, data) {

            var a = $.parseJSON(e.responseText);
            alert(a.error.replace('<p>','').replace('</p>',''));

        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(id).find('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })

        $(resimid).click(function(e) {
            $(id).find('#progress .progress-bar').css(
                'width',
                0 + '%'
            );
        });

        $(id+' .crop_file').on('click',function(e){


            var classname = $(id);
            var class1 = $(id).attr('id');
            if($(classname).find('input.crop').val()=="true")
                var image = $(classname).find('.files').html().replace('crop_');
            else
                var image = $(classname).find('.files').html();

            var cropname =  $(classname).find('input.crop').attr('name');
            var imageurl =  $(classname).find('input.image_folder').val();

            if(image)
            {
                var size = $(this).attr('data-id').split('x');
                $.fancybox({
                href:BaseAdminURL+ '/?cmd=Files/crop&image='+image+'&width='+size[0]+'&height='+size[1]+'&'+cropname+'=true'+'&classname='+class1+'&folder='+imageurl,
                type:'iframe',
                padding:1,
                margin:1
            });
            }
            else alert('Resim bulunamadı');

        });

    });


});


$(window).ready(function(e){


    $('#eklefiyat').click(function (e) {

        var item = $('.ornek table tbody').html();
        $('#fiyatekle').append(item);



        return false;
    });

    $('select[name=projefild]').change(function(e){

        var  url = $(this).data('url');
        location.href = BaseAdminURL +'/?cmd=Projeler/Liste/' + $(this).find('option:selected').val();


    });

    $('select[name=fotogaleri]').change(function(e){

        var  url = $(this).data('url');
        location.href = BaseAdminURL +'/?cmd=Galeri/fotoekle/'+$(this).find('option:selected').val();


    });

    $('select[name=paketfild]').change(function(e){

        var  url = $(this).data('url');
        location.href = BaseAdminURL +'/?cmd=Paketler/liste/'+$(this).find('option:selected').val();


    });

    $('select[name=projekatfild]').change(function(e){

        var  url = $(this).data('url');
        location.href = BaseAdminURL +'/?cmd=Projeler/Liste/' + $(this).find('option:selected').val();


    });


    $('select[name=katfild]').change(function(e){

        var  url = $(this).data('url');
        location.href = BaseAdminURL + '/?cmd=Sayfa/SayfaListe/'+$(this).find('option:selected').val();


    });
    $('select[name=urunfild]').change(function(e){

        var  url = $(this).data('url');
        var veri = $(this).find('option:selected').val();
        if (veri != 0){
            location.href = BaseAdminURL + '/?cmd=Urunler/Liste/'+veri;
        }
        else {
            location.href = BaseAdminURL + '/?cmd=Urunler/Liste';
        }



    });

    $('select[name=urunkatfild]').change(function(e){

        var  url = $(this).data('url');
        location.href = BaseAdminURL + '/?cmd=Urunler/kategoriListesi/' + $(this).find('option:selected').val();
     });
    $('.dosya').fancybox({width:'80%',height:'600'});
    $('.fancy').fancybox({width:'1000',height:'700'});
    $(".popImage").fancybox();
    $(".select2").select2({ language: "tr"});

    $("#checkbox").click(function(){
        if($("#checkbox").prop('checked') ){
            $(".select2 > option").prop("selected","selected");
            $(".select2").trigger("change");
        }else{
            $(".select2 > option").removeAttr("selected");
            $(".select2").trigger("change");
        }
    });

    /*  var group = $('.sorted_table').sortable({
     containerSelector: 'table',
     group: 'serialization',
     itemPath: '> tbody',
     itemSelector: 'tr',
     placeholder: '<tr class="placeholder"/>',
     onDrop: function ($item, container, _super, event) {
     $item.removeClass(container.group.options.draggedClass).removeAttr("style")
     $("body").removeClass(container.group.options.bodyClass);


     var data = group.sortable("serialize").get();
     console.log(data);
     var jsonString = JSON.stringify(data, null, ' ');

     console.log(jsonString);

     }
     });*/

    if(typeof($().bootstrapSwitch)=="function") $('input[name=state]').bootstrapSwitch();

    $("#sortable").sortable({
        items:'tr',
        cursorAt: { left: 0, top: 0 },
        cursor: "move",
        connectWith: 'tbody',
        update : function (ev,ui) {
            //  var ilkID = (ui.item[0].nextElementSibling) ? $(ui.item[0].nextElementSibling).data('id'):null;
            //  var sonID = (ui.item[0].previousElementSibling) ? $(ui.item[0].previousElementSibling).data('id'):null;

            var sayfa = $('#sortable').data('id');

            var page = $('#sortable').data('page');




            var sirala = [];

            $('#sortable tbody').find('tr').each(function(index, element) {
                sirala[index] = $(this).data('id');
            });

            $("#showmsg").load(BaseAdminURL+'/?cmd=Sirala/'+sayfa+'&sirala='+sirala+"&page="+page);

        }
    });


    $(window).ready(function (e) {
        uploader.init();
    });

    var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickfiles', // you can pass in id...
            container: document.getElementById('dosyayukle'), // ... or DOM Element itself
            chunk_size : '10mb',  // partlı olarak yukler
            multi_selection : true,
            multipart: true,
            urlstream_upload: true,
            url : BaseAdminURL + '/?cmd=Dosya/yukle&son_id='+$('#pickfiles').data('id')+'&folder='+$('#pickfiles').data('url')+'&modul='+$('#pickfiles').data('type')+'&baslik='+$('#pickfiles').data('name'),
        flash_swf_url : BaseAdminURL + '/helper/dosya/yukle/pl_upload/Moxie.swf',
        silverlight_xap_url : BaseAdminURL + '/helper/dosya/yukle/pl_upload/Moxie.xap',
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


    tinymce.init({
        entity_encoding : "raw",
        selector: 'textarea.editor',
        theme: 'modern',
        language: 'tr_TR',

        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager code directionality'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: " link unlink anchor | image media | forecolor backcolor  | print preview code | responsivefilemanager | pastetext,pasteword,selectall | ltr rtl",
        image_advtab: true,

        external_filemanager_path: BaseAdminURL +"/helper/editor/",
        filemanager_title:"Dosya Yöneticisi" ,
        external_plugins: { "filemanager" : BaseAdminURL +"/helper/editor/plugin.min.js"},
        filebrowserBrowseUrl : BaseAdminURL +'/helper/editor/dialog.php?type=2&editor=ckeditor&fldr=',
        filebrowserUploadUrl : BaseAdminURL +'/helper/editor/dialog.php?type=2&editor=ckeditor&fldr=',
        filebrowserImageBrowseUrl : BaseAdminURL +'/helper/editor/dialog.php?type=1&editor=ckeditor&fldr=',

    });



});
