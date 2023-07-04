<?php

namespace AdminPanel;

use AdminPanel\Form;

class Temsilcilik extends Settings  {

    public  $SayfaBaslik = 'Temsilcilik Talep Listesi';
    public  $modulName = 'Temsilcilik';
    public  $icbaslik ;
    private $js = array();
    private $css = array();
    private $module = 3;
    private $table = "temsilcilik";
    private $tablelang = "temsilcilik";



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


       if(isset($id) and $id) $veri = $this->dbConn->tekSorgu('select * from '.$this->table.' WHERE id='.$id);

       $this->icbaslik = "<b>".$veri["ad_soyad"]."</b> - ".$veri["email"];
        $tabForm = array();
        $form = new Form($this->settings);
       

        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
       
        $text.="<table class='table table-striped table-bordered  sorted_table ui-sortable'>";

        $text.="<tr><td width='15%'><strong>Ülke</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["ulke"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Şehir</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["sehir"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Ülke</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["ulke"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Ad Soyad</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["ad_soyad"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Email</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["email"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Cep Telefonu</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["cep"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Şirket Adı</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["sirket_adi"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Şirket Kuruluş Tarihi</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["sirket_kurulus"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Ofis Telefonu</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["ofis_tel"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Ofis Adresi</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["ofis_adres"]."</td></tr>";
        $text.="<tr><td width='15%' colspan='3'><strong style='color:#3c8dbd'>Şirket Faaliyetleri</strong></td></tr>";
        $text.="<tr><td width='15%'><strong>İş Sektörü</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["is_sektoru"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Operasyonlar</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["operasyonlar"]."</td></tr>";
        $text.="<tr><td width='15%' colspan='3'><strong style='color:#3c8dbd'>Şirket Deneyimi</strong></td></tr>";
        $text.="<tr><td width='15%'><strong>İş Sektörü</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["is_sektoru_2"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Markalar</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["markalar"]."</td></tr>";
        $text.="<tr><td width='15%'><strong>Mağazalar</strong></td><td width='2%'>:</td><td width='width:83%'>".$veri["magazalar"]."</td></tr>";
       

        $text.="</table>";

        $text.="<a class='btn btn-primary' href='".$this->BaseAdminURL($this->modulName."/liste")."'><i class='fa fa-angle-left'></i> Geri Dön</a>";

        $text .= $form->formClose();

        $goruldu = $this->dbConn->update("temsilcilik",array('goruldu'=>1),$id);

       
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
            $ek = "WHERE ad_soyad LIKE '%".$_GET["kelime"]."%' OR sirket_adi LIKE '%".$_GET["kelime"]."%' OR email LIKE '%".$_GET["kelime"]."%'";
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

        

      $html.=$pagelist->Pagelist(array(
         'title'=> 'Temsilcilik Başvuruları ',
         'sayfaLimit'=>$sayfaLimit,
         'page'=>$this->modulName,
         //'button' => array(array('title'=>'Referans Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
         'p'=>array(
                      array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id', 'dataTur'=>"goruldu"),
                      array('dataTitle'=>'sirket_adi', 'class'=>'sort'),
                      array('dataTitle'=>'ad_soyad', 'class'=>'sort'),
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


    


     public function vitrin($id=null)
    {
        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);

        $bayiDuzenle = $this->dbConn->update($this->table,array('durum'=>$durum),$id);
        $langDuzenle = $this->dbConn->langUpdate($this->tablelang,array('durum'=>$durum),$id);
        
        if($bayiDuzenle && $langDuzenle) echo 1;else echo 0;
       
        exit();
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