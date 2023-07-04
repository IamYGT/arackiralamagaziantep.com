<?php

namespace AdminPanel;

class Urunler extends Settings {

    public   $SayfaBaslik = 'Ürünler';
    public   $modulName = 'Urunler';
    private  $css;
    private  $js = array();
    private $module = 'urunler';
    private $table = 'urunler';
    private $ktable = 'kategoriler';
    private $tablelang = 'urunler_lang';
    private $ktablelang = 'kategoriler_lang';
    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }
    //// Ekle   ////
    public function ekle($id=null)
    {
        $this->icbaslik = 'Ürün Ekle';
        $text = '';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        if($id) $data = $tabs->tabData($this->table,$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text'] = $form->input(array('value'=>((isset($data[$dil]['baslik'])) ? $this->temizle($data[$dil]['baslik']) :''),'title'=>'Ürün Başlık','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['gramaj'])) ? $this->temizle($data[$dil]['gramaj']) :''),'title'=>'Ürün Gramaj','name'=>'gramaj','id'=>'gramaj','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['adet'])) ? $this->temizle($data[$dil]['adet']) :''),'title'=>'Koli İçi Adedi','name'=>'adet','id'=>'adet','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['ambalaj'])) ? $this->temizle($data[$dil]['ambalaj']) :''),'title'=>'Ambalaj Şekli','name'=>'ambalaj','id'=>'ambalaj','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['raf'])) ? $this->temizle($data[$dil]['raf']) :''),'title'=>'Raf Ömrü','name'=>'raf','id'=>'raf','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['ozet'])) ? $this->temizle($data[$dil]['ozet']) :''),'title'=>'Ürün Kodu','name'=>'ozet','id'=>'ozet','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['fiyat'])) ? $this->temizle($data[$dil]['fiyat']) :''),'title'=>'Ürün Fiyatı','name'=>'fiyat','id'=>'fiyat','help'=>'','lang'=>$dil));            
            $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay'])) ? $this->temizle($data[$dil]['detay']) :''),'title'=>'Ürün Açıklaması','name'=>'detay','id'=>'detay','help'=>'','lang'=>$dil));
        endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->select(array('title'=>'Kategori','name'=>'kid','lang'=>'tr','data'=> $form->parent(array('sql'=>"select * from kategoriler where  ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=> ((isset($data['tr']['kid'])) ? $data['tr']['kid'] :0) ),0,0)));
        $text .= $form->file(array('url'=>$this->BaseURL("upload").'/urunler','folder'=>'urunler','title'=>'Ürün Resmi','name'=>'UrunResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('urun'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));

        $text .= $form->formClose();

        return $text;
    }

    public function kategoriEkle($id=null)

    {
        $this->icbaslik = 'Kategori Ekle';
        $text = '';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=>  $this->BaseAdminURL($this->modulName.'/kategoriKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        if($id) $data = $tabs->tabData('kategoriler',$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']  =  $form->input(array('value'=>((isset($data[$dil]['kategori'])) ? $data[$dil]['kategori'] :''),'title'=>'Kategori Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));
            //$tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['marka']) ? $this->temizle($data[$dil]['marka']) :'')),'title'=>'Marka','name'=>'marka','id'=>'marka','height' => '200','lang'=>$dil));
            //$tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['ozet']) ? $this->temizle($data[$dil]['ozet']) :'')),'title'=>'Özet','name'=>'ozet','id'=>'ozet','height' => '200','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->textarea(array('value'=>((isset($data[$dil]['detay']) ? $this->temizle($data[$dil]['detay']) :'')),'title'=>'Detay','name'=>'detay','id'=>'detay','height' => '200','lang'=>$dil));

        endforeach;
        $text .= $tabs->tabContent($tabForm);
        //$text.=$form->select(array('title'=>'Üst Kategori Seçiniz','name'=>'kid','lang'=>'tr','data'=> $form->parent(array('sql'=>"select * from kategoriler where ustu = 0 and ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($data['tr']['ustu'])) ? $data['tr']['ustu']:0)),0,0)));
        $text .= $form->file(array('url'=>$this->BaseURL('upload')."/kategori",'folder'=>'kategori','title'=>'Kategori Resmi','name'=>'kategoriResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('kategori'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;
    }
    //// Kaydet  ////
    public function  kaydet($id=null) // Ürün Kaydet
    {
        foreach ($this->settings->lang('lang') as $dil=>$title):
            if($dil == 'tr'):
            $post[$dil] = array(
                'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                'ozet'=> $this->kirlet($this->_POST('ozet',$dil)),
                'gramaj'=> $this->kirlet($this->_POST('gramaj',$dil)),
                'adet'=> $this->kirlet($this->_POST('adet',$dil)),
                'raf'=> $this->kirlet($this->_POST('raf',$dil)),
                'ambalaj'=> $this->kirlet($this->_POST('ambalaj',$dil)),
                'kod'=> $this->kirlet($this->_POST('kod',$dil)),
                'fiyat'=> $this->kirlet($this->_POST('fiyat',$dil)),
                'detay'=> $this->kirlet($this->_POST('detay',$dil)),
                'kid'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,
                //'url' => $this->SeoURL($this->table,array('name'=>'baslik','value'=>$this->kirlet($this->_POST('baslik',$dil)),'id'=>$id)),
                'resim' => $this->_RESIM('UrunResim_tr'),
                'dil' => $dil,
            );
        else:
            $post[$dil] = array(
                'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                'ozet'=> $this->kirlet($this->_POST('ozet',$dil)),
                'gramaj'=> $this->kirlet($this->_POST('gramaj',$dil)),
                'adet'=> $this->kirlet($this->_POST('adet',$dil)),
                'raf'=> $this->kirlet($this->_POST('raf',$dil)),
                'ambalaj'=> $this->kirlet($this->_POST('ambalaj',$dil)),
                'kod'=> $this->kirlet($this->_POST('kod',$dil)),
                'fiyat'=> $this->kirlet($this->_POST('fiyat',$dil)),
                'detay'=> $this->kirlet($this->_POST('detay',$dil)),
                'kid'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,
                //'url' => $this->SeoURL($this->tablelang,array('name'=>'baslik','value'=>$this->_POST('baslik',$dil),'id'=>$id)),
                'dil' => $dil,
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
            $this->FileSessionSave($lastid,$this->module);

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    $this->dbConn->insert($this->tablelang, array_merge($post[$dil], array('master_id' => $lastid)));

                }

            endforeach;

        endif;

//        $marka = $this->dbConn->tekSorgu("SELECT marka FROM kategoriler WHERE id =".$this->_POST("kid_tr"));


        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/Liste'.(($this->_POST('kid_tr')) ? "/".$this->_POST("kid_tr"):'.html')));
    }
    public function  kategoriKaydet($id=null)// Kategori Kaydet

    {
        $table_kat = "kategoriler";
        foreach ($this->settings->lang('lang') as $dil=>$title):
            if($dil == "tr"):

            $post[$dil] = array(
                'kategori'=> $this->_POST('baslik',$dil),
                'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                //'marka'=>$this->kirlet($this->_POST('marka',$dil)),
                //'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),
                //'url'=> strtolower($this->permalink($this->_POST('baslik',$dil))),
                //'ustu'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,
                'resim' => $this->_RESIM('kategoriResim_tr'),
                'dil' => $dil
            );

        else:

            $post[$dil] = array(

                'kategori'=> $this->_POST('baslik',$dil),
                //'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                //'marka'=>$this->kirlet($this->_POST('marka',$dil)),
                //'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),
                //'url'=> strtolower($this->permalink($this->_POST('baslik',$dil))),
                'dil'=> $dil,
                //'ustu'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,
            );



        endif;



        endforeach;



        if(isset($id) and $id):

            //Güncelle

            $this->dbConn->update($table_kat,$post['tr'],$id);

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    if(count($this->dbConn->sorgu("select lang_id from ".$table_kat."_lang where dil='$dil' and master_id='$id' "))==1)

                        $this->dbConn->update($table_kat."_lang", $post[$dil], array('master_id'=>$id,'dil'=>$dil));

                        else

                        $this->dbConn->insert($table_kat."_lang",array_merge($post[$dil],array('master_id'=>$id)));

                }

            endforeach;



        else:

            // kaydet

            $this->dbConn->insert($table_kat,$post['tr'],$id);

            $lastid = $this->dbConn->lastid();

            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') $this->dbConn->insert($table_kat."_lang",array_merge($post[$dil],array('dil'=>$dil,'master_id'=>$lastid)));

            endforeach;

        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));





    }

    //// Sil ////

    public function urunSil($id=null)// Urun Sil

    {

        if($id)

        {

        $rec2 = $this->dbConn->tekSorgu("SELECT * FROM urunler WHERE id='$id'");
        $resim2= $this->resimGet($rec2["resim"]);
        $kid = $rec2['data_id'];

        $this->ResimSil($resim2,"../".$this->settings->config('folder')."urunler/"); // Eski resmi sil

            $this->dbConn->sil("DELETE FROM urunler where id=".$id);

            $this->dbConn->sil("DELETE FROM urunler_lang where master_id='$id'");

        }


        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/Liste/'.$rec2["kid"]));

    }

    public function kategorisil($id=null) // Kategori Sil

{

    if($id) $this->dbConn->sil('DELETE FROM kategoriler where id='.$id);
    if($id) $this->dbConn->sil('DELETE FROM kategoriler_lang where master_id='.$id);

    $this->RedirectURL($this->BaseAdminURL($this->modulName.'/kategoriListesi.html'));

}
    public function vitrin($id=null)
    {
        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        //$durum = (($durum==1) ? 0 :1);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        $urunDuzenle = $this->dbConn->update('urunler',array('vitrin'=>$durum),$id);
        $langDuzenle = $this->dbConn->langUpdate('urunler_lang',array('vitrin'=>$durum),$id);

        if($urunDuzenle && $langDuzenle) echo 1;else echo 0;

        exit();
    }


     public function aktif($id=null)
    {
        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        //$durum = (($durum==1) ? 0 :1);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        $urunDuzenle = $this->dbConn->update('kategoriler',array('aktif'=>$durum),$id);
        $langDuzenle = $this->dbConn->langUpdate('kategoriler_lang',array('aktif'=>$durum),$id);

        if($urunDuzenle && $langDuzenle) echo 1;else echo 0;

        exit();
    }

    //// Listeler ////



    public function liste($id=null)  //urun liste

    {



        $this->icbaslik = 'Ürün Listesi';

        $pagelist = new PageList($this->settings);

        $ek = "WHERE 1=1";



        if (isset($_GET["kelime"])){
            $ek .= " and baslik LIKE '%".$_GET["kelime"]."%'";
        }

        if (isset($id)){
            $ek .=" and kid = ".$id;
        }


        $toplamVeri = count($this->dbConn->sorgu("select * from $this->table $ek order by  sira"));

        $sayfa = (isset($_GET["sayfa"])) ? $this->kirlet(intval($_GET['sayfa'])) : 1;

        if (!is_numeric($sayfa)){
            $sayfa = 1;
        }

        $sayfaLimit = $this->settings->config('veriLimit');

        $gecerli = 0;

        $toplamSayfa = ceil($toplamVeri / $sayfaLimit);

        if ($sayfa > $toplamSayfa)
        {
            $sayfa = 1;
        }

        if ($sayfa > 0){
            $gecerli = ($sayfa - 1) * $sayfaLimit;
        }








        return $pagelist->PageList(array(

            'title'=> 'Ürün Listesi',

            'icbaslik' => $this->icbaslik,


            'flitpage' => array('title'=>'Kategori Seç','sql'=> "select * from kategoriler where ",'option'=>array('value'=>'id','title'=>'kategori'),
                'kat'=>'ustu','name'=>'urunfild'),



            'id'=>$id,


            'page'=>'Urun',

            'button' => array(array('title'=>'Ürün Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'red')),

            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),

                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),

            'tools' =>array(   array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),

                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/urunSil/'),'color'=>'red')),

            'buton'=> array(array('type'=>'radio','dataname'=>'vitrin','url'=>$this->BaseAdminURL($this->modulName.'/vitrin/')),

                array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','dataname'=>'fotoekle','url'=>$this->BaseAdminURL($this->modulName.'/fotoekle/'))
            ),

            'pdata' => $this->dbConn->sorgu("select * from $this->table $ek  order by  sira LIMIT $gecerli,$sayfaLimit"),

            'toplamVeri'=>$toplamVeri,

            'ek'=>$ek,

            'search'=>true,

            'baslik'=>array(

                array('title'=>'ID','width'=>'4%'),

                array('title'=>'Başlık','width'=>'70%'),

                array('title'=>'Onay Durumu','width'=>'5%'),

                array('title'=>'Resim Ekle','width'=>'10%')


            )



        ));






    }






    public function kategoriListesi($id=null) //Kategori liste

    {

        $this->icbaslik = 'Kategori Listesi';



        $pagelist = new PageList($this->settings);


        $toplamVeri = count($this->dbConn->sorgu("select * from $this->ktable order by  sira"));
        $sayfa = (isset($_GET["sayfa"])) ? $this->kirlet(intval($_GET['sayfa'])) : 1;

        if (!is_numeric($sayfa)){
            $sayfa = 1;
        }

        $sayfaLimit = $this->settings->config('veriLimit');
        $gecerli = 0;
        $toplamSayfa = ceil($toplamVeri / $sayfaLimit);

        if ($sayfa > $toplamSayfa)
        {
            $sayfa = 1;
        }

        if ($sayfa > 0){
            $gecerli = ($sayfa - 1) * $sayfaLimit;
        }

        return $pagelist->PageList(array(
            'title'=> '',
            'icbaslik' => $this->icbaslik,
            'id'=>$id,
            //'flitpage' => array('title'=>'Kategori Seç','sql'=> "select * from kategoriler where ustu = 0 and ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','name'=>'urunkatfild'),
            'page'=>'urunGrubu',
            'button' => array(array('title'=>'Kategori Ekle','href'=> $this->BaseAdminURL($this->modulName.'/kategoriEkle.html'),'color'=>'red')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'kategori', 'class'=>'sort')
            ),
            'buton'=> array(array('type'=>'radio','dataname'=>'aktif','url'=>$this->BaseAdminURL($this->modulName.'/aktif/')),
                //array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','dataname'=>'fotoekle','url'=>$this->BaseAdminURL($this->modulName.'/fotoekle/'))
            ),
            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/kategoriEkle/'),'color'=>'blue'),

                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/kategorisil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from $this->ktable ".(($id) ? 'WHERE ustu='.$id:' WHERE ustu = 0')." order by  sira LIMIT $gecerli,$sayfaLimit"),
            'toplamVeri'=>$toplamVeri,
            'baslik'=>array(
               array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'70%'),
                array('title'=>'Onay Durumu','width'=>'5%'),
                //array('title'=>'Resim Ekle','width'=>'10%')
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












    public function fotoekle($id=0)
    {


        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from '.$this->table.' WHERE id='.$id);

        $baslik = $this->permalink($this->temizle($urun["baslik"]));

        $this->icbaslik = 'Resim Ekle';

        $pagelist = new Pagelist($this->settings);

        return $pagelist->Fotolist(array(
            'title'=> 'Resim Listesi',
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
            // 'ustu'=> $this->_POST('kid'),
            //'url'=> strtolower($this->perma($this->_POST('baslik'))),
            'dosya' => $this->_RESIM('fotoResim'));

        // Güncelle
        if(isset($id) and $id):
            $this->dbConn->update('dosyalar',$post,$id);

        endif;
        $fotoid = $this->dbConn->tekSorgu("select * from dosyalar where id='$id'");
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/fotoekle/'.$fotoid['data_id']));
    }
}
