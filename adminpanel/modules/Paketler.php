<?php


namespace AdminPanel;


class Paketler extends Settings {

    public   $SayfaBaslik = 'Paketler';
    public   $modulName = 'Paketler';
    private  $css;
    private  $js = array();


    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

    //// Ekle   ////
    public function ekle($id=null)
    {



        $this->icbaslik = 'Paket Ekle';
        $text = '';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        if($id) $data = $tabs->tabData('select * from paketler',$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
             $tabForm[$dil]['text'] = $form->input(array('value'=>((isset($data[$dil]['baslik'])) ? $data[$dil]['baslik'] :''),'title'=>'Paket Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));
              $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['fiyat'])) ? $data[$dil]['fiyat'] :''),'title'=>'Fiyat','name'=>'fiyat','id'=>'fiyat','help'=>'','lang'=>$dil));
             $tabForm[$dil]['text'] .= $form->select(array('title'=>'Paket Gruplarımız','name'=>'kid','lang'=>$dil,'data'=> $form->parent(array('sql'=>"select * from gruplar where masterid=0  ",'option'=>array('value'=>'id','title'=>'baslik'),'lang'=>$dil,'selected'=> ((isset($data['tr']['kid'])) ? $data['tr']['kid'] :0) ),0,0)));
         //  $tabForm[$dil]['text'] .= $form->select(array('title'=>'Markalar','name'=>'marka','data'=> $form->parent(array('sql'=>"select * from markalar where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','lang'=>$dil,'selected'=> ((isset($data[$dil]['marka'])) ? $data[$dil]['marka'] :0) ),0,0)));
         //  $tabForm[$dil]['text'] .= $form->selectmulti(array('title'=>'Sektörler','name'=>'sektor','data'=> $form->parent(array('sql'=>"select * from sektorler where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','lang'=>$dil,'selected'=> ((isset($data[$dil]['sektor'])) ? $data[$dil]['sektor'] :0) ),0,0)));
          $tabForm[$dil]['text'] .= $form->selectmulti(array('title'=>'Özellik','lang'=>$dil,'name'=>'ozellik','data'=> $form->parent(array('sql'=>"select * from ozellik ",'option'=>array('value'=>'id','title'=>'baslik'),'selected'=> ((isset($data[$dil]['ozellik'])) ? $data[$dil]['ozellik'] :0) ),0,0)));
           //  $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay']) ? $data[$dil]['detay'] :'')),'title'=>'Ürün Detayı','name'=>'detay','id'=>'haberDetay','height' => '200','lang'=>$dil));
         //  $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['ozet']) ? $data[$dil]['ozet'] :'')),'title'=>'Teknik Özellikler','name'=>'ozet','id'=>'baslik','help'=>'','height'=>'120','lang'=>$dil));
         //  $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['teknik']) ? $data[$dil]['teknik'] :'')),'title'=>'Teknik Değerler','name'=>'teknik','id'=>'haberteknik','height' => '200','lang'=>$dil));
         //    $tabForm[$dil]['text'] .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Ürün Resmi','name'=>'UrunResim','lang'=>$dil,'resimBoyut'=>$this->settings->boyut('urun'),'src'=>((isset($data[$dil]['resim'])) ? $data[$dil]['resim'] :'')));

        endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;

    }



    public function  ozellikekle($id=null)
    {

        $this->icbaslik = 'Özellik Ekle';
        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from ozellik WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=> $this->BaseAdminURL($this->modulName.'/ozellikkaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->selectmulti(array('title'=>'Paket Grubu','name'=>'gruplar','data'=> $form->parent(array('sql'=>"select * from gruplar where masterid=0 ",'option'=>array('value'=>'id','title'=>'baslik'),'selected'=> ((isset($urun['gruplar']) ? $urun['gruplar'] :'')) ),0,0)));
        $text .= $form->input(array('value'=>((isset($urun['baslik']) ? $urun['baslik'] :'')),'title'=>'Başlık','name'=>'baslik','id'=>'baslik','help'=>''));
        $text .= $form->textarea(array('value'=>((isset($urun['detay']) ? $urun['detay'] :'')),'title'=>'Detay','name'=>'detay','id'=>'detay','help'=>'','height'=>'120'));

        //  $text .= $form->select(array('title'=>'Ürünler','name'=>'kid','data'=> $form->parent(array('sql'=>"select * from urunler where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'kid','selected'=> ((isset($urun['kid'])) ? $urun['kid'] :0) ),0,0)));
        // $text .= $form->textEditor(array('value'=>((isset($urun['detay']) ? $urun['detay'] :'')),'title'=>'Ürün Detayı','name'=>'detay','id'=>'haberDetay','height' => '200'));
       // $text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'İkon','name'=>'ozellikResim','resimBoyut'=>$this->settings->boyut('ozellik'),'src'=>((isset($urun['resim'])) ? $urun['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        return $text;

    }
    public function  sektorekle($id=null)
    {

        $this->icbaslik = 'Sektör Ekle';
        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from sektorler WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=> $this->BaseAdminURL($this->modulName.'/sektorkaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($urun['baslik']) ? $urun['baslik'] :'')),'title'=>'Sektör Başlığı','name'=>'baslik','id'=>'baslik','help'=>''));
        $text .= $form->select(array('title'=>'Ürün Kategorisi','name'=>'kid','data'=> $form->parent(array('sql'=>"select * from kategoriler where ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=> ((isset($urun['kid'])) ? $urun['kid'] :0) ),0,0)));
      //  $text .= $form->textarea(array('value'=>((isset($yazi['ozet']) ? $yazi['ozet'] :'')),'title'=>'Özet','name'=>'ozet','id'=>'baslik','help'=>'','height'=>'120'));
        $text .= $form->textEditor(array('value'=>((isset($urun['detay']) ? $urun['detay'] :'')),'title'=>'Sektör Detayı','name'=>'detay','id'=>'haberDetay','height' => '200'));
        $text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'Sektör Resmi','name'=>'sektorResim','resimBoyut'=>$this->settings->boyut('urun'),'src'=>((isset($urun['resim'])) ? $urun['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        return $text;

    }


    public function kategoriEkle($id=null)
    {

        $this->icbaslik = 'Paket Grubu Ekle';
        $text = '';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=>  $this->BaseAdminURL($this->modulName.'/kategoriKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        if($id) $data = $tabs->tabData('select * from gruplar',$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']  =  $form->input(array('value'=>((isset($data[$dil]['baslik'])) ? $data[$dil]['baslik'] :''),'title'=>'Paket Grubu Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  .=  $form->input(array('value'=>((isset($data[$dil]['fiyat'])) ? $data[$dil]['fiyat'] :''),'title'=>'Fiyat','name'=>'fiyat','id'=>'fiyat','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  .= $form->selectmulti(array('title'=>'Platformlar','lang'=>$dil,'name'=>'platform'
            ,'data'=> $form->parent(array('array'=>array(
                    array('id'=>'web','text'=> 'Web'),
                    array('id'=>'mobil','text'=> 'Mobil'),
                    array('id'=>'android','text'=> 'Android'),
                    array('id'=>'ios','text'=> 'ios'),

                ),
                    'option'=>array('value'=>'id','title'=>'text'),'selected'=>((isset($data[$dil]['platform'])) ? $data[$dil]['platform'] :'')),
                    0,0)));

            //   $tabForm[$dil]['text'] .= $form->select(array('title'=>'Ürün Grubu','name'=>'kid','lang'=>$dil,'data'=> $form->parent(array('sql'=>"select * from kategoriler where masterid=0 and  ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($data['tr']['ustu'])) ? $data['tr']['ustu']:0)),0,0)));
            $tabForm[$dil]['text'] .= $form->textarea(array('value'=>((isset($data[$dil]['slogan'])) ? $data[$dil]['slogan'] :''),'title'=>'Slogan','name'=>'slogan','id'=>'slogan','height' => '60','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->textarea(array('value'=>((isset($data[$dil]['detay'])) ? $data[$dil]['detay'] :''),'title'=>'Ürün Grubu Detayı','name'=>'detay','id'=>'haberDetay','height' => '250','lang'=>$dil));
          //  $tabForm[$dil]['text'] .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Ürün Grubu Resmi','name'=>'kategoriResim','lang'=>$dil,'resimBoyut'=>$this->settings->boyut('urunKategori'),'src'=>((isset($data[$dil]['resim'])) ? $data[$dil]['resim'] :'')));

        endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;

    }

    //// Kaydet  ////
    public function kaydet($id=null) // Ürün Kaydet
    {
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $post[$dil] = array(
                'baslik'=> $this->_POST('baslik_'.$dil),
              //  'ozet'=> $this->_POST('ozet',$dil),
             //   'marka'=> $this->_POST('marka',$dil),
               // 'sektor'=> $this->arraytojson($this->_POST('sektor',$dil)),
                'ozellik'=> $this->arraytojson($this->_POST('ozellik',$dil)),

                'fiyat'=> $this->_POST('fiyat',$dil),
               // 'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                'kid'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,
                'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),
               // 'resim' => $this->_RESIM('UrunResim_'.$dil)

            );
        endforeach;

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update('paketler',$post['tr'],$id);
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {
                    if(count($this->dbConn->sorgu("select * from paketler where dil='$dil'  and masterid='$id' "))==1)
                        $this->dbConn->update('paketler', $post[$dil], array('dil' =>$dil, 'masterid' => $id));
                    else
                        $this->dbConn->insert('paketler',array_merge($post[$dil],array('masterid'=>$id)));
                }
            endforeach;

        else:
            // kaydet
            $this->dbConn->insert('paketler',$post['tr'],$id);
            $lastid = $this->dbConn->lastid();
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') $this->dbConn->insert('paketler',array_merge($post[$dil],array('dil'=>$dil,'masterid'=>$lastid)));
            endforeach;
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));

    }


    public function  markakaydet($id=null)// Marka Kaydet
    {

        $post = array(
            'baslik'=> $this->_POST('baslik'),
            //  'detay'=>$this->kirlet($this->_POST('detay')),
            'ustu'=> $this->_POST('kid'),
            'url'=> strtolower($this->perma($this->_POST('baslik'))),
            'resim' => $this->_RESIM('markaResim'));
        if(isset($id) and $id):
            $this->dbConn->update('markalar',$post,$id);
        // kaydet
        else:
            $this->dbConn->insert('markalar',$post);
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/marka.html'));

    }
    public function  ozellikkaydet($id=null)// Özellik Kaydet
    {

        $post = array(
            'baslik'=> $this->_POST('baslik'),
            'detay'=>$this->kirlet($this->_POST('detay')),
            'gruplar'=> $this->arraytojson($this->_POST('gruplar')),
            'url'=> strtolower($this->perma($this->_POST('baslik'))),
            //'resim' => $this->_RESIM('ozellikResim')
        );

        if(isset($id) and $id):
            $this->dbConn->update('ozellik',$post,$id);
        // kaydet
        else:
            $this->dbConn->insert('ozellik',$post);
        endif;
         $this->RedirectURL($this->BaseAdminURL($this->modulName.'/ozellik.html'));


    }
    public function  sektorkaydet($id=null)// Sektör Kaydet
    {


        $post = array(
            'baslik'=> $this->_POST('baslik'),
            'detay'=>$this->kirlet($this->_POST('detay')),
            // 'ustu'=> $this->_POST('kid'),
            'url'=> strtolower($this->perma($this->_POST('baslik'))),
            'resim' => $this->_RESIM('sektorResim'));

        if(isset($id) and $id):
            $this->dbConn->update('sektorler',$post,$id);
        // kaydet
        else:
            $this->dbConn->insert('sektorler',$post);
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/sektor.html'));



    }
    public function  kategoriKaydet($id=null)// Kategori Kaydet
    {

        foreach ($this->settings->lang('lang') as $dil=>$title):
            $post[$dil] = array(
                'baslik'=> $this->_POST('baslik',$dil),
                'fiyat'=> $this->_POST('fiyat',$dil),
                'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                'slogan'=>$this->kirlet($this->_POST('slogan',$dil)),
                'platform'=> $this->arraytojson($this->_POST('platform',$dil)),
             //   'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),
               // 'ustu'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,
                  'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),
                //'resim' => $this->_RESIM('kategoriResim_tr')
            );

        endforeach;

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update('gruplar',$post['tr'],$id);
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {
                    if(count($this->dbConn->sorgu("select id from gruplar where dil='$dil'  and masterid='$id' "))==1)
                        $this->dbConn->update('gruplar', $post[$dil], array('dil' =>$dil, 'masterid' => $id));
                  //  else
                     //   $this->dbConn->insert('kategoriler',array_merge($post[$dil],array('masterid'=>$id)));
                }
            endforeach;

        else:
            // kaydet
            $this->dbConn->insert('gruplar',$post['tr'],$id);
            $lastid = $this->dbConn->lastid();
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') $this->dbConn->insert('gruplar',array_merge($post[$dil],array('dil'=>$dil,'masterid'=>$lastid)));
            endforeach;
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));


    }

    //// Sil ////
    public function urunSil($id=null)// Urun Sil
    {
        if($id) $this->dbConn->sil("DELETE FROM paketler where masterid='$id' or id=".$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function  ozelliksil($id=null)// Marka Sil
    {
        if($id) $this->dbConn->sil('DELETE FROM ozellik where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/ozellik.html'));

    }

    public function  markasil($id=null)// Marka Sil
    {
        if($id) $this->dbConn->sil('DELETE FROM markalar where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/marka.html'));

    }


    public function  sektorsil($id=null)// Marka Sil
    {
        if($id) $this->dbConn->sil('DELETE FROM sektorler where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/sektor.html'));

    }

    public function kategorisil($id=null) // Kategori Sil
    {
        if($id) $this->dbConn->sil('DELETE FROM gruplar where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi.html'));
    }

    public function vitrin($id=null)
    {

        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);
        //$durum = (($durum==1) ? 0 :1);
        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        if($this->dbConn->update('urunler',array('vitrin'=>$durum),$id)) echo 1;else echo 0;

        exit;
    }


    //// Listeler ////

    public function liste($id=null)  //urun liste
    {

        $this->icbaslik = 'Paket Listesi';
        $pagelist = new PageList($this->settings);


        return $pagelist->PageList(array(
            'title'=> 'Paket Listesi',
            'icbaslik' => $this->icbaslik,
            'flitpage' => array('title'=>'Paket Grubu Seç','sql'=> "select * from gruplar where masterid=0  ",'option'=>array('value'=>'id','title'=>'baslik'),'name'=>'paketfild'),
            'id'=>$id,
            'page'=>'paket',
            'button' => array(array('title'=>'Ürün Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(   array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/urunSil/'),'color'=>'red')),
            'buton'=> array(
                //array('type'=>'radio','dataname'=>'vitrin','url'=>$this->BaseAdminURL($this->modulName.'/vitrin/')),
                          //  array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','url'=>$this->BaseAdminURL('Urunfoto/urunResimEkle/'),'modul'=>1,'folder'=>'../'.$this->settings->config('folder').'urunler/')
            ),
            'pdata' => $this->dbConn->sorgu("select * from paketler where masterid=0 ".(($id) ? ' and kid='.$id:null)."   ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'70%'),
              //  array('title'=>'Vitrin','width'=>'5%'),
             //   array('title'=>'Ürün Resim','width'=>'8%')
            )

        ));


        $this->js[] = '
        
        $(window).ready(function(e){
            $(\'select[name=urunkatfild]\').change(function(e){
            var  url = $(this).data(\'url\');
            location.href = \''.$control->BaseAdminURL('Urunler/Liste').'\'+$(this).find(\'option:selected\').val();
          });
        
        });
        
        ';


    }





    public function  marka($id=null) //Marka liste
    {
        $this->icbaslik = 'Marka Listesi';
        $pagelist = new Pagelist($this->settings);

        return $pagelist->PageList(array(
            'title'=> 'Marka Listesi',
            'icbaslik' => $this->icbaslik,
            'page'=>'Marka',
            'button' => array(array('title'=>'Marka Ekle','href'=> $this->BaseAdminURL($this->modulName.'/markaEkle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/markaEkle/'),'color'=>'blue'),
                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/markasil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from markalar ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%')
            )

        ));


    }
    public function  ozellik($id=null) //Marka liste
    {
        $this->icbaslik = 'Özellik Listesi';
        $pagelist = new Pagelist($this->settings);

        return $pagelist->PageList(array(
            'title'=> 'Özellik Listesi',
            'icbaslik' => $this->icbaslik,
            'page'=>'ozelik',
            'button' => array(array('title'=>'Özellik Ekle','href'=> $this->BaseAdminURL($this->modulName.'/ozellikEkle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ozellikEkle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/ozelliksil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from ozellik ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%')
            )

        ));


    }
    public function  sektor($id=null) //Sektor liste
    {
        $this->icbaslik = 'Sektör Listesi';
        $pagelist = new Pagelist($this->settings);

        return $pagelist->PageList(array(
            'title'=> 'Sektor Listesi',
            'icbaslik' => $this->icbaslik,
            'page'=>'Sektor',
            'button' => array(array('title'=>'Sektör Ekle','href'=> $this->BaseAdminURL($this->modulName.'/sektorEkle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/sektorEkle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/sektorsil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from sektorler ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%')
            )

        ));


    }

    public function kategoriListesi($id=null) //Kategori liste
    {
        $this->icbaslik = 'Paket Grubu Listesi';

        $pagelist = new PageList($this->settings);

        return $pagelist->PageList(array(
            'title'=> 'Paket Grubu Listesi',
            'icbaslik' => $this->icbaslik,
            'id'=>$id,
          //  'flitpage' => array('title'=>'Ürün Grubu Seç','sql'=> "select * from paketler where masterid=0 and  ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','name'=>'urunkatfild'),

            'page'=>'paketgrubu',
            'button' => array(array('title'=>'Ürün Grubu Ekle','href'=> $this->BaseAdminURL($this->modulName.'/kategoriEkle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/kategoriEkle/'),'color'=>'blue'),
                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/kategorisil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from gruplar where masterid=0 ".(($id) ? ' and ustu='.$id:null)."  ORDER   BY  sira"),
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