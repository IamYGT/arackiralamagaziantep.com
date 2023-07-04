<?php

namespace AdminPanel;


class FiyatListesi extends Settings{

    public $SayfaBaslik = 'Fiyat Listesi';
    public  $modulName = 'FiyatListesi';
    public $icbaslik;
    private  $set;
    private $css;
    private $js;



    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

    public function index()
    {
        return 'FiyatListesi';
    }



    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        return $pagelist->Pagelist(array(
            'title'=> 'Fiyat Listesi',
            'page'=>'fiyat',
            'button' => array(array('title'=>'Fiyat Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu('select * from fiyatlistesi ORDER   BY  sira'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'60%')
            )

        ));


    }


    public function kategoriListesi($id=null)
    {
        $pagelist = new Pagelist();

        return $pagelist->Pagelist(array(
            'title'=> 'Fiyat Kategorisi Listesi',
            'page'=>'fiyatkategorisi',
            'button' => array(array('title'=>'Fiyat Kategorisi Ekle','href'=>$this->BaseAdminURL($this->modulName.'/kategoriEkle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'kategori', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/kategoriEkle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/kategoriSil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu('select * from fiyatkategorisi ORDER   BY  sira'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'60%')
            )

        ));


    }


    public function kategoriEkle($id=null)
    {

        $this->SayfaBaslik = 'Fiyat Kategorisi Listesi';

        $this->icbaslik = 'Fiyat Kategorisi Listesi';
        if(isset($id) and $id) $yazi = $this->dbConn->tekSorgu('select * from fiyatlistesi WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kategoriKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($yazi['kategori']) ? $yazi['kategori'] :'')),'title'=>'Kategori','name'=>'kategori','id'=>'kategori','help'=>'Kategori Adını buraya girebilirsiniz.'));
       // $text .= $form->input(array('value'=>((isset($yazi['fiyat']) ? $yazi['fiyat'] :'')),'title'=>'Fiyat','name'=>'fiyat','id'=>'fiyat','help'=>'Fiyatı buraya girebilirsiniz.'));
       // $text .= $form->textarea(array('value'=>((isset($yazi['aciklama']) ? $yazi['aciklama'] :'')),'title'=>'Açıklama','name'=>'aciklama','id'=>'aciklama','help'=>'Açıklamayı buraya girebilirsiniz.','height'=>'120'));
       // $text .= $form->select(array('title'=>'Kategori','name'=>'kid','data'=> $form->parent(array('sql'=>"select * from fiyatkategorisi where ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($yazi['kid'])) ? $yazi['kid'] :'')),0,0)));
        //   $text .= $form->textEditor(array('value'=>((isset($yazi['detay']) ? $this->temizle($yazi['detay']) :'')),'title'=>'Sayfa Detayı','name'=>'detay','id'=>'sayfaDetay','height' => '350'));
        //$text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'Sayfa Resmi','name'=>'SayfaResim','resimBoyut'=>$this->settings['SayfaResimResimBoyut'],'src'=>((isset($yazi['resim'])) ? $yazi['resim'] :'')));

        $this->js[] = $form->editorJS($this->BaseURL());
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;


    }


    public function ekle($id=null)
    {

        $this->SayfaBaslik = 'Fiyat Listesi';

        $this->icbaslik = 'Fiyat Listesi';
        if(isset($id) and $id) $yazi = $this->dbConn->tekSorgu('select * from fiyatlistesi WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/Kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($yazi['baslik']) ? $yazi['baslik'] :'')),'title'=>'Başlık','name'=>'baslik','id'=>'baslik','help'=>'Başlığı buraya girebilirsiniz.'));
        $text .= $form->select(array('title'=>'Kategori','name'=>'kid','data'=> $form->parent(array('sql'=>"select * from fiyatkategorisi where ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($yazi['kid'])) ? $yazi['kid'] :'')),0,0)));
        $text .= $form->input(array('value'=>((isset($yazi['fiyat']) ? $yazi['fiyat'] :'')),'title'=>'Fiyat','name'=>'fiyat','id'=>'fiyat','help'=>'Fiyatı buraya girebilirsiniz.'));
        $text .= $form->textarea(array('value'=>((isset($yazi['aciklama']) ? $yazi['aciklama'] :'')),'title'=>'Açıklama','name'=>'aciklama','id'=>'aciklama','help'=>'Açıklamayı buraya girebilirsiniz.','height'=>'120'));
     //   $text .= $form->textEditor(array('value'=>((isset($yazi['detay']) ? $this->temizle($yazi['detay']) :'')),'title'=>'Sayfa Detayı','name'=>'detay','id'=>'sayfaDetay','height' => '350'));
        //$text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'Sayfa Resmi','name'=>'SayfaResim','resimBoyut'=>$this->settings['SayfaResimResimBoyut'],'src'=>((isset($yazi['resim'])) ? $yazi['resim'] :'')));


        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;


    }

    public function kategoriKaydet($id=null)
    {


        $post = array(
            'kategori'=> $this->_POST('kategori'),
        //    'fiyat'=> $this->_POST('fiyat'),
            'tarih' =>date('m/d/Y H:i:s'),
          //  'aciklama'=>$this->kirlet($this->_POST('aciklama')),
            // 'ozet'=>$this->kirlet($this->_POST('ozet')),
            //'kid'=> $this->_POST('kid')
            // 'url'=> strtolower($this->perma($this->_POST('baslik'))),
            // 'resim' => $this->_RESIM('DuyuruResim')
        );

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update('fiyatkategorisi',$post,$id);
        else:
            // kaydet
            $this->dbConn->insert('fiyatkategorisi',$post);
        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi.html'));

    }

    public function kaydet($id=null)
    {


        $post = array(
            'baslik'=> $this->_POST('baslik'),
            'fiyat'=> $this->_POST('fiyat'),
            'tarih' =>date('m/d/Y H:i:s'),
            'aciklama'=>$this->kirlet($this->_POST('aciklama')),
           // 'ozet'=>$this->kirlet($this->_POST('ozet')),
            'kid'=> $this->_POST('kid')
           // 'url'=> strtolower($this->perma($this->_POST('baslik'))),
           // 'resim' => $this->_RESIM('DuyuruResim')
           );

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update('fiyatlistesi',$post,$id);
        else:
            // kaydet
            $this->dbConn->insert('fiyatlistesi',$post);
        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));

    }

    public function sil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM fiyatlistesi where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function kategoriSil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM fiyatkategorisi where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi.html'));
    }

}