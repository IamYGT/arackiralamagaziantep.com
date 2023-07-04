<?php





namespace AdminPanel;





class Urunler extends Settings {



    public   $SayfaBaslik = 'Ürünler';

    public   $modulName = 'Urunler';

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
        $this->icbaslik = 'Comfort Time Ürün Ekle';

        $text = '';

        $tabForm = array();

        $form = new Form($this->settings);

        $tabs = new Tabs($this->settings);

        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));

        if($id) $data = $tabs->tabData('urunler',$id);

        foreach ($this->settings->lang('lang') as $dil=>$title):

             $tabForm[$dil]['text'] = $form->input(array('value'=>((isset($data[$dil]['baslik'])) ? $data[$dil]['baslik'] :''),'title'=>'Ürün Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));

         //  $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['urunkodu'])) ? $data[$dil]['urunkodu'] :''),'title'=>'Ürün Kodu','name'=>'urunkodu','id'=>'urunkodu','help'=>'','lang'=>$dil));

             $tabForm[$dil]['text'] .= $form->select(array('title'=>'Ürün Gruplarımız','name'=>'kid','lang'=>$dil,'data'=> $form->parent(array('sql'=>"select * from kategoriler where  ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','lang'=>$dil,'selected'=> ((isset($data['tr']['kid'])) ? $data['tr']['kid'] :0) ),0,0)));

         //  $tabForm[$dil]['text'] .= $form->select(array('title'=>'Markalar','name'=>'marka','data'=> $form->parent(array('sql'=>"select * from markalar where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','lang'=>$dil,'selected'=> ((isset($data[$dil]['marka'])) ? $data[$dil]['marka'] :0) ),0,0)));

         //  $tabForm[$dil]['text'] .= $form->selectmulti(array('title'=>'Sektörler','name'=>'sektor','data'=> $form->parent(array('sql'=>"select * from sektorler where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','lang'=>$dil,'selected'=> ((isset($data[$dil]['sektor'])) ? $data[$dil]['sektor'] :0) ),0,0)));

         //  $tabForm[$dil]['text'] .= $form->selectmulti(array('title'=>'Özellik','name'=>'ozellik','data'=> $form->parent(array('sql'=>"select * from ozellik ",'option'=>array('value'=>'id','title'=>'baslik'),,'lang'=>$dil,'selected'=> ((isset($data[$dil]['ozellik'])) ? $data[$dil]['ozellik'] :0) ),0,0)));

             $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay']) ? $data[$dil]['detay'] :'')),'title'=>'Ürün Detayı','name'=>'detay','id'=>'haberDetay','height' => '200','lang'=>$dil));

             $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['etiket']) ? $data[$dil]['etiket'] :'')),'title'=>'Arama Etiketleri','name'=>'etiket','id'=>'etiket','lang'=>$dil,'help'=>'Çok fazla etiket aramalarda negatif sonuç verebilir, 4-5 adet etiket yeterlidir. Örnek: masa, plastik masa, plastik koltuk,

'));

         //  $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['ozet']) ? $data[$dil]['ozet'] :'')),'title'=>'Teknik Özellikler','name'=>'ozet','id'=>'baslik','help'=>'','height'=>'120','lang'=>$dil));

         //  $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['teknik']) ? $data[$dil]['teknik'] :'')),'title'=>'Teknik Değerler','name'=>'teknik','id'=>'haberteknik','height' => '200','lang'=>$dil));



        endforeach;

        $text .= $tabs->tabContent($tabForm);

        $text .= $form->input(array('value'=>((isset($data['tr']['kod']) ? $data['tr']['kod'] :'')),'title'=>'Ürün Kodu','name'=>'urunkodu','id'=>'urunkodu','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['genislik']) ? $data['tr']['genislik'] :'')),'title'=>'Ürün Genişliği','name'=>'genislik','id'=>'genislik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['derinlik']) ? $data['tr']['derinlik'] :'')),'title'=>'Ürün Derinliği','name'=>'derinlik','id'=>'derinlik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['yukseklik']) ? $data['tr']['yukseklik'] :'')),'title'=>'Ürün  Yüksekliği','name'=>'yukseklik','id'=>'yukseklik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['agenislik']) ? $data['tr']['agenislik'] :'')),'title'=>'Ambalaj Genişliği','name'=>'agenislik','id'=>'agenislik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['aderinlik']) ? $data['tr']['aderinlik'] :'')),'title'=>'Ambalaj Derinliği','name'=>'aderinlik','id'=>'aderinlik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['ayukseklik']) ? $data['tr']['ayukseklik'] :'')),'title'=>'Ambalaj Yüksekliği','name'=>'ayukseklik','id'=>'ayukseklik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['kamyon']) ? $data['tr']['kamyon'] :'')),'title'=>'Yükleme Kamyon','name'=>'kamyon','id'=>'kamyon','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['kon20']) ? $data['tr']['kon20'] :'')),'title'=>'Yükleme  20" Konteyner','name'=>'kon20','id'=>'kon20','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['kon40']) ? $data['tr']['kon40'] :'')),'title'=>'Yükleme  40" Konteyner','name'=>'kon40','id'=>'kon40','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['tir']) ? $data['tr']['tir'] :'')),'title'=>'Yükleme Tır ','name'=>'tir','id'=>'tir','help'=>'','lang'=>'tr'));

        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Ürün Resmi','name'=>'UrunResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('urun'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));



        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));

        $text .= $form->formClose();

        $modal = new Widget($this->settings);

        $text .= $modal->infoform(array('title'=>'','govde'=>''));

        return $text;



    }

    public function Mpekle($id=null)

    {







        $this->icbaslik = 'Murat Plastik Ürün Ekle';

        $text = '';

        $tabForm = array();

        $form = new Form($this->settings);

        $tabs = new Tabs($this->settings);

        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/Mpkaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));

        if($id) $data = $tabs->tabData('murunler',$id);

        foreach ($this->settings->lang('lang') as $dil=>$title):

            $tabForm[$dil]['text'] = $form->input(array('value'=>((isset($data[$dil]['baslik'])) ? $data[$dil]['baslik'] :''),'title'=>'Ürün Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));

            //  $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['urunkodu'])) ? $data[$dil]['urunkodu'] :''),'title'=>'Ürün Kodu','name'=>'urunkodu','id'=>'urunkodu','help'=>'','lang'=>$dil));

            $tabForm[$dil]['text'] .= $form->select(array('title'=>'Ürün Gruplarımız','name'=>'kid','lang'=>$dil,'data'=> $form->parent(array('sql'=>"select * from mkategori where  ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','lang'=>$dil,'selected'=> ((isset($data['tr']['kid'])) ? $data['tr']['kid'] :0) ),0,0)));

            //  $tabForm[$dil]['text'] .= $form->select(array('title'=>'Markalar','name'=>'marka','data'=> $form->parent(array('sql'=>"select * from markalar where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','lang'=>$dil,'selected'=> ((isset($data[$dil]['marka'])) ? $data[$dil]['marka'] :0) ),0,0)));

            //  $tabForm[$dil]['text'] .= $form->selectmulti(array('title'=>'Sektörler','name'=>'sektor','data'=> $form->parent(array('sql'=>"select * from sektorler where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','lang'=>$dil,'selected'=> ((isset($data[$dil]['sektor'])) ? $data[$dil]['sektor'] :0) ),0,0)));

            //  $tabForm[$dil]['text'] .= $form->selectmulti(array('title'=>'Özellik','name'=>'ozellik','data'=> $form->parent(array('sql'=>"select * from ozellik ",'option'=>array('value'=>'id','title'=>'baslik'),,'lang'=>$dil,'selected'=> ((isset($data[$dil]['ozellik'])) ? $data[$dil]['ozellik'] :0) ),0,0)));

            $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay']) ? $data[$dil]['detay'] :'')),'title'=>'Ürün Detayı','name'=>'detay','id'=>'haberDetay','height' => '200','lang'=>$dil));

            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['renkadi']) ? $data[$dil]['renkadi'] :'')),'title'=>'Renk Adı','name'=>'renkadi','id'=>'etiket','lang'=>$dil,'help'=>'','lang'=>$dil));

            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['etiket']) ? $data[$dil]['etiket'] :'')),'title'=>'Arama Etiketleri','name'=>'etiket','id'=>'etiket','lang'=>$dil,'help'=>'Çok fazla etiket aramalarda negatif sonuç verebilir, 4-5 adet etiket yeterlidir. Örnek: masa, plastik masa, plastik koltuk,

