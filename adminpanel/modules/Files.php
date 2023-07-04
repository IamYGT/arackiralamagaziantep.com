<?php

namespace AdminPanel;
use Fusonic\OpenGraph\Consumer;

class Files extends Settings
{

    public $settings;
    public $SayfaBaslik = 'Anasayfa';

    public function __construct($settings)
    {
        parent::__construct($settings);

        $this->settings = $settings;
        $this->AuthCheck();
    }


    public function index()
    {
        return 'Anasayfa';
    }

    public function Get()
    {
      $url = $this->_GET('url');
      $type = $this->_GET('type');


     switch ($type):
    default:
        $consumer = new Consumer();
        $object = $consumer->loadUrl($url);
         echo $object->videos[0]->url;
         break;
         case 'aksam':
             $data = file_get_contents($url);
             $dataHtml = explode('<iframe',$data);
             $dataHtml = explode('iframe>', $dataHtml[1]);
             $dataHtml = str_replace('\'','"',$dataHtml);
             echo  trim($dataHtml[0]);

         break;

       endswitch;

    }

    public function crop($control = array())
    {
        $control = array('image'=>((isset($_GET['image'])) ? $_GET['image'] : null),
                     'width'=>((isset($_GET['width'])) ? $_GET['width'] : null),
                     'height'=>((isset($_GET['height'])) ? $_GET['height'] : null),
                     'folder'=>((isset($_GET['folder'])) ? $_GET['folder'] : null),
                     'classname'=>((isset($_GET['classname'])) ? $_GET['classname'] : null),
                     'control' => $this,
                     'settings' => $this->settings
            );
        $this->load('helper/crop/crop', $control);
    }


    public function upload(){

      // $files =  json_decode($_POST,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $folder = (isset($_GET["folder"])) ? $_GET["folder"] : "";


        $baslik = ((isset($_POST['baslik'])) ? $_POST['baslik']:((isset($_POST['firma'])) ? $_POST['firma']:'resim'));


        $file = $this->imageUploader($_FILES,$baslik,$folder);
        echo  json_encode(array('files' =>array('filename'=>$file,'class'=>'')));

        }


    public function croped()
    {

        $classname = $this->_POST('classname');
        $folder = $this->_POST('folder').'/'  ;
        $src = '../'.$this->settings->config('folder').$folder.$this->_POST('source_image');
        $type = explode('.',$this->_POST('source_image'));
        $type = $type[count($type)-1];
        $w = $this->_POST('width');
        $h = $this->_POST('height');
        $x= $this->_POST('dataX');
        $y=  $this->_POST('dataY');
        $targ_w = $this->_POST('dataWidth');
        $targ_h = $this->_POST('dataHeight');
        $jpeg_quality = 90;

        if($this->_POST('source_image')):
        if($type == 'jpg')   $img_r = imagecreatefromjpeg($src);
        if($type == 'png') $img_r = imagecreatefrompng($src);
        if($type == 'gif') $img_r = imagecreatefromgif($src);
        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
        $output_filename = '../'.$this->settings->config('folder').(($this->_POST('folder')) ? '/'.$this->_POST('folder'):null).'/crop_'.$this->_POST('source_image');
        imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$targ_w,$targ_h);
         //header('Content-type: image/jpeg');
       if($type == 'jpg' or $type == 'jpeg') imagejpeg($dst_r, $output_filename, $jpeg_quality);
       if($type == 'png') imagepng($dst_r, $output_filename,9);
       if($type == 'gif') imagegif($dst_r, $output_filename);

        $this->kucult('../'.$this->settings->config('folder').(($this->_POST('folder')) ? '/'.$this->_POST('folder'):null),'/crop_'.$this->_POST('source_image'),$w,$h);


        echo '<script>
             parent.$("#'.$classname.'").find(".files").data("file","' . $this->_POST('source_image') . '");
             parent.$("#'.$classname.'").find("input.image_val").val("' . $this->_POST('source_image') . '");
             parent.$("#'.$classname.'").find(".img-prev").attr("src","'.$output_filename . '?"+Math.random()).fadeIn(100);
             parent.$("#'.$classname.'").find("input.crop").val("true");
             parent.$.fancybox.close();

                 </script>';
            else:
           echo 0;
               endif;
    }


    public function upload2(){

        $baslik = ((isset($_POST['baslik'])) ? $_POST['baslik']:((isset($_POST['firma'])) ? $_POST['firma']:'resim'));
        $file = $this->fileUpload($_FILES,$baslik);
        echo  json_encode(array('files' =>array('filename'=>$file,'class'=>'')));

    }


}