<?php


namespace AdminPanel;


class Sayfa  extends Settings{

    public $SayfaBaslik = 'Yazılar';
    public  $modulName = 'Sayfa';
    private $module = "sayfa";
    private $ktable = "sayfakategori";
    private $ktablelang = "sayfakategori_lang";
    private $table = "yazilar";
    private $tablelang = "yazilar_lang";

    public $icbaslik;
    private $css;
    private $js;



    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

    public function index()
    {
        return 'Anasayfa';
    }




    public function kategoriEkle($id=null)
    {
        $this->icbaslik = 'Sayfa Kategorisi Ekle';
        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from sayfakategori WHERE id='.$id);
        $text = '';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text.=$form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=>  $this->BaseAdminURL($this->modulName.'/kategoriKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        if($id) $data = $tabs->tabData('sayfakategori',$id);

        foreach ($this->settings->lang('lang') as $dil=>$title):

            $tabForm[$dil]['text'] = $form->input(array('value'=>((isset($data[$dil]['kategori']) ? $data[$dil]['kategori'] :'')),'title'=>'Sayfa Kategorisi Başlık','name'=>'baslik','id'=>'baslik','lang'=>$dil,'help'=>''));
        endforeach;


        $text .= $tabs->tabContent($tabForm);

        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;

    }


    public function kategoriListesi($id=null) //Kategori liste
    {
        $this->icbaslik = 'Kategori Listesi';

        $pagelist = new Pagelist($this->settings);

        return $pagelist->PageList(array(
            'title'=> 'Kategori Listesi',
            'icbaslik' => $this->icbaslik,
            'page'=>'urunGrubu',
            'button' => array(array('title'=>'Kategori Ekle','href'=> $this->BaseAdminURL($this->modulName.'/kategoriEkle.html'),'color'=>'red')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'kategori', 'class'=>'sort')
            ),
            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/kategoriEkle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/kategorisil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from sayfakategori ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%')
            )

        ));

    }


    public function Sayfaliste($id=null)
    {

        $this->SayfaBaslik = 'Sayfalar';
        $pagelist = new PageList($this->settings);

        return $pagelist->PageList(array(
            'title'=> 'Sayfalar',
            'flitpage' => array('title'=>'Kategori Seç','sql'=> "select * from sayfakategori where ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu'),
            'id'=>$id,
            'page'=>'Sayfa',
            'button' => array(array('title'=>'Sayfa Ekle','href'=>$this->BaseAdminURL($this->modulName.'/Sayfaekle.html'),'color'=>'red')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),

            'tools' =>array(   array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/Sayfaekle/'),'color'=>'blue'),
                               array('title'=>'Sil','icon'=>'fa fa-edit','url'=>
							   $this->BaseAdminURL($this->modulName.'/SayfaSil/'),'color'=>'red')),
            'buton'=> array(array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','dataname'=>'fotoekle','url'=>$this->BaseAdminURL($this->modulName.'/fotoekle/'))
            ),
            'pdata' => $this->dbConn->sorgu("select * from yazilar  ".(($id) ? "where kid='$id'":null)."  ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%'),
                array('title'=>'Resim Ekle','width'=>'5%'),
              
            )
        ));
    }

    public function Sayfaekle($id=null)
    {
        $this->SayfaBaslik = 'Sayfalar';
        $this->icbaslik = 'Sayfa Ekle';
        $text = '';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/SayfaKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        if($id) $data = $tabs->tabData('yazilar',$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']  = $form->input(array('value'=>((isset($data[$dil]['baslik']) ? $this->temizle($data[$dil]['baslik']) :'')),'title'=>'Sayfa Başlığı','lang'=>$dil,'name'=>'baslik','id'=>'baslik','help'=>'Sayfa başlığını buraya girebilirsiniz.'));
            $tabForm[$dil]['text'] .= $form->textarea(array('value'=>((isset($data[$dil]['ozet']) ? $this->temizle($data[$dil]['ozet']) :'')),'title'=>'Özet','lang'=>$dil,'name'=>'ozet','id'=>'baslik','help'=>'Özeti buraya girebilirsiniz.','height'=>'120'));
     //       $tabForm[$dil]['text'] .= $form->select(array('title'=>'Sayfa Kategorisi','name'=>'kid','lang'=>$dil,'data'=> $form->parent(array('sql'=>"select * from sayfakategori where ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($data['tr']['kid'])) ? $data['tr']['kid'] :'')),0,0)));
            $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay']) ? $this->temizle($data[$dil]['detay']) :'')),'title'=>'Sayfa Detayı','name'=>'detay','lang'=>$dil,'id'=>'sayfaDetay','height' => '350'));
        endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->select(array('title'=>'Sayfa Kategorisi','name'=>'kid','lang'=>'tr','data'=> $form->parent(array('sql'=>"select * from sayfakategori where ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($data['tr']['kid'])) ? $data['tr']['kid'] :'')),0,0)));
        $text .= $form->file(array('url'=>$this->BaseURL('upload')."/sayfa",'folder'=>'sayfa','title'=>'Sayfa Resmi','lang'=>'tr','name'=>'SayfaResim','resimBoyut'=>$this->settings->boyut('sayfa'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();


        return $text;


    }

    public function kategoriKaydet($id=null)// Kategori Kaydet
    {
        foreach ($this->settings->lang('lang') as $dil=>$title):
            if($dil == 'tr'):

                $post[$dil] = array(
                    'kategori'=> $this->_POST('baslik',$dil),
                    'dil'=>$dil
                );
            else:
                $post[$dil] = array(
                    'kategori'=> $this->_POST('baslik',$dil),
                    'dil'=>$dil
                );

            endif;
        endforeach;

        if(isset($id) and $id):

            //Güncelle

            $this->dbConn->update($this->ktable,$post['tr'],$id);
            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    if(count($this->dbConn->sorgu("select * from ".$this->ktablelang." where dil='".$dil."' and master_id='".$id."' "))==1)

                        $this->dbConn->update($this->ktablelang, $post[$dil],array('master_id'=>$id,'dil'=>$dil));

                    else

                        $this->dbConn->insert($this->ktablelang,array_merge($post[$dil],array('master_id'=>$id)));

                }

            endforeach;

        else:

            // kaydet

            $this->dbConn->insert($this->ktable,$post['tr'],$id);

            $lastid = $this->dbConn->lastid();
            $this->FileSessionSave($lastid,$this->module);

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    $this->dbConn->insert($this->ktablelang, array_merge($post[$dil], array('master_id' => $lastid)));

                }

            endforeach;

        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));


    }




    public function SayfaKaydet($id=null)
    {
        $table = "yazilar";

        foreach ($this->settings->lang('lang') as $dil=>$title):

            if($dil == "tr"):
                $post[$dil] = array(
                    'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                    'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                    'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),
                    'resim' => $this->_RESIM('SayfaResim_tr'),
                    //   'banner' => $this->_RESIM('BannerResim_tr'),
                    'dil' => $dil,
                    'kid'=>($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0
                );
            else:
                $post[$dil] = array(
                    'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                    'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                    'url'=> strtolower($this->permalink($this->_POST('baslik',$dil))),
                    'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),
                    'dil' => $dil,
                    'kid'=>($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0
                );

            endif;

        endforeach;

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update($table,$post['tr'],$id);
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {
                    if(count($this->dbConn->sorgu("select lang_id from ".$table."_lang where dil='$dil'  and master_id='$id' "))==1)
                        $this->dbConn->update($table."_lang", $post[$dil], array('master_id' => $id,'dil'=>$dil));
                    else
                        $this->dbConn->insert($table."_lang",array_merge($post[$dil],array('master_id'=>$id)));
                }
            endforeach;

        else:
            // kaydet
            $this->dbConn->insert($table,$post['tr'],$id);
            $lastid = $this->dbConn->lastid();
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') $this->dbConn->insert($table."_lang",array_merge($post[$dil],array('dil'=>$dil,'master_id'=>$lastid)));
            endforeach;
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/Sayfaliste'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));
    }


    public function fotoekle($id=0)
    {


        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from '.$this->table.' WHERE id='.$id);

        $baslik = $this->permalink($this->temizle($urun["baslik"]));

        $this->icbaslik = 'Resim Ekle';

        $pagelist = new Pagelist($this->settings);

        return $pagelist->Fotolist(array(
            'title'=> 'Resim Listesi (min: 290 x 290 Resim Ekleyiniz )',
            'icbaslik' => $this->icbaslik,
            'id'=>$id,
            'page'=>'dosyalar',
            'pfolder'=>'../'.$this->settings->config('folder').$this->module."/",
        //    'button' => array(array('title'=>'Fotograf Ekle','href'=> $this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'dosya', 'class'=>'sort')
            ),
            'tools' =>array(
                array('title'=>'Düzenle','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/fotoduzenle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/fotosil/'),'color'=>'red')),
            'yukle'=> array('type'=>'button','title'=>'Resim Ekle','class'=>'btn btn-danger','modul'=>$this->module,'folder'=>'../'.$this->settings->config('folder').$this->module."/",'name'=>((isset($baslik)) ? $baslik:null)),

            'buton'=> array(
                //array('type'=>'radio','dataname'=>'durum','url'=>$this->BaseAdminURL($this->modulName.'/durum/')),
            ),
            'pdata' => $this->dbConn->sorgu("select * from dosyalar where type='$this->module' and data_id='$id' ORDER  BY  sira"),
            'baslik'=>array(
                array('title'=>'Sıra No','width'=>'4%'),
                array('title'=>'Resim','width'=>'80%'),
             //   array('title'=>'Aktif','width'=>'5%'),
             //   array('title'=>'Resimler','width'=>'8%'),

            )

        ));

    }

    public function fotosil($id=null)
    {
        $rec2 = $this->dbConn->tekSorgu("SELECT * FROM dosyalar WHERE id='$id'");
        $resim2= $this->resimGet($rec2["dosya"]);
        $kid = $rec2['data_id'];
        $this->ResimSil($resim2,"../".$this->settings->config('folder').$this->module."/"); // Eski resmi sil
        if($id) $this->dbConn->sil('DELETE FROM dosyalar where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/fotoekle/'.$kid));
    }


    public function fotoduzenle($id=null)
    {

        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from dosyalar WHERE id='.$id);
        $text = '';
         $this->icbaslik = 'Resim Düzenle';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=>  $this->BaseAdminURL($this->modulName.'/fotokaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($urun['baslik']) ? $urun['baslik'] :'')),'title'=>' <img src="https://cdn.vemedya.com/admin/assets/flags/tr.png" width="25px" style="margin-right:10px;">Başlık','name'=>'baslik','id'=>'baslik','help'=>''));
        $text .= $form->input(array('value'=>((isset($urun['baslik_en']) ? $urun['baslik_en'] :'')),'title'=>' Başlık','name'=>'baslik','id'=>'baslik','help'=>'', 'lang'=>"en"));
        $text .= $form->input(array('value'=>((isset($urun['baslik_ru']) ? $urun['baslik_ru'] :'')),'title'=>' Başlık','name'=>'baslik','id'=>'baslik','help'=>'', 'lang'=>"ru"));
        $text .= $form->input(array('value'=>((isset($urun['baslik_ar']) ? $urun['baslik_ar'] :'')),'title'=>' Başlık','name'=>'baslik','id'=>'baslik','help'=>'', 'lang'=>"ar"));
      //$text .= $form->textarea(array('value'=>((isset($yazi['detay']) ? $yazi['detay'] :'')),'title'=>'Açıklama','name'=>'ozet','id'=>'ozet','help'=>'','height'=>'120'));
        $text .= $form->file(array('url'=>$this->BaseURL('upload')."/".$this->module,'folder'=>$this->module,'title'=>'Resim','name'=>'fotoResim','resimBoyut'=>$this->settings->boyut('urun'),'src'=>((isset($urun['dosya'])) ? $urun['dosya'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        return $text;
    }

    public  function fotokaydet($id=null)
    {

        $post = array(
            'baslik'=> $this->_POST('baslik'),
            'baslik_en'=> $this->_POST('baslik_en'),
            'baslik_ru'=> $this->_POST('baslik_ru'),
            'baslik_ar'=> $this->_POST('baslik_ar'),
            //'detay'=>$this->kirlet($this->_POST('detay')),
            //'ustu'=> $this->_POST('kid'),
            //'url'=> strtolower($this->perma($this->_POST('baslik'))),
            'dosya' => $this->_RESIM('fotoResim'));

        // Güncelle
        if(isset($id) and $id):
            $this->dbConn->update('dosyalar',$post,$id);

        endif;
        $fotoid = $this->dbConn->tekSorgu("select * from dosyalar where id='$id'");
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/fotoekle/'.$fotoid['data_id']));
    }


    public function SayfaSil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM yazilar where id='.$id);
		if($id) $this->dbConn->sil('DELETE FROM yazilar_lang where master_id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/Sayfaliste.html'));
    }

    public function kategorisil($id=null) // Kategori Sil
    {
        if($id) $this->dbConn->sil('DELETE FROM sayfakategori where id='.$id);
        if($id) $this->dbConn->sil('DELETE FROM sayfakategori_lang where master_id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi.html'));
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