'));

            //  $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['ozet']) ? $data[$dil]['ozet'] :'')),'title'=>'Teknik Özellikler','name'=>'ozet','id'=>'baslik','help'=>'','height'=>'120','lang'=>$dil));

            //  $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['teknik']) ? $data[$dil]['teknik'] :'')),'title'=>'Teknik Değerler','name'=>'teknik','id'=>'haberteknik','height' => '200','lang'=>$dil));



        endforeach;

        $text .= $tabs->tabContent($tabForm);

        $text .= $form->input(array('value'=>((isset($data['tr']['kod']) ? $data['tr']['kod'] :'')),'title'=>'Ürün Kodu','name'=>'urunkodu','id'=>'urunkodu','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['genislik']) ? $data['tr']['genislik'] :'')),'title'=>'Ürün Genişliği','name'=>'genislik','id'=>'genislik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['derinlik']) ? $data['tr']['derinlik'] :'')),'title'=>'Ürün Derinliği','name'=>'derinlik','id'=>'derinlik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['yukseklik']) ? $data['tr']['yukseklik'] :'')),'title'=>'Ürün  Yüksekliği','name'=>'yukseklik','id'=>'yukseklik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['agenislik']) ? $data['tr']['agenislik'] :'')),'title'=>'Ambalaj Genişliği','name'=>'agenislik','id'=>'agenislik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['aderinlik']) ? $data['tr']['aderinlik'] :'')),'title'=>'Ambalaj Derinliği','name'=>'aderinlik','id'=>'aderinlik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['ayukseklik']) ? $data['tr']['ayukseklik'] :'')),'title'=>'Ambalaj Yüksekliği','name'=>'ayukseklik','id'=>'ayukseklik','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['kamyon']) ? $data['tr']['kamyon'] :'')),'title'=>'Yükleme Kamyon','name'=>'kamyon','id'=>'kamyon','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['kon20']) ? $data['tr']['kon20'] :'')),'title'=>'Yükleme  20" Konteyner','name'=>'kon20','id'=>'kon20','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['kon40']) ? $data['tr']['kon40'] :'')),'title'=>'Yükleme  40" Konteyner','name'=>'kon40','id'=>'kon40','help'=>'','lang'=>'tr'));

        $text .= $form->input(array('value'=>((isset($data['tr']['tir']) ? $data['tr']['tir'] :'')),'title'=>'Yükleme Tır ','name'=>'tir','id'=>'tir','help'=>'','lang'=>'tr'));

        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Ürün Resmi','name'=>'UrunResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('urun'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));



        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));

        $text .= $form->formClose();

        $modal = new Widget($this->settings);

        $text .= $modal->infoform(array('title'=>'','govde'=>''));

        return $text;



    }



    public function kategoriEkle($id=null)

    {



        $this->icbaslik = 'Ürün Grubu Ekle';

        $text = '';

        $tabForm = array();

        $form = new Form($this->settings);

        $tabs = new Tabs($this->settings);

        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=>  $this->BaseAdminURL($this->modulName.'/kategoriKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));

        if($id) $data = $tabs->tabData('kategoriler',$id);

        foreach ($this->settings->lang('lang') as $dil=>$title):

            $tabForm[$dil]['text']  =  $form->input(array('value'=>((isset($data[$dil]['kategori'])) ? $data[$dil]['kategori'] :''),'title'=>'Ürün Grubu Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));

            $tabForm[$dil]['text'] .= $form->select(array('title'=>'Ürün Grubu','name'=>'kid','lang'=>$dil,'data'=> $form->parent(array('sql'=>"select * from kategoriler where  ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($data['tr']['ustu'])) ? $data['tr']['ustu']:0)),0,0)));

            $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay'])) ? $data[$dil]['detay'] :''),'title'=>'Ürün Grubu Detayı','name'=>'detay','id'=>'haberDetay','height' => '200','lang'=>$dil));

           // $tabForm[$dil]['text'] .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Ürün Grubu Resmi','name'=>'kategoriResim','lang'=>$dil,'resimBoyut'=>$this->settings->boyut('urunKategori'),'src'=>((isset($data[$dil]['resim'])) ? $data[$dil]['resim'] :'')));



        endforeach;

        $text .= $tabs->tabContent($tabForm);

        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Ürün Grubu Resmi','name'=>'kategoriResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('urunKategori'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));

        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Kompozisyon Resmi','name'=>'kompResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('urunKategorikomp'),'src'=>((isset($data['tr']['komp'])) ? $data['tr']['komp'] :'')));



        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));

        $text .= $form->formClose();

        $modal = new Widget($this->settings);

        $text .= $modal->infoform(array('title'=>'','govde'=>''));

        return $text;



    }

    public function mpkategoriEkle($id=null)

    {



        $this->icbaslik = 'Murat Plastik - Ürün Grubu Ekle';

        $text = '';

        $tabForm = array();

        $form = new Form($this->settings);

        $tabs = new Tabs($this->settings);

        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=>  $this->BaseAdminURL($this->modulName.'/kategoriKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));

        if($id) $data = $tabs->tabData('mkategori',$id);

        foreach ($this->settings->lang('lang') as $dil=>$title):

            $tabForm[$dil]['text']  =  $form->input(array('value'=>((isset($data[$dil]['baslik'])) ? $data[$dil]['baslik'] :''),'title'=>'Ürün Grubu Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));

            $tabForm[$dil]['text'] .= $form->select(array('title'=>'Ürün Grubu','name'=>'kid','lang'=>$dil,'data'=> $form->parent(array('sql'=>"select * from mkategori where  ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','selected'=>((isset($data['tr']['ustu'])) ? $data['tr']['ustu']:0)),0,0)));

            $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay'])) ? $data[$dil]['detay'] :''),'title'=>'Ürün Grubu Detayı','name'=>'detay','id'=>'haberDetay','height' => '200','lang'=>$dil));



        endforeach;

        $text .= $tabs->tabContent($tabForm);

        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Ürün Grubu Resmi','name'=>'kategoriResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('urunKategori'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));

        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Kompozisyon Resmi','name'=>'kompResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('urunKategorikomp'),'src'=>((isset($data['tr']['komp'])) ? $data['tr']['komp'] :'')));



        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));

        $text .= $form->formClose();

        $modal = new Widget($this->settings);

        $text .= $modal->infoform(array('title'=>'','govde'=>''));

        return $text;



    }

    //// Kaydet  ////

    public function  kaydet($id=null) // Ürün Kaydet

    {

        $tablename = "urunler";



        foreach ($this->settings->lang('lang') as $dil=>$title):



            if($dil == 'tr'):



            $post[$dil] = array(

                'baslik'=> $this->_POST('baslik',$dil),

                'kod'=> $this->_POST('urunkodu',$dil),

                'genislik'=> $this->_POST('genislik',$dil),

                'derinlik'=> $this->_POST('derinlik',$dil),

                'yukseklik'=> $this->_POST('yukseklik',$dil),

                'agenislik'=> $this->_POST('agenislik',$dil),

                'aderinlik'=> $this->_POST('aderinlik',$dil),

                'ayukseklik'=> $this->_POST('ayukseklik',$dil),

                'kamyon'=> $this->_POST('kamyon',$dil),

                'kon20'=> $this->_POST('kon20',$dil),

                'kon40'=> $this->_POST('kon40',$dil),

                'tir'=> $this->_POST('tir',$dil),

                'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                'kid'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,

                'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),

                'resim' => $this->_RESIM('UrunResim_tr'),

                'dil' => $dil



            );



        else:



            $post[$dil] = array(

                'baslik'=> $this->_POST('baslik',$dil),

                'etiket'=> $this->_POST('etiket',$dil),

                'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),

                'dil' => $dil





            );



        endif;



        endforeach;



        if(isset($id) and $id):

            //Güncelle

            $this->dbConn->update($tablename,$post['tr'],$id);

            foreach ($this->settings->lang('lang') as $dil=>$title):

       if($dil!='tr') {

                    if(count($this->dbConn->sorgu("select * from ".$tablename."_lang where dil='".$dil."' and master_id='".$id."' "))==1)

                        $this->dbConn->update($tablename.'_lang', $post[$dil],array('master_id'=>$id,'dil'=>$dil));

                    else

                        $this->dbConn->insert($tablename.'_lang',array_merge($post[$dil],array('master_id'=>$id)));

                }

            endforeach;

        else:

            // kaydet

            $this->dbConn->insert($tablename,$post['tr'],$id);

            $lastid = $this->dbConn->lastid();

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    $this->dbConn->insert($tablename.'_lang', array_merge($post[$dil], array('master_id' => $lastid)));

                }

            endforeach;

        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));



    }



    public function  Mpkaydet($id=null) // Ürün Kaydet

    {

        $tablename = "murunler";



        foreach ($this->settings->lang('lang') as $dil=>$title):



            if($dil == 'tr'):



                $post[$dil] = array(

                    'baslik'=> $this->_POST('baslik',$dil),

                    'kod'=> $this->_POST('urunkodu',$dil),

                    'genislik'=> $this->_POST('genislik',$dil),

                    'derinlik'=> $this->_POST('derinlik',$dil),

                    'yukseklik'=> $this->_POST('yukseklik',$dil),

                    'agenislik'=> $this->_POST('agenislik',$dil),

                    'aderinlik'=> $this->_POST('aderinlik',$dil),

                    'ayukseklik'=> $this->_POST('ayukseklik',$dil),

                    'kamyon'=> $this->_POST('kamyon',$dil),

                    'kon20'=> $this->_POST('kon20',$dil),

                    'kon40'=> $this->_POST('kon40',$dil),

                    'tir'=> $this->_POST('tir',$dil),

                    'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                    'kid'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,

                    'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),

                    'resim' => $this->_RESIM('UrunResim_tr'),

                    'dil' => $dil



                );



            else:



                $post[$dil] = array(

                    'baslik'=> $this->_POST('baslik',$dil),

                    'etiket'=> $this->_POST('etiket',$dil),

                    'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                    'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),

                    'dil' => $dil





                );



            endif;



        endforeach;



        if(isset($id) and $id):

            //Güncelle

            $this->dbConn->update($tablename,$post['tr'],$id);

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    if(count($this->dbConn->sorgu("select * from ".$tablename."_lang where dil='".$dil."' and master_id='".$id."' "))==1)

                        $this->dbConn->update($tablename.'_lang', $post[$dil],array('master_id'=>$id,'dil'=>$dil));

                    else

                        $this->dbConn->insert($tablename.'_lang',array_merge($post[$dil],array('master_id'=>$id)));

                }

            endforeach;

        else:

            // kaydet

            $this->dbConn->insert($tablename,$post['tr'],$id);

            $lastid = $this->dbConn->lastid();

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    $this->dbConn->insert($tablename.'_lang', array_merge($post[$dil], array('master_id' => $lastid)));

                }

            endforeach;

        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/mpliste'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));



    }



    public function  kategoriKaydet($id=null)// Kategori Kaydet

    {

        $table = "kategoriler";



        foreach ($this->settings->lang('lang') as $dil=>$title):



            if($dil == "tr"):

            $post[$dil] = array(

                'kategori'=> $this->_POST('baslik',$dil),

                'detay'=>$this->kirlet($this->_POST('detay',$dil)),

               // 'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),

                'ustu'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,

                'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),

                'resim' => $this->_RESIM('kategoriResim_tr'),

                'komp' => $this->_RESIM('kompResim_tr'),

                'dil' => $dil

            );

        else:

            $post[$dil] = array(

                'kategori'=> $this->_POST('baslik',$dil),

                'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),



            );



        endif;



        endforeach;



        if(isset($id) and $id):

            //Güncelle

            $this->dbConn->update($table,$post['tr'],$id);

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    if(count($this->dbConn->sorgu("select lang_id from ".$table."_lang where dil='$dil'  and master_id='$id' "))==1)

                        $this->dbConn->update($table."_lang", $post[$dil], array('master_id'=>$id,'dil'=>$dil));

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

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));





    }



    public function  mpkategoriKaydet($id=null)// Kategori Kaydet

    {

        $table = "mkategori";

        foreach ($this->settings->lang('lang') as $dil=>$title):



            if($dil == "tr"):

                $post[$dil] = array(

                    'baslik'=> $this->_POST('baslik',$dil),

                    'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                    // 'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),

                    'ustu'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,

                    'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),

                    'resim' => $this->_RESIM('kategoriResim_tr'),

                    'komp' => $this->_RESIM('kompResim_tr'),

                    'dil' => $dil

                );

            else:

                $post[$dil] = array(

                    'baslik'=> $this->_POST('baslik',$dil),

                    'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                    'url'=> strtolower($this->perma($this->_POST('baslik',$dil))),







                );



            endif;



        endforeach;



        if(isset($id) and $id):

            //Güncelle

            $this->dbConn->update($table,$post['tr'],$id);

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    if(count($this->dbConn->sorgu("select lang_id from ".$table."_lang where dil='$dil'  and master_id='$id' "))==1)

                        $this->dbConn->update($table."_lang", $post[$dil], array('master_id'=>$id,'dil'=>$dil));

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

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));





    }





    //// Sil ////

    public function urunSil($id=null)// Urun Sil

    {

        if($id)

        {

            $this->dbConn->sil("DELETE FROM urunler where id=".$id);

            $this->dbConn->sil("DELETE FROM urunler_lang where master_id='$id'");

        }

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));

    }



    public function mpurunSil($id=null)// Urun Sil

    {

        if($id) {

            $this->dbConn->sil("DELETE FROM murunler where id=".$id);

            $this->dbConn->sil("DELETE FROM murunler_lang where master_id='$id'");

        }

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/mpliste.html'));

    }



    public function kategorisil($id=null) // Kategori Sil

