<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>Adres Seç</title>
  <link rel="stylesheet" href="{$settings->config('cdnURL')}admin/helper/harita/themes/base/jquery.ui.all.css">
  <link rel="stylesheet" href="{$settings->config('cdnURL')}admin/helper/harita/demo.css">
  <script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyA_FHbk_PHtwyGk4NCYuhp985ulq_Z9eCg"></script>
    <!-- jQuery 2.2.0 -->
    <script src="{$settings->config('cdnURL')}admin/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
<script src="{$settings->config('cdnURL')}admin/assets/jquery.easing.js"></script>
<!-- Latest compiled and minified JavaScript -->
  <link rel="stylesheet" type="text/css" href="{$settings->config('cdnURL')}admin/assets/bootstrap/css/bootstrap.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<!-- Latest compiled and minified CSS -->
 <script src="{$settings->config('cdnURL')}admin/assets/bootstrap/js/bootstrap.min.js"></script>
 
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  <script src="{$settings->config('cdnURL')}admin/assets/jquery.ui.addresspicker.js"></script>
  <script>
 
  
  
  $(function() {
	  	if(parent.$("input[name=<?=((isset($_GET['name'])) ? $_GET['name']:'harita')?>]").val()) {
            console.log(parent.$("input[name=<?=((isset($_GET['name'])) ? $_GET['name']:'harita')?>]").val());
		var ht = parent.$("input[name=<?=((isset($_GET['name'])) ? $_GET['name']:'harita')?>]").val().split(",");
		var nlang = ht[1];
		var nlat = ht[0];
     	var zoom2 = 15;	}
	   else { var nlang = 34 ; var nlat = '39.4765095550641'; var zoom2 = 9}
	  
    var addresspicker = $( "#addresspicker" ).addresspicker({
      componentsFilter: 'country:TR'
    });
    var addresspickerMap = $( "#addresspicker_map" ).addresspicker({
      regionBias: "tr",
      language: "tr",
      updateCallback: showCallback,
      mapOptions: {
        zoom: zoom2,
        center: new google.maps.LatLng(nlat,nlang),
        scrollwheel: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      },
      elements: {
        map:      "#map",
        lat:      "#lat",
        lng:      "#lng",
        street_number: '#street_number',
        route: '#route',
        locality: '#locality',
        sublocality: '#sublocality',
        administrative_area_level_3: '#administrative_area_level_3',
        administrative_area_level_2: '#administrative_area_level_2',
        administrative_area_level_1: '#administrative_area_level_1',
        country:  '#country',
        postal_code: '#postal_code',
        type:    '#type'
      }
    });

    var gmarker = addresspickerMap.addresspicker( "marker");
    gmarker.setVisible(true);
    addresspickerMap.addresspicker( "updatePosition");

     $('#reverseGeocode').change(function(){
      $("#addresspicker_map").addresspicker("option", "reverseGeocode", ($(this).val() === 'true'));
    }); 

    function showCallback(geocodeResult, parsedGeocodeResult){
      $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
    }
    // Update zoom field
    var map = $("#addresspicker_map").addresspicker("map");
    google.maps.event.addListener(map, 'idle', function(){
      $('#zoom').val(map.getZoom());
    });
	
	$(".konumsec").click(function(e) {
    	var lang = $("#lng").val();
		var lat = $("#lat").val();
 
		parent.$("input[name=<?=((isset($_GET['name'])) ? $_GET['name']:'harita')?>]").val(lat+","+lang);
		parent.$("label[for=<?=((isset($_GET['name'])) ? $_GET['name']:'harita')?>]").text("Konumunuz Seçildi. Konum : " + lat+","+lang);
	    parent.$.fancybox.close();
	});
	

  });
  </script>
</head>
<body>
 <div class="ust">
  <div class='input input-positioned'>
      <label>Adresinizi Giriniz : </label> <input id="addresspicker_map" />  
     <input  type="hidden" id="locality" >
     <input  type="hidden" id="sublocality" >
     <input  type="hidden" id="administrative_area_level_3" >
     <input  type="hidden" id="administrative_area_level_2" >
     <input  type="hidden" id="administrative_area_level_1" >
     <input  type="hidden" id="country" >
     <input  type="hidden" id="postal_code" >
     <input  type="hidden" id="lat" >
     <input  type="hidden" id="lng" >
     <input  type="hidden" id="zoom" >
     <input  type="hidden" id="type"  /> 
    </div>
  </div>
  
      <div id="map"></div>
 
    </div>
<a class="btn btn-primary btn-lg konumsec" role="button" style="font-size:13px;">Konumunu Seç</a>

 <p style="position:fixed; z-index:9999; left:0px; bottom:-10px; background-color:rgba(255,255,255,1); font-size:11px;">Not: Adres kısmına  Google haritalardan alacağınız Koordinant bilgileri girebilirsiniz. (Örn:37.034944, 37.317467)</p>
 

</body>
</html>
