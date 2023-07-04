<?php
namespace AdminPanel;

use AdminPanel\Form;

class Siparisler extends Settings  {

    public $SayfaBaslik = 'Siparişler';
    public $modulName = 'Siparisler';
    public $icbaslik ;
    private  $table ='siparisler';


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
        $this->icbaslik = 'Popup Ekle';
        if(isset($id) and $id) $data = $this->dbConn->tekSorgu('select * from '.$this->table.' WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($data['link']) ? $data['link'] :'')),'title'=>'Popup Başlık','name'=>'link','id'=>'baslik','help'=>''));
        //$text .= $form->link(array('value'=>((isset($data['link']) ? $data['link'] :'')),'title'=>'Link','name'=>'link','id'=>'link','help'=>'Yönlendirilecek Adres'));
        //$text .= $form->input(array('value'=>((isset($data['video']) ? $data['video'] :'')),'title'=>'Video Url','name'=>'video','id'=>'video','help'=>'Sadece Video Eklemek İsteseniz Adresi Buraya Giriniz. Video Eklerseniz resim görüntülenmeyecektir. Örn(https://www.youtube.com/watch?v=-_PErWdXkKs)'));
        //$text .= $form->date(array('value'=>((isset($data['tarih']) ? date('d-m-Y',$data['tarih']) :date('d-m-Y'))),'title'=>'Bitiş Tarihi','name'=>'tarih','id'=>'tarih','help'=>''));
        //  $text .= $form->textEditor(array('value'=>((isset($haber['detay']) ? $haber['detay'] :'')),'title'=>'Haber Detayı','name'=>'detay','id'=>'haberDetay','height' => '350'));
        //$text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'Popup Resim','name'=>'popupResim','resimBoyut'=>$this->settings->boyut('popup'),'src'=>((isset($data['resim'])) ? $data['resim'] :'')));
        $text .= $form->submitButton();
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;


    }



    public function kaydet($id=null)
    {

        $post = array(
            'baslik'=> $this->_POST('baslik'),
            'resim' => $this->_RESIM('popupResim'),
            'link' => $this->_POST('link'),
            'video' => $this->_POST('video'),
            'tarih' => strtotime($this->_POST('tarih')),
        );

        if(isset($id) and $id):
            $this->dbConn->update($this->table,$post,$id);
        else:
            $this->dbConn->insert($this->table,$post);
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));


    }

    public function sil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM '.$this->table.' where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }
    /**
     * @param null $id
     * @return string
     */


    public function liste($id=null)
    {

        $pagelist = new Pagelist($this->settings);

        return $pagelist->Pagelist(array(
            'title'=> 'Sipariş Listesi',
            'page'=>'Popup',
            //'button' => array(array('title'=>'Popup Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'link', 'class'=>'sort'),
                array('dataTitle'=>'fiyat', 'class' => 'sort'),
                array('dataTitle'=>'kargo', 'class' => 'sort'),
                array('dataTitle'=>'tur', 'class' => 'sort'),
                array('dataTitle'=>'beden', 'class' => 'sort'),
                array('dataTitle'=>'renk', 'class' => 'sort'),
                array('dataTitle'=>'aciklama', 'class' => 'sort'),
                array('dataTitle'=>'secim', 'class' => 'sort'),
                array('dataTitle'=>'birlestirme', 'class' => 'sort'),
                array('dataTitle'=>'kontrol', 'class' => 'sort'),
                array('dataTitle'=>'sigorta', 'class' => 'sort'),
                array('dataTitle'=>'uye_id', 'class' => 'sort'),
            ),

            'tools' =>array(array('title'=>'Detayı','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
               //'tools' =>array(array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
              //'buton'=> array(array('type'=>'radio', 'icon'=>'fa fa-home' ,'url'=>$this->BaseAdminURL($this->modulName.'/durum/'))),
             //'pdata' => $this->dbConn->sorgu('select * from uyelik where id'),
            'pdata' => $this->dbConn->sorgu('select * from '.$this->table.' ORDER BY id'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'3%'),
                array('title'=>'link','width'=>'8%'),
                array('title'=>'fiyat','width'=>'8%'),
                array('title'=>'kargo','width'=>'8%'),
                array('title'=>'tur','width'=>'8%'),
                array('title'=>'beden','width'=>'8%'),
                array('title'=>'renk','width'=>'8%'),
                array('title'=>'aciklama','width'=>'8%'),
                array('title'=>'secim','width'=>'8%'),
                array('title'=>'birlestirme','width'=>'8%'),
                array('title'=>'kontrol','width'=>'8%'),
                array('title'=>'sigorta','width'=>'8%'),
                array('title'=>'uyeid','width'=>'8%'),
            )
        ));
    }
}
