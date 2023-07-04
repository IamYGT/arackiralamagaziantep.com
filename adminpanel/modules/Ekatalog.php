<?php
namespace AdminPanel;

use AdminPanel\Form;

class Ekatalog extends Settings  {

    public $SayfaBaslik = 'E-Katalog';
    public $modulName = 'Ekatalog';
    public $icbaslik ;

    private $module = 'katalog';
    private $table = 'katalog';
    private $tablelang = 'katalog_lang';


    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();

    }

    public function index($id=null)
    {
      $this->liste($id);
    }

    public function ekle($id=null)
    {
        $this->icbaslik = 'E-Katalog Ekle';
        
        if(isset($id) and $id) $data = $this->dbConn->tekSorgu('select * from '.$this->module.' WHERE id='.$id);


        $form = new Form($this->settings);

        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        
            $text.= $form->input(array('value'=>((isset($data['boyut']) ? $this->temizle($data['boyut']) :'')),'title'=>'Katalog Boyutu (GenxYük)','name'=>'boyut','id'=>'baslik','help'=>'Örneğin (900x1200)','lang'=>"tr"));
         
    
        
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        return $text;


    }



    public function kaydet($id=null)
    {

     ;


        foreach ($this->settings->lang('lang') as $dil=>$title):
            if($dil == "tr"):

                $post[$dil] = array(
                    'boyut'=> $this->kirlet($this->_POST('boyut_tr')),
                );

            else:
                $post[$dil] = array(
                    'boyut'=> $this->kirlet($this->_POST('boyut_tr')),
                );

            endif;
        endforeach;


        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update($this->table,$post['tr'],$id);

            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {

                    if(count($this->dbConn->sorgu("select * from $this->tablelang where dil='$dil'  and master_id='$id' "))==1)
                    {
                        $this->dbConn->update($this->tablelang, $post[$dil],array('master_id'=>$id,'dil'=>$dil));

                    }

                    else
                        $this->dbConn->insert($this->tablelang,array_merge($post[$dil],array('dil'=>$dil,'master_id'=>$id)));
                }
            endforeach;
        else:
            // kaydet
            $this->dbConn->insert($this->table,$post['tr'],$id);
            $lastid = $this->dbConn->lastid();
            $this->FileSessionSave($lastid,$this->module);
            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {
                    $this->dbConn->insert($this->tablelang, array_merge($post[$dil], array('dil' => $dil, 'master_id' => $lastid)));
                }
            endforeach;
        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));

    }

    public function sil($id=null)
    {
        if($id){
            $this->dbConn->sil("DELETE FROM $this->table where  id=".$id);
            $this->dbConn->sil("DELETE FROM dosyalar where type='katalog' and data_id=".$id);

        }
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }
    /**
     * @param null $id
     * @return string
     */
    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        $data = $this->dbConn->tekSorgu('select * from '.$this->module.' WHERE id = 1');


        return $pagelist->Pagelist(array(
            'title'=> 'E-Katalog (Önerilen Resim Boyutu : '.$data["boyut"].")",
            'page'=>'katalog',
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue')),
            'buton'=> array(
                array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','url'=>$this->BaseAdminURL($this->modulName.'/KatalogResimEkle/'),'modul'=>$this->module,'folder'=>'../'.$this->settings->config('folder'))
            ),
            'pdata' => $this->dbConn->sorgu('select * from '.$this->table.' order by  sira'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'60%'),
                array("title"=>"Resim Ekle", 'width'=>'10%'),
            )

        ));

    }

    public function KatalogResimEkle($id=null)
    {
        if(isset($id) and $id) $data = $this->dbConn->tekSorgu('select * from '.$this->table.'  WHERE id='.$id);

        $this->icbaslik = 'Katalog Sayfa Ekle <br> <span style="font-size:14px;">Yeni Katalog Ekliyorsanız Önce <a href="'.$this->BaseAdminURL($this->modulName.'/silTumu/').'" style="color:#f00">Buraya Tıklayarak</a> Önceki Sayfaları Siliniz.</span>';


        $pagelist = new Pagelist($this->settings);

        return $pagelist->Fotolist(array(
            'title'=> 'Resim Listesi',
            'icbaslik' => $this->icbaslik,
            'id'=>$id,
            'page'=>'dosyalar',
            'pfolder'=>'../'.$this->settings->config('folder').$this->module."/",
            //button' => array(array('title'=>'Tüm Resimleri Sil', 'href'=> $this->BaseAdminURL($this->modulName.'/ekle.html'))),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'dosya', 'class'=>'sort')
            ),
            'tools' =>array(
                //array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/urunResimduzenle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/KatalogResimSil/'),'color'=>'red')),
            'yukle'=> array('type'=>'button','title'=>'Resim Ekle','class'=>'btn btn-primary','modul'=>$this->module,'folder'=>'../'.$this->settings->config('folder').$this->module."/",'name'=>((isset($data['url'])) ? $data['url']:null), 'baslik'=>$this->permalink($data["baslik"])),

            'buton'=> array(
                //array('type'=>'radio','dataname'=>'durum','url'=>$this->BaseAdminURL($this->modulName.'/durum/')),
            ),
            'pdata' => $this->dbConn->sorgu("select * from dosyalar where type='$this->module' and data_id='$id' ORDER   BY  id ASC"),
            'baslik'=>array(
                array('title'=>'Sıra No','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%'),
                //   array('title'=>'Aktif','width'=>'5%'),
                //   array('title'=>'Resimler','width'=>'8%'),
            )

        ));
    }


    public function KatalogResimSil($id=null)
    {
        if($id) {
            $al = $this->dbConn->tekSorgu("SELECT * FROM dosyalar WHERE id = $id");
            $dosya = $al["dosya"];


            $sil = $_SERVER['DOCUMENT_ROOT']."/upload/katalog/".$dosya;
               
            @unlink($sil);

            $this->dbConn->sil("DELETE FROM  dosyalar where id=" . $id);
        }
       

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/KatalogResimEkle/1'));

        
    }



    public function _KLASORSIL($_KLASOR) {
          IF (substr($_KLASOR, strlen($_KLASOR)-1, 1)!= '/')
          $_KLASOR .= '/';
          IF ($handle = opendir($_KLASOR)) {
            WHILE ($_OBJ = readdir($handle)) {
              IF ($_OBJ!= '.' && $_OBJ!= '..') {
                IF (is_dir($_KLASOR.$_OBJ)) {
                  IF (!KlasorSil($_KLASOR.$_OBJ))
                    RETURN FALSE;
                  } ELSEIF (is_file($_KLASOR.$_OBJ)) {
                    IF (!unlink($_KLASOR.$_OBJ))
                      RETURN FALSE;
                    }
                }
            }
              CLOSEDIR($handle);
              IF (!@rmdir($_KLASOR))
              RETURN FALSE;
              RETURN TRUE;
            }
          RETURN FALSE;
  }

    public function silTumu($id=null)
    {


            $data = $this->dbConn->sorgu("select * from dosyalar where type='katalog'");

            foreach ($data as $veri) {
                $dosya = $_SERVER['DOCUMENT_ROOT']."/upload/katalog/".$veri["dosya"];
               
                @unlink($dosya);

                @$this->_KLASORSIL($_SERVER['DOCUMENT_ROOT']."upload/katalog/temp");
            }

            @$this->dbConn->sil("DELETE FROM  dosyalar where type='katalog'");


       

            @$this->RedirectURL($this->BaseAdminURL($this->modulName.'/KatalogResimEkle/1'));

       
    }






    public function durum($id=null)

    {



      $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

      //$durum = (($durum==1) ? 0 :1);

      $id = ((isset($_GET['id'])) ? $_GET['id'] : null);

        if($this->dbConn->update('katalog',array('aktif'=>$durum),$id)) echo 1;else echo 0;



        exit;

    }


    public function CustomPageCss($url)
    {
    }


    public function CustomPageJs($url)
    {

    }

}