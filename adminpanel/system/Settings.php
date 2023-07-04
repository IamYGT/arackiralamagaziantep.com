<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 02.03.2016
 * Time: 14:30
 */

namespace AdminPanel;



use Fonksiyonlar\Func;

class Settings extends Func
{

    public $dbConn;
    public $baslik = '';
    public $settings = '';
    private $folder = '';
    private $allow_image_type;
    private $allow_file_type;

    public function __construct($settings)
    {

        $this->dbConn = $this->db($settings);
        $this->settings = $settings;
        $this->folder = "../" . $settings->config('folder');
        $this->allow_image_type = $settings->file('allow_image_type');
        $this->allow_file_type = $settings->file('allow_file_type');
    }


    public function db($settings)
    {
        $db = new \Database\Data($settings);
        return $db;
    }

    public function PageList($param = array())
    {
        $liste = new PageList();
        return $liste->Liste($param = array());
    }

    public function BaseAdminURL($url = null)
    {
        return (($url) ? $this->settings->config('url'). $this->settings->config('adminfolder'). '/' . (($this->settings->config('adminSeo')) ? null : '?cmd=') . $url :
            $this->settings->config('url'). $this->settings->config('adminfolder')
        );
    }

    public function BaseAdmin($url = null)
    {
        return (($url) ? $this->settings->config('url'). $this->settings->config('adminfolder'). '/' . $url :
            $this->settings->config('url'). $this->settings->config('adminfolder')
        );
    }

    public function ThemeFile($url = null)
    {
        return (($url) ? $this->settings->config('url').$this->settings->config('adminfolder'). '/theme/' . $this->settings->config('adminTheme'). '/' . $url :
            $this->settings->config('url'). $this->settings->config('adminfolder'). '/theme/' . $this->settings->config('adminTheme')
        );
    }


    public function BaseURL($url = null)
    {
        return (($url) ? $this->settings->config('url') . '/' . $url : $this->settings->config('url'));
    }

    public function RedirectURL($url)
    {
        header('location:' . $url);
    }

    public function FileSessionSave($lastid,$module)
    {
        if(isset($_SESSION['proje_new_file_'.$module]) and is_array($_SESSION['proje_new_file_'.$module])):
            foreach ($_SESSION['proje_new_file_'.$module] as $key=>$file)
            {
                $this->dbConn->insert('dosyalar',
                    array(
                        'data_id'=> $lastid,
                        'dosya'=>$file['name'],
                        'type' => $module,
                        'sira' => $key+1
                    ));
            }
            unset($_SESSION['proje_new_file_'.$module]);
        endif;
    }



    public function SeoURL($table,$url = array())
    {

        $sURL = strtolower($this->permalink($url['value']));

        $baslik = $url['value'];
        $name = kirlet($url['name']);

        $sorgu = $this->dbConn->sorgu("select * from $table where $name='{$baslik}' ");

        if(count($sorgu)>1)  return $sURL.'-'.$url['id'];
        else return $sURL;


    }

    public function imageUploader($files, $name, $folder=null)
    {
        $filename = array();

        $folder = str_replace("/","",$folder);

        foreach ($files as $name2 => $file):
            $fname = $this->addegisir($file['name'], strtolower($name));
            if (isset($file['type']) and in_array(strtolower($file['type']), $this->allow_image_type)):  move_uploaded_file($file['tmp_name'], $this->folder.'/'.$folder."/".$fname);
                $filename[] = $fname;
            endif;

        endforeach;

        return $filename;

    }

    public function fileUpload($files, $name)
    {

        $filename = array();
        foreach ($files as $name2 => $file):
            $uzanti = explode('.',$file['name']);
            $uzanti = $uzanti[count($uzanti)-1];

            $fname = $this->addegisir($file['name'], strtolower($name));
            if (isset($file['type']) and in_array(strtolower($uzanti), $this->allow_file_type)):  move_uploaded_file($file['tmp_name'], $this->folder . '/dosya/' . $fname);
                $filename[] = $fname;
            endif;

        endforeach;

        return $filename;
    }


    public function perma($deger)
    {
        $turkce = array("þ", "Þ", "ý", "(", ")", "'", "ü", "Ü", "ö", "Ö", "ç", "Ç", " ", "/", "*", "?", "ð", "Ð", "Ý", "Ã–", "Ã‡", "Åž", "Ä°", "Äž", "Ãœ", "Ä±", "Ã¶", "Ã§", "ÅŸ", "ÄŸ", "Ã¼", "ı", "ğ", 'İ', 'Ü', 'Ğ', 'Ş', '.', 'ş', '"');
        $duzgun = array("s", "s", "i", "", "", "", "u", "u", "o", "o", "c", "c", "-", "", "-", "", "g", "g", "i", "o", "c", "s", "i", "g", "u", "i", "o", "c", "s", "g", "u", "i", "g", 'i', 'u', 'g', 's', '', 's', '');
        $deger = str_replace($turkce, $duzgun, $deger);
        $deger = preg_replace("@[^A-Za-z0-9\-_]+@i", "", $deger);
        //  $date =rand(10000,99999);
        return $deger;
    }

