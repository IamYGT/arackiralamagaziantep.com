<?php

namespace AdminPanel;

use AdminPanel\Form;

class Teknik extends Settings  {

    public  $SayfaBaslik = 'Teknik Döküman Talep Listesi';
    public  $modulName = 'Teknik';
    public  $icbaslik ;
    private $js = array();
    private $css = array();
    private $module = 3;
    private $table = "teknik";
    private $tablelang = "teknik_lang";



    public function __construct($settings)
    {
      parent::__construct($settings);
      $this->AuthCheck();
    }

    public function index()
    {

    }




    public function ekle($id=null)
    {


       if(isset($id) and $id) $veri = $this->dbConn->tekSorgu('select * from teknik WHERE id='.$id);

       $this->icbaslik = "<b>".$veri["adi"]."</b> - ".$veri["email"];
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);

        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));

        $text.="<table class='table table-striped table-bordered  sorted_table ui-sortable'>";

        $text.="<tr><td width='15%'><strong>Adı Soyadı</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["adi"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Telefon No</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["tel"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Email Adresi</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["email"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Firma Adı</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["firma"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Mesajı</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["mesaj"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>İp Adresi</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["ip"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Başvuru Tarihi</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["tarih"]."</td></tr>";

        $text.="</table>";

        $text.="<a class='btn btn-primary' href='".$this->BaseAdminURL($this->modulName."/liste")."'><i class='fa fa-angle-left'></i> Geri Dön</a>";

        $text .= $form->formClose();

        $goruldu = $this->dbConn->update("teknik",array('goruldu'=>1),$id);


        return $text;


    }



    public function kaydet($id=null)
    {

        foreach ($this->settings->lang('lang') as $dil=>$title):

            if($dil == "tr"):
                $post[$dil] = array(
                    'firma'=> $this->kirlet($this->_POST('firma',$dil)),
                    'sehir'=> $this->kirlet($this->_POST('sehir_tr')),
                    'dil'=>$dil,
                    'resim' => $this->_RESIM('refResim_tr')
                );

            else:
                $post[$dil] = array(
                    'firma'=> $this->kirlet($this->_POST('firma',$dil)),
                    'sehir'=> $this->kirlet($this->_POST('sehir_tr')),
                    'dil'=>$dil
                );

            endif;

        endforeach;

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update($this->table,$post['tr'],$id);
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {
                    if(count($this->dbConn->sorgu("select * from ".$this->tablelang." where dil='".$dil."' and master_id='".$id."' "))==1)
                        $this->dbConn->update($this->tablelang, $post[$dil],array('master_id'=>$id,'dil'=>$dil));
                    else
                        $this->dbConn->insert($this->tablelang,array_merge($post[$dil],array('master_id'=>$id)));
                }
            endforeach;
        else:
            // kaydet
            $this->dbConn->insert($this->table,$post['tr'],$id);
            $lastid = $this->dbConn->lastid();
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
       if($id) $this->dbConn->sil('DELETE FROM '.$this->table.' where id='.$id);
       //if($id) $this->dbConn->sil('DELETE FROM '.$this->tablelang.' where master_id='.$id);
       $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }


    /**
     * @param null $id
     * @return string
    */


    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        $ek = "";

        if (isset($_GET["kelime"])){
            $ek = "WHERE adi LIKE '%".$_GET["kelime"]."%' OR firma LIKE '%".$_GET["kelime"]."%' OR email LIKE '%".$_GET["kelime"]."%'";
        }

        $toplamVeri = count($this->dbConn->sorgu("select * from $this->table $ek order by goruldu ASC, id DESC"));

        $sayfa = (isset($_GET["sayfa"])) ? $this->kirlet(intval($_GET['sayfa'])) : 1;

        if (!is_numeric($sayfa)){
            $sayfa = 1;
        }

        $sayfaLimit = 50;

        $gecerli = 0;

        $toplamSayfa = ceil($toplamVeri / $sayfaLimit);

        if ($sayfa > $toplamSayfa)
        {
            $sayfa = 1;
        }

        if ($sayfa > 0){
            $gecerli = ($sayfa - 1) * $sayfaLimit;
        }
        $html = "";

        $sifreAl = $this->dbConn->tekSorgu("SELECT sifre FROM teknik_sifre WHERE id = 1");
        $sifreli = $sifreAl["sifre"];

      $html.=$pagelist->Pagelist(array(
         'title'=> 'Teknik Döküman Şifresi : ',
         'sayfaLimit'=>$sayfaLimit,
         'page'=>$this->modulName,
         'veri'=>array('sifre'=>$this->sifreCoz($sifreli), "id"=>"sifre_guncelle"),
         //'button' => array(array('title'=>'Referans Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
         'p'=>array(
                      array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id', 'dataTur'=>"goruldu"),
                      array('dataTitle'=>'firma', 'class'=>'sort'),
                      array('dataTitle'=>'adi', 'class'=>'sort'),
                      array('dataTitle'=>'email', 'class'=>'sort'),
                      array('dataTitle'=>'tarih', 'class'=>'sort')
                  ),
         'tools' =>array(array('title'=>'Detaylar','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-time','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),


         'pdata' => $this->dbConn->sorgu("select * from $this->table $ek order by  goruldu ASC, id DESC LIMIT $gecerli,$sayfaLimit"),
         'toplamVeri'=>$toplamVeri,
         'ek'=>$ek,
         'search'=>true,

         'baslik'=>array(
             array('title'=>'ID','width'=>'4%'),
             array('title'=>'Firma Adı','width'=>'25%'),
             array('title'=>'Adı','width'=>'20%'),
             array('title'=>'Email','width'=>'20%'),
             array('title'=>'Tarih','width'=>'5%'),
          )

     ));

        $modal = new Widget($this->settings);
        $html .=  $modal->bulten($this->dbConn->sorgu('select * from teknik order by id desc'),'bultenmodal');

        return $html;
    }


    public function sifrele($sifre){
        $password = 'vmdygaimder4321';
        $method = 'aes-256-cbc';
        $password = substr(hash('sha256', $password, true), 0, 32);

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        return base64_encode(openssl_encrypt($sifre, $method, $password, OPENSSL_RAW_DATA, $iv));
    }

    public function sifreCoz($sifreliVeri){

        $password = 'vmdygaimder4321';
        $method = 'aes-256-cbc';
        $password = substr(hash('sha256', $password, true), 0, 32);

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        return openssl_decrypt(base64_decode($sifreliVeri), $method, $password, OPENSSL_RAW_DATA, $iv);
    }


     public function vitrin($id=null)
    {
        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);

        $bayiDuzenle = $this->dbConn->update($this->table,array('durum'=>$durum),$id);
        $langDuzenle = $this->dbConn->langUpdate($this->tablelang,array('durum'=>$durum),$id);

        if($bayiDuzenle && $langDuzenle) echo 1;else echo 0;

        exit();
    }

    public function degistir($id=null)
    {
       $sifre = $this->sifrele($_GET["sifre"]);
       $duzen = $this->dbConn->update("teknik_sifre",array('sifre'=>$sifre),1);
       if ($duzen)
       {
        echo 1;
       }
       else {
        echo 2;
       }
    }


    public function CustomPageCss($url)
    {
        // Sadece bu sayfa için gerekli Stil dosyaları eklenebilir
        $text = '';
        foreach($this->css as $css) $text .= $css;
        return $text;

    }

    public function CustomPageJs($url)
    {
        // Sadece bu sayfa için gerekli javascript dosyaları eklenebilir
        $text = '';
        foreach($this->js as $js) $text .= $js;
        return $text;
    }

}
