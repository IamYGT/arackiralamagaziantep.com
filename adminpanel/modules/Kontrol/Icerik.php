<?php


namespace AdminPanel;


class Icerik  extends Settings{

    public $SayfaBaslik = 'Yazılar';
    public  $modulName = 'Icerik';
    private $siteURL;
    public $icbaslik;
    private  $set;
    private $css;
    private $js;



    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->siteURL = $this->GetSettings('url').$this->GetSettings('adminfolder');
        $this->set = $settings;
        $this->AuthCheck();
    }

    public function index()
    {
        return 'Anasayfa';
    }


    public function Yaziliste($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        return $pagelist->PageList(array(
            'title'=> 'Yazılar',
            'page'=>'Yazi',
            'button' => array(array('title'=>'Yazı Ekle','href'=>$this->BaseAdminURL($this->modulName.'/Yaziekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/Yaziekle/'),'color'=>'blue'),
                             array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/YaziSil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from yazilar where  type='yazi' ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%')
            )

        ));

    }

    public function Sayfaliste($id=null)
    {
        $this->SayfaBaslik = 'Sayfalar';
        $pagelist = new Pagelist($this->settings);

        return $pagelist->PageList(array(
            'title'=> 'Sayfalar',
            'page'=>'Sayfa',
            'button' => array(array('title'=>'Sayfa Ekle','href'=>$this->BaseAdminURL($this->modulName.'/Sayfaekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(   array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/Sayfaekle/'),'color'=>'blue'),
                               array('title'=>'Sil','icon'=>'fa fa-edit','url'=>
							   $this->BaseAdminURL($this->modulName.'/SayfaSil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from yazilar where  type='sayfa' ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%')
            )

        ));
    }

    public function Sayfaekle($id=null)
    {

        $this->SayfaBaslik = 'Sayfalar';

        $this->icbaslik = 'Sayfa Ekle';
        if(isset($id) and $id) $yazi = $this->dbConn->tekSorgu('select * from yazilar WHERE id='.$id);
        $text = '';
        $form = new Form($this->set);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/SayfaKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($yazi['baslik']) ? $yazi['baslik'] :'')),'title'=>'Sayfa Başlığı','name'=>'baslik','id'=>'baslik','help'=>'Sayfa başlığını buraya girebilirsiniz.'));
        $text .= $form->textarea(array('value'=>((isset($yazi['ozet']) ? $yazi['ozet'] :'')),'title'=>'Özet','name'=>'ozet','id'=>'baslik','help'=>'Özeti buraya girebilirsiniz.','height'=>'120'));
        $text .= $form->select(array('title'=>'Sayfa Kategorisi','name'=>'kid','data'=> $form->parent(array('sql'=>"select * from sayfakategori where type='sayfa' and ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($yazi['kid'])) ? $yazi['kid'] :'')),0,0)));
        $text .= $form->textEditor(array('value'=>((isset($yazi['detay']) ? $this->temizle($yazi['detay']) :'')),'title'=>'Sayfa Detayı','name'=>'detay','id'=>'sayfaDetay','height' => '350'));
        $text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'Sayfa Resmi','name'=>'SayfaResim','resimBoyut'=>$this->settings['SayfaResimResimBoyut'],'src'=>((isset($yazi['resim'])) ? $yazi['resim'] :'')));


        $text .= $form->submitButton();
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;


    }


    public function Yaziekle($id=null)
    {



        $this->icbaslik = 'Yazı Ekle';
        if(isset($id) and $id) $yazi = $this->dbConn->tekSorgu('select * from yazilar WHERE id='.$id);
        $text = '';
        $form = new Form($this->set);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/YaziKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($yazi['baslik']) ? $yazi['baslik'] :'')),'title'=>'Yazı Başlığı','name'=>'baslik','id'=>'baslik','help'=>'Yazı başlığını buraya girebilirsiniz.'));
    //    $text .= $form->textarea(array('value'=>((isset($yazi['ozet']) ? $yazi['ozet'] :'')),'title'=>'Özet','name'=>'ozet','id'=>'baslik','help'=>'Özeti buraya girebilirsiniz.','row'=>'30'));
        $text .= $form->select(array('title'=>'Yazı Kategorisi','name'=>'kid','data'=> $form->parent(array('sql'=>"select * from sayfakategori where type='yazi' and ",'option'=>array('value'=>'id','title'=>'kategori','select'=>'kid'),'kat'=>'ustu','selected'=>((isset($yazi['kid'])) ? $yazi['kid'] :'')),0,0)));
        $text .= $form->textEditor(array('value'=>((isset($yazi['detay']) ? $this->temizle($yazi['detay']) :'')),'title'=>'Yazı Detayı','name'=>'detay','id'=>'yaziDetay','height' => '350'));
        $text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'Yazı Resmi','name'=>'YaziResim','resimBoyut'=>$this->settings['YaziResimResimBoyut'],'src'=>((isset($yazi['resim'])) ? $yazi['resim'] :'')));


        $this->js[] = $form->editorJS($this->BaseURL());
        $text .= $form->submitButton();
        $text .= $form->formClose();
        return $text;


    }


    public function YaziKaydet($id=null)
    {

        $post = array(
            'baslik'=> $this->_POST('baslik'),
            //'tarih' =>date('d/m/Y H:i:s'),
            'detay'=>$this->kirlet($this->_POST('detay')),
//            'ozet'=>$this->kirlet($this->_POST('ozet')),
            'type' =>'yazi',
            'kid'=> $this->_POST('kid'),
            'url'=> strtolower($this->permalink($this->_POST('baslik'))),
            'resim' => $this->_RESIM('YaziResim'));

         // Güncelle
        if(isset($id) and $id):
            $this->dbConn->update('yazilar',$post,$id);
        // kaydet
        else:
            $this->dbConn->insert('yazilar',$post);
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/Yaziliste.html'));



    }


    public function SayfaKaydet($id=null)
    {


        $post = array(
            'baslik'=> $this->_POST('baslik'),
            //'tarih' =>date('d/m/Y H:i:s'),
            'detay'=>$this->kirlet($this->_POST('detay')),
            'ozet'=>$this->kirlet($this->_POST('ozet')),
            'type' =>'sayfa',
            'kid'=> $this->_POST('kid'),
            'url'=> strtolower($this->permalink($this->_POST('baslik'))),
            'resim' => $this->_RESIM('SayfaResim'));

		 // Güncelle
        if(isset($id) and $id):
            $this->dbConn->update('yazilar',_POST['ozet'],$post,$id);
        // kaydet
        else:
            $this->dbConn->insert('yazilar',$post);
        endif;
        
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/Sayfaliste.html'));

    }


    public function SayfaSil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM yazilar where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/Sayfaliste.html'));
    }
    public function YaziSil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM yazilar where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/Yaziliste.html'));
    }



    public function CustomPageCss($url)
    {
        // Sadece bu sayfa için gerekli Stil dosyaları eklenebilir
        $text = '';
      if(is_array($this->css))
       foreach($this->css as $css) $text .= $css;
        return $text;

    }


    public function CustomPageJs($url)
    {
        // Sadece bu sayfa için gerekli javascript dosyaları eklenebilir
        $text = '';
        if(is_array($this->js))
        foreach($this->js as $js) $text .= $js;
        return $text;
    }


}