<?php

namespace AdminPanel;


class Video extends Settings  {

    public $SayfaBaslik = 'Video Listesi';
    public  $modulName = 'Video';
    public  $icbaslik ;
    private $js = array();
    private $css = array();
    private $siteURL;
    private $set;


    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->siteURL = $this->BaseAdminURL();
        $this->set = $settings;
        $this->AuthCheck();
    }

    public function index()
    {

    }


    public function ekle($id=null)
    {
        $this->icbaslik = 'Video Ekle';

        $form = new Form($this->set);
        if(isset($id) and $id) $data = $this->dbConn->tekSorgu('select * from videolar WHERE id='.$id);

        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));




            $text .= $form->input(array('value'=>((isset($data['adres']) ? $data['adres'] :'')),'title'=>'Video Adresi','id'=>'adres','help'=>' Vimeo , Youtube , Dailymotion , İzlesene , Vidivodo, Metacafe , Facebook, Vine, Twitch, Hürriyet TV ,Milli Gazete, Haber 7, İzleyin.com ,Mynet , Sabah , Akşam , Habertürk, Sözcü, Sinemalar, Beyazperde  sitelerinden otomatik veri çekilebilmektedir','name'=>'adres', 'lang'=>'tr', 'button'=>array('id'=>'verial','text'=>'Veri Al')));
            $text .= $form->input(array('value'=>((isset($data['baslik']) ? $data['baslik'] :'')),'title'=>'Video Başlığı','name'=>'baslik_tr','id'=>'baslik_tr','help'=>''));
            $text .= $form->textarea(array('value'=>((isset($data['ozet']) ? $data['ozet'] :'')),'title'=>'Açıklama','name'=>'ozet_tr','id'=>'ozet_tr','help'=>'Açıklamayı buraya girebilirsiniz.','height'=>'120'));
            $text .= $form->textarea(array('value'=>((isset($data['embed']) ? $data['embed'] :'')),'title'=>'Embed Kodu','name'=>'embed_tr','id'=>'embed_tr','help'=>'','height'=>'120'));
            $text .= $form->input(array('value'=>((isset($data['videoresim']) ? $data['videoresim'] :'')),'image'=>true,'title'=>'Video Resmi','name'=>'videoResim_tr','id'=>'videoResim_tr','help'=>''));


        $text .= $form->file(array('url'=>$this->BaseURL("upload").'/videolar','folder'=>'videolar','title'=>'Resim','name'=>'VideoGenelResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('haber'),'src'=>((isset($data['resim'])) ? $data['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));


        return $text;



    }


    public function kaydet($id=null)
    {
            $dil = "tr";


            $post = array(
                'adres'=> $this->_POST('adres',$dil),
                'baslik'=> $this->_POST('baslik',$dil),
                'videoresim'=> $this->_POST('videoResim',$dil),
                'tarih' =>date('m/d/Y H:i:s'),
                'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                'embed'=>$this->kirlet($this->_POST('embed',$dil)),
                'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),
                'dil'=>$dil,
                // 'kid'=> $this->_POST('kid',$dil),
                'url'=> strtolower($this->permalink($this->_POST('baslik',$dil))),
                'resim' => $this->_RESIM('VideoGenelResim_tr'));


        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update('videolar',$post,$id);

        else:
            // kaydet
            $this->dbConn->insert('videolar',$post,$id);

        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function sil($id=null)
    {
        if($id) $this->dbConn->sil("DELETE FROM videolar where masterid='$id' or id=".$id);
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
            'title'=> 'Video Listesi',
            'page'=>'video',
            'button' => array(array('title'=>'Video Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu('select * from videolar where masterid=0 order by  sira'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%')
            )

        ));


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


    }

}