    public function load($file, $control, $string = false)
    {

        $dwoo = new \Dwoo();
       // $dwoo->getCacheTime(2000);
        $dwoo->setCompileDir('compiled/');
        $dwoo->setCacheDir('cache/');


        $dwoo->clearCompiled();
        if($string):
            if ($file and file_exists($file . '.tpl')):
               return  $dwoo->output($file.'.tpl', $control);
            //  include('theme/' . $file . '.tpl');
            endif;
        else:
            if ($file and file_exists($file . '.tpl')):
              $dwoo->output($file . '.tpl', $control);

        endif;
        endif;

    }

    public function loadphp($file, $control, $string = false)
    {
        if ($string):
            if ($file and file_exists( $file . '.php'))
                include( $file . '.php');
            else
                include( $file . '.php');
        else:
            if ($file and file_exists( $file . '.php'))
                return include( $file . '.php');
            else
                return include( $file . '.php');
        endif;

    }


    public function arraytojson($post,$dil=null)
    {
        //DİL SEÇENEĞİ $post = $post.(($dil) ? '_'.$dil:null);
        $c = array();

        if (is_array($post))
            foreach ($post as $p):
                $c[] = $p;
            endforeach;
        return json_encode($c);
    }


    public function sirala($veri, $tablo, $page = 1)
    {
        $sirala = explode(',',$veri);

        if(count($sirala)>1):
            if ($page != 1){
                $x = ($page * $this->settings->config("veriLimit") - ($this->settings->config("veriLimit") + 1));
            }
            else {
                $x = 1;
            }

            foreach($sirala as $sira):
                $this->dbConn->update($tablo,array('sira'=>$x),$sira);
                $x++;
            endforeach;

           return true;
        endif;


    }


    public function AuthCheck()
    {
         $user = $this->get_element('kullanici');
         $pass = $this->get_element('sifre');
         $key = sha1(md5($user.$pass.$this->settings->config('passkey')));

          if(!isset($_SESSION['loginS'])) $this->RedirectURL($this->BaseAdmin('login.html'));
          else if(($_SESSION['loginS'] !=  $key)) $this->RedirectURL($this->BaseAdmin('login.html'));
          else if(isset($_COOKIE['loginC']) and ($_COOKIE['loginC'] !=  $key)) $this->RedirectURL($this->BaseAdmin('login.html'));


    }

    public function get_element($element,$defaultval=null)
    {
        $q =  $this->dbConn->tekSorgu("select value from ayarlar where name='$element'");

        if($q)
        {
            if($defaultval) {
                $this->dbConn->update('ayarlar', array('value'=>$defaultval),array('name'=>$element));
                return $defaultval;
            }
            else return ((isset($q['value']) and $q['value']) ? $q['value']:'');
        }
        else
        {
            $this->dbConn->insert('ayarlar', array('name'=>$element,'value'=>$defaultval));
            return $defaultval;
        }


    }


        public static function isJSON($string){
            return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
        }

    public function resimGet($resim)
    {
        if(self::isJSON($resim)):
            $files =  json_decode($resim,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            return (isset($files['image']) and is_array($files)) ? (($files['crop']=="true") ? "crop_".$files['image']:$files['image']):null;
        else:
            return $resim;
        endif;
    }


    public function _POST($post,$dil=null)
    {
        $post = $post.(($dil) ? '_'.$dil:null);
         return (isset($_POST[$post])) ? $_POST[$post]:null;
    }


    public function _MULTIPOST($post)
    {
        $a = array();
        $x=0;
        $p = (isset($_POST[$post])) ? $_POST[$post]:null;

        if(is_array($p))
            for ($i=0;$i<count($p)-1;$i++):
                $x++;
                $a[]    = array($post.$x=>$p[$i]);
                endfor;

        return  json_encode($a,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }



    public function _GET($post,$dil=null)
    {
        $post = $post.(($dil) ? '_'.$dil:null);
        return (isset($_GET[$post])) ? $_GET[$post]:null;
    }

    public function _RESIM($image)
    {
        $images =  array('image'=>$this->_POST($image),'crop'=>$this->_POST('crop_'.$image ));
        return  $files =  json_encode($images,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    public function _DOSYA($p)
    {
        $file = array();
        $files = explode(',',$this->_POST($p));
        if(is_array($files))
            foreach ($files as $item):

                if($item) {
                    $uzanti = explode('.',$item);
                    $uzanti = $uzanti[count($uzanti)-1];

                    $file[] = array('file'=>$item,'type' => $uzanti);

                }
                endforeach;


        return  $files =  json_encode($file,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    public  function _ResimSil($image)
    {
        if(self::isJSON($image)):



            else:

            endif;


    }

    public  function  _ResimBul($sql,$folder=null,$id=null)
    {

        if($sql):


            endif;


    }

    public function _inc($file,$data=null)
    {

        $data = array_merge($data);
        if($data) extract($data);
        if($file and file_exists('theme/'.$this->settings->config('adminTheme').'/layout/Form/'.$file.'.php')):
            ob_start();
            include 'theme/'.$this->settings->config('adminTheme').'/layout/Form/'.$file.'.php';
            return ob_get_clean();
        else:
            if($file and file_exists('theme/admin/layout/'.$file.'.php')):
                ob_start();
                include 'theme/admin/layout/'.$file.'.php';
                return ob_get_clean();
            else:
                return null;
            endif;
        endif;

    }



}