{

    if($id) $this->dbConn->sil('DELETE FROM kategoriler where id='.$id);

    $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi.html'));

}



    public function mpkategorisil($id=null) // Kategori Sil

    {

        if($id)

        {

            $this->dbConn->sil('DELETE FROM mkategori where id='.$id);

            $this->dbConn->sil('DELETE FROM mkategori_lang where master_id='.$id);

        }

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/mpkategoriListesi.html'));

    }



    public function vitrin($id=null)

    {



        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        //$durum = (($durum==1) ? 0 :1);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);

        if($this->dbConn->update('urunler',array('vitrin'=>$durum),$id)) echo 1;else echo 0;



        exit;

    }



    public function mpvitrin($id=null)

    {



        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        //$durum = (($durum==1) ? 0 :1);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);

        if($this->dbConn->update('mpurunler',array('vitrin'=>$durum),$id)) echo 1;else echo 0;



        exit;

    }





    //// Listeler ////



    public function liste($id=null)  //urun liste

    {



        $this->icbaslik = 'Comfort Time - Ürün Listesi';

        $pagelist = new PageList($this->settings);





        return $pagelist->PageList(array(

            'title'=> 'Comfort Time - Ürün Listesi',

            'icbaslik' => $this->icbaslik,

            'flitpage' => array('title'=>'Ürün Grubu Seç','sql'=> "select * from kategoriler where  ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','name'=>'urunfild'),

            'id'=>$id,

            'page'=>'Urun',

            'button' => array(array('title'=>'Ürün Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),

            'p'=>array(

                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),

                array('dataTitle'=>'baslik', 'class'=>'sort')

            ),

            'tools' =>array(   array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),

                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/urunSil/'),'color'=>'red')),

            'buton'=> array(array('type'=>'radio','dataname'=>'vitrin','url'=>$this->BaseAdminURL($this->modulName.'/vitrin/')),

                            array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','url'=>$this->BaseAdminURL('Urunfoto/urunResimEkle/'),'modul'=>1,'folder'=>'../'.$this->settings->config('folder').'urunler/')

            ),

            'pdata' => $this->dbConn->sorgu("select * from urunler ".(($id) ? 'where kid='.$id:null)."   ORDER   BY  sira"),

            'baslik'=>array(

                array('title'=>'ID','width'=>'4%'),

                array('title'=>'Başlık','width'=>'70%'),

                array('title'=>'Vitrin','width'=>'5%'),

                array('title'=>'Ürün Resim','width'=>'8%')

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



    public function Mpliste($id=null)  //urun liste

    {



        $this->icbaslik = 'Murat Plastik - Ürün Listesi';

        $pagelist = new PageList($this->settings);





        return $pagelist->PageList(array(

            'title'=> 'Murat Plastik  -  Ürün Listesi',

            'icbaslik' => $this->icbaslik,

            'flitpage' => array('title'=>'Ürün Grubu Seç','sql'=> "select * from mkategori where  ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','name'=>'mpurunfild'),

            'id'=>$id,

            'page'=>'mpUrun',

            'button' => array(array('title'=>'Ürün Ekle','href'=>$this->BaseAdminURL($this->modulName.'/Mpekle.html'),'color'=>'green')),

            'p'=>array(

                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),

                array('dataTitle'=>'baslik', 'class'=>'sort')

            ),

            'tools' =>array(   array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/Mpekle/'),'color'=>'blue'),

                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/MpurunSil/'),'color'=>'red')),

            'buton'=> array(array('type'=>'radio','dataname'=>'vitrin','url'=>$this->BaseAdminURL($this->modulName.'/mpvitrin/')),

                array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','url'=>$this->BaseAdminURL('Urunfoto/urunResimEkle/'),'modul'=>2,'folder'=>'../'.$this->settings->config('folder').'urunler/')

            ),

            'pdata' => $this->dbConn->sorgu("select * from murunler ".(($id) ? 'where kid='.$id:null)."   ORDER   BY  sira"),

            'baslik'=>array(

                array('title'=>'ID','width'=>'4%'),

                array('title'=>'Başlık','width'=>'70%'),

                array('title'=>'Vitrin','width'=>'5%'),

                array('title'=>'Ürün Resim','width'=>'8%')

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



    public function kategoriListesi($id=null) //Kategori liste

    {

        $this->icbaslik = 'Comfort Time - Ürün Grubu Listesi';



        $pagelist = new PageList($this->settings);



        return $pagelist->PageList(array(

            'title'=> 'Comfort Time - Ürün Grubu Listesi',

            'icbaslik' => $this->icbaslik,

            'id'=>$id,

            'flitpage' => array('title'=>'Ürün Grubu Seç','sql'=> "select * from kategoriler where   ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','name'=>'urunkatfild'),



            'page'=>'urunGrubu',

            'button' => array(array('title'=>'Ürün Grubu Ekle','href'=> $this->BaseAdminURL($this->modulName.'/kategoriEkle.html'),'color'=>'green')),

            'p'=>array(

                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),

                array('dataTitle'=>'kategori', 'class'=>'sort')

            ),

            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/kategoriEkle/'),'color'=>'blue'),

                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/kategorisil/'),'color'=>'red')),

            'pdata' => $this->dbConn->sorgu("select * from kategoriler  ".(($id) ? ' where ustu='.$id:null)."  ORDER   BY  sira"),

            'baslik'=>array(

                array('title'=>'ID','width'=>'4%'),

                array('title'=>'Başlık','width'=>'80%')

            )



        ));



    }

    public function MpkategoriListesi($id=null) //Kategori liste

    {

        $this->icbaslik = 'Murat Plastik - Ürün Grubu Listesi';



        $pagelist = new PageList($this->settings);



        return $pagelist->PageList(array(

            'title'=> 'Murat Plastik - Ürün Grubu Listesi',

            'icbaslik' => $this->icbaslik,

            'id'=>$id,

            'flitpage' => array('title'=>'Ürün Grubu Seç','sql'=> "select * from mkategori where   ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','name'=>'mpurunkatfild'),



            'page'=>'mpurunGrubu',

            'button' => array(array('title'=>'Ürün Grubu Ekle','href'=> $this->BaseAdminURL($this->modulName.'/mpkategoriEkle.html'),'color'=>'green')),

            'p'=>array(

                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),

                array('dataTitle'=>'baslik', 'class'=>'sort')

            ),

            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/mpkategoriEkle/'),'color'=>'blue'),

                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/mpkategorisil/'),'color'=>'red')),

            'pdata' => $this->dbConn->sorgu("select * from mkategori  ".(($id) ? ' where ustu='.$id:null)."  ORDER   BY  sira"),

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

            // 'ustu'=> $this->_POST('kid'),

            'url'=> strtolower($this->perma($this->_POST('baslik'))),

            'resim' => $this->_RESIM('ozellikResim'));



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

    public function  markaekle($id=null)

    {



        $this->icbaslik = 'Marka Ekle';

        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from markalar WHERE id='.$id);

        $text = '';

        $form = new Form($this->settings);

        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=> $this->BaseAdminURL($this->modulName.'/markakaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));

        $text .= $form->input(array('value'=>((isset($urun['baslik']) ? $urun['baslik'] :'')),'title'=>'Marka Başlığı','name'=>'baslik','id'=>'baslik','help'=>''));

        $text .= $form->select(array('title'=>'Marka Kategorisi','name'=>'kid','data'=> $form->parent(array('sql'=>"select * from markalar where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'ustu','selected'=> ((isset($urun['kid'])) ? $urun['kid'] :0) ),0,0)));

        // $text .= $form->textEditor(array('value'=>((isset($urun['detay']) ? $urun['detay'] :'')),'title'=>'Ürün Detayı','name'=>'detay','id'=>'haberDetay','height' => '200'));

        $text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'Marka Resmi','name'=>'sektorResim','resimBoyut'=>$this->settings->boyut('urun'),'src'=>((isset($urun['resim'])) ? $urun['resim'] :'')));



        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));

        $text .= $form->formClose();

        return $text;



    }

    public function  ozellikekle($id=null)

    {



        $this->icbaslik = 'Özellik Ekle';

        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from ozellik WHERE id='.$id);

        $text = '';

        $form = new Form($this->settings);

        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=> $this->BaseAdminURL($this->modulName.'/ozellikkaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));

        $text .= $form->input(array('value'=>((isset($urun['baslik']) ? $urun['baslik'] :'')),'title'=>'Başlık','name'=>'baslik','id'=>'baslik','help'=>'Ürün Detay Kısmında Görüntülenmeyecektir.'));

        $text .= $form->textarea(array('value'=>((isset($urun['detay']) ? $urun['detay'] :'')),'title'=>'Detay','name'=>'detay','id'=>'detay','help'=>'','height'=>'120'));

        //  $text .= $form->select(array('title'=>'Ürünler','name'=>'kid','data'=> $form->parent(array('sql'=>"select * from urunler where ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'kid','selected'=> ((isset($urun['kid'])) ? $urun['kid'] :0) ),0,0)));

        // $text .= $form->textEditor(array('value'=>((isset($urun['detay']) ? $urun['detay'] :'')),'title'=>'Ürün Detayı','name'=>'detay','id'=>'haberDetay','height' => '200'));

        $text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'İkon','name'=>'ozellikResim','resimBoyut'=>$this->settings->boyut('ozellik'),'src'=>((isset($urun['resim'])) ? $urun['resim'] :'')));

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





}