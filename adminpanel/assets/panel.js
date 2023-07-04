/**
 * Created by VEMEDYA on 21.05.2016.
 */

$(window).ready(function(e){

    $.panel = {

        'durum' : function(t,id,url){

          var  durum =  (($(t).val()==1) ? 0:1);


            $.ajax({

                url:url,
                type:'GET',
                data:'id='+id+'&durum='+durum,
                success:function(g)
                {
                    if(g==1) {alert('Güncellendi');
                    $(t).val(durum);
                    }
                    else alert('Hata Oluştu');
                }



            });

    },


    'detay':function (t) {

            var url = $(t).data('url');

            
            $.ajax({

                url:url,
                type:'GET',
                success:function (g) {
                    if(g){

                        var data = $.parseJSON(g);
                        var modal = $('#teknikDetay');

                        modal.attr('data-id',data.id);


                      
                        $.each(data,function (key,value) {


                         if($.inArray(key, checkbox) && modal.find('input.'+key).length>0 && value=="1"){
                                modal.find('input.' + key).prop('checked', true).iCheck('update');
                            }
                            else modal.find('label[for='+key+']').html(value);
                        });
                        
                        $('#teknikDetay').modal('show');



                    }
                }

            });




            return false;
        }



    };


});
