<?php


namespace AdminPanel;


class Dosya extends Settings
{

    public $settings;
    public $SayfaBaslik = 'Dosya Ekle';

    public function __construct($settings)
    {
        parent::__construct($settings);

        $this->settings = $settings;
        $this->AuthCheck();


    }


    public function index()
    {
        return 'Dosya Ekle';
    }

    public function resimekle()
    {
        $control = array();
        $control['folder'] = ((isset($_GET["folder"])) ?  $this->koru($_GET["folder"]):null);
        $gelenid = $control['gelenid'] = ((isset($_GET["gelenid"])) ?  $this->koru($_GET["gelenid"]):null);
        $modul =  $control['modul'] = ((isset($_GET["modul"])) ?  $this->koru($_GET["modul"]):null);
        //$kayit_turu = ((isset($_GET["kayit_turu"])) ?  $this->koru($_GET["kayit_turu"]):null);



         if($modul==1)
        {
            $control['baslik'] = "Ürün Fotoğraflar";

            $rec7 = $this->dbConn->teksorgu("SELECT * FROM urunler where id=$gelenid");
            $control['gelen_baslik'] = $this->per(strtolower($rec7["baslik"]));

            $control['data'] = $this->dbConn->sorgu("SELECT * FROM dosyalar where type=$modul and kid=$gelenid order by sira");;
        }

        if($modul==2)
        {
            $control['baslik'] = "Galeri Fotoğraflar";

            $rec7 = $this->dbConn->teksorgu("SELECT * FROM fotogaleri where id=$gelenid");
            $control['gelen_baslik'] = $this->per(strtolower($rec7["baslik"]));

            $control['data'] = $this->dbConn->sorgu("SELECT * FROM dosyalar where type=$modul and kid=$gelenid order by sira");;
        }
        $this->load('dosya/index',$control);
    }

    public function yukle()
    {
        $control = array();
        $control['folder'] = ((isset($_GET["folder"])) ?  $this->koru($_GET["folder"]):null);
        $control['modul'] = ((isset($_GET["modul"])) ?  $this->koru($_GET["modul"]):null);
        $control['son_id'] = ((isset($_GET["son_id"])) ?  $this->koru($_GET["son_id"]):null);
        $control['baslikper'] =((isset($_GET["baslik"])) ?  $this->koru($_GET["baslik"]):null);
        $this->loadphp('helper/dosya/yukle',$control);
    }


    public function YukleWidget()
    {
        $control = array();
        $control['folder'] = $this->_POST('folder');
        $control['modul'] = $this->_POST('modul');
        $control['id'] = $this->_POST('id');
        $control['name'] =$this->_POST('name');

        if($control['folder'] and !is_dir($control['folder'])) mkdir($control['folder'],755);

        // initialize FileUploader
        $FileUploader = new \FileUploader('files', array(
            'limit' => null,
            'maxSize' => null,
            'fileMaxSize' => null,
            'extensions' => null,
            'required' => false,
            'uploadDir' => $control['folder'],
            'title' => (($control['name']) ? $this->permalink($control['name']) : 'resim').'-'.rand(100000,999999),
            'replace' => false,
            'listInput' => true,
            'files' => null
        ));

        // call to upload the files
        $data = $FileUploader->upload();

        if($control['id'])
        {
            if(isset($data['files']) and is_array($data['files']))
                foreach ($data['files'] as $file)
                {
                    $this->dbConn->insert('dosyalar',
                        array(
                            'data_id'=>$control['id'],
                            'dosya'=>$file['name'],
                            'type' => $control['modul']
                        ));
                }
        }
        else
        {

            if(isset($_SESSION['proje_new_file_'.$control['modul']]) and is_array($_SESSION['proje_new_file_'.$control['modul']]))  $_SESSION['proje_new_file_'.$control['modul']] = array_merge($_SESSION['proje_new_file_'.$control['modul']],$data['files']);
            else  $_SESSION['proje_new_file_'.$control['modul']] = $data['files'];
        }

        // export to js
        echo json_encode($data);
        exit;

    }


    public function RemoveWidget(){


        $folder = $this->_POST('folder');
        $modul = $this->_POST('modul');
        $id = $this->_POST('id');
        $file =$this->_POST('file');

        if($file):

            $filename  = $folder.$file;
            if($id) $this->dbConn->sil("DELETE from dosyalar where data_id='{$id}' and type='{$modul}' and dosya='{$file}'");
            if($filename and file_exists($filename))   unlink($filename);
            if(isset($_SESSION['proje_new_file_'.$modul]) and is_array($_SESSION['proje_new_file_'.$modul]))
            {
                $files = $_SESSION['proje_new_file_'.$modul];
                foreach ($files as $key=>$item) if($item['name'] == $file) unset($_SESSION['proje_new_file_'.$modul][$key]);


            }

        endif;

    }



    public  function sil()
    {


        $id = ((isset($_GET["id"])) ?  $this->koru($_GET["id"]):null);
        $gelenid =  ((isset($_GET["gelenid"])) ?  $this->koru($_GET["gelenid"]):null);
        $modul =  ((isset($_GET["modul"])) ?  $this->koru($_GET["modul"]):null);
        $folder =  ((isset($_GET["folder"])) ?  $this->koru($_GET["folder"]):null);

        $rec2 = $this->dbConn->tekSorgu("SELECT * FROM dosyalar WHERE id='$id'");

        $resim2=$rec2["dosya"];
        $this->ResimSil($resim2,base64_decode($folder)); // Eski resmi sil


        $this->dbConn->sil("DELETE FROM dosyalar WHERE id='$id'");


      header("location:?cmd=Dosya/resimekle&gelenid=".$gelenid."&modul=".$modul."&folder=".$folder);

    }

} 