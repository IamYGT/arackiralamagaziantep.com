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

            $tabForm[$dil]['text'] = $form->input(array('value'=>((isset($data[$dil]['baslik'])) ? $this->temizle($data[$dil]['baslik']) :''),'title'=>'Ürün Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));

        endforeach;



        $text .= $tabs->tabContent($tabForm);


        $text .= $form->input(array('value'=>((isset($data["tr"]['kod'])) ? $this->temizle($data["tr"]['kod']) :''),'title'=>'Ürün Kodu','name'=>'kod','id'=>'kod','help'=>'','lang'=>"tr"));

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

        endforeach;

        $text .= $tabs->tabContent($tabForm);

        $text.=$form->select(array('title'=>'Üst Kategori Seçiniz','name'=>'kids','lang'=>'tr','data'=> $form->parent(array('sql'=>"select * from kategoriler_s where ustu = 0 and ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($data['tr']['ustu'])) ? $data['tr']['ustu']:0)),0,0)));

        $text  .=  $form->input(array('value'=>((isset($data["tr"]['genislik'])) ? $data["tr"]['genislik'] :''),'title'=>'Resim Liste Genişliği','name'=>'genislik','id'=>'genislik','help'=>'','lang'=>"tr"));

        $text .= $form->file(array('url'=>$this->BaseURL('upload')."/kategori",'folder'=>'kategori','title'=>'Kategori Resmi','name'=>'kategoriResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('kategori'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));



        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));

        $text .= $form->formClose();

        $modal = new Widget($this->settings);
          $fileUpload = $modal->fileLoad(['name'=>'files','params' => array('modul'=>$this->module,'folder'=>'../'.$this->settings->config('folder').$this->module.'/','baslik'=>'baslik_tr','id'=>$id),'sql'=>(($id) ? $this->dbConn->sorgu("select * from dosyalar where type='{$this->module}' and data_id='$id' ORDER   BY  sira"):array())]);
      $text .= $modal->infoform(array('title'=>'Ek Resim Yükle','govde'=>$fileUpload));

        return $text;

    }

    //// Kaydet  ////
    public function  kaydet($id=null) // Ürün Kaydet
    {




        foreach ($this->settings->lang('lang') as $dil=>$title):



            if($dil == 'tr'):



            $post[$dil] = array(

                'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                'genislik'=> $this->kirlet($this->_POST('genislik',$dil)),
                'kod'=> $this->_POST('kod_tr'),
                'teknik' => $this->kirlet($this->_POST('teknik',$dil)),
                'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                'ek'=>$this->kirlet($this->_POST('ek',$dil)),
                'kid'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,
                'url' => $this->SeoURL($this->table,array('name'=>'baslik','value'=>$this->_POST('baslik',$dil),'id'=>$id)),
                'resim' => $this->_RESIM('UrunResim_tr'),
                'dil' => $dil,
                'ozet'=>$this->kirlet($this->_POST('ozet',$dil))
            );



        else:



            $post[$dil] = array(

                'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                'genislik'=> $this->kirlet($this->_POST('genislik_tr')),
                'etiket'=> $this->_POST('etiket',$dil),
                'teknik' => $this->kirlet($this->_POST('teknik',$dil)),
                'kod'=> $this->_POST('kod_tr'),
                'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                'ek'=>$this->kirlet($this->_POST('ek',$dil)),
                'kids'=> ($this->_POST('kids','tr')) ? $this->_POST('kids','tr'):0,
                'url' => $this->SeoURL($this->tablelang,array('name'=>'baslik','value'=>$this->_POST('baslik',$dil),'id'=>$id)),
                'dil' => $dil,
                'ozet'=>$this->kirlet($this->_POST('ozet',$dil))

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

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));



    }
    public function  kategoriKaydet($id=null)// Kategori Kaydet

    {

        $table_kat = "kategoriler";



        foreach ($this->settings->lang('lang') as $dil=>$title):



            if($dil == "tr"):

            $post[$dil] = array(

                'kategori'=> $this->_POST('baslik',$dil),

                //'detay'=>$this->kirlet($this->_POST('detay',$dil)),

               // 'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),

                'url'=> strtolower($this->permalink($this->_POST('baslik',$dil))),

                //'ustu'=> ($this->_POST('kid','tr')) ? $this->_POST('kid','tr'):0,

                'resim' => $this->_RESIM('kategoriResim_tr'),

                'genislik'=> $this->_POST('genislik',$dil),


                'dil' => $dil

            );

        else:

            $post[$dil] = array(

                'kategori'=> $this->_POST('baslik',$dil),

                'genislik'=> $this->_POST('genislik_tr'),

                //'detay'=>$this->kirlet($this->_POST('detay',$dil)),

                'url'=> strtolower($this->permalink($this->_POST('baslik',$dil))),

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


        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html/'.$kid));

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



    public function bayi($id=null)
    {
        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        //$durum = (($durum==1) ? 0 :1);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        $urunDuzenle = $this->dbConn->update('urunler',array('bayi'=>$durum),$id);
        $langDuzenle = $this->dbConn->langUpdate('urunler_lang',array('bayi'=>$durum),$id);

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
            $ek .= " and baslik LIKE '%".$_GET["kelime"]."%' or detay LIKE '%".$_GET["kelime"]."%' or kod LIKE '%".$_GET["kelime"]."%'";
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

            'flitpage' => array('title'=>'Kategori Seç','sql'=> "select * from kategoriler where  ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','name'=>'urunfild'),

            'id'=>$id,

            'page'=>'Urun',

            'resim' => array('dizin'=>"../".$this->settings->config('folder').$this->module."/","dosya"=>"resim"),

            'button' => array(array('title'=>'Ürün Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),

            'p'=>array(

                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'kod', 'class'=>'sort'),
                array('dataTitle'=>'baslik', 'class'=>'sort')

            ),

            'tools' =>array(   array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),

                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/urunSil/'),'color'=>'red')),

            'buton'=> array(array('type'=>'radio','dataname'=>'vitrin','url'=>$this->BaseAdminURL($this->modulName.'/vitrin/')),

                array('type'=>'radio','dataname'=>'bayi','url'=>$this->BaseAdminURL($this->modulName.'/bayi/')),

                array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','dataname'=>'fotoekle','url'=>$this->BaseAdminURL($this->modulName.'/fotoekle/'))

            ),

            'pdata' => $this->dbConn->sorgu("select * from $this->table $ek  order by  sira LIMIT $gecerli,$sayfaLimit"),

            'toplamVeri'=>$toplamVeri,

            'ek'=>$ek,

            'search'=>true,

            'baslik'=>array(

                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Ürün Kodu','width'=>'10%'),
                array('title'=>'Başlık','width'=>'60%'),
                array('title'=>'Onay Durumu','width'=>'5%'),

                array('title'=>'Bayi Özel ','width'=>'5%'),

                array('title'=>'Resim Ekle','width'=>'10%')


            )



        ));






    }






    public function kategoriListesi($id=null) //Kategori liste

    {

        $this->icbaslik = 'Kategori Listesi';



        $pagelist = new PageList($this->settings);


        $ek = "";

        if (isset($_GET["kelime"])){
            $ek = "WHERE kategori LIKE '%".$_GET["kelime"]."%'";
        }


        $toplamVeri = count($this->dbConn->sorgu("select * from $this->ktable $ek order by  sira"));

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

            //'flitpage' => array('title'=>'Ürün Grubu Seç','sql'=> "select * from kategoriler where  ustu = 0 and ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','name'=>'urunkatfild'),



            'page'=>'urunGrubu',

            'button' => array(array('title'=>'Kategori Ekle','href'=> $this->BaseAdminURL($this->modulName.'/kategoriEkle.html'),'color'=>'green')),

            'p'=>array(

                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),

                array('dataTitle'=>'kategori', 'class'=>'sort')

            ),

            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/kategoriEkle/'),'color'=>'blue'),

                      array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/kategorisil/'),'color'=>'red')),

            'pdata' => $this->dbConn->sorgu("select * from kategoriler  ".(($id) ? ' where ustu='.$id:null)."  ORDER   BY  sira"),

            'pdata' => $this->dbConn->sorgu("select * from $this->ktable $ek ".(($id) ? ' and ustu='.$id:null)." order by  sira LIMIT $gecerli,$sayfaLimit"),
            'toplamVeri'=>$toplamVeri,
            'ek'=>$ek,
            'search'=>true,

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

    public function  etiketKaydet($id=null)// Özellik Kaydet

    {



        $post = array(

            'baslik'=> $this->_POST('baslik'),

            //'detay'=>$this->kirlet($this->_POST('detay')),

            'lang'=> $this->_POST('lang'),

            'url'=> $this->permalink($this->_POST('baslik'))

          //  'resim' => $this->_RESIM('ozellikResim')

        );



        if(isset($id) and $id):

            $this->dbConn->update('etiketler',$post,$id);

        // kaydet

        else:

            $this->dbConn->insert('etiketler',$post);

        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/etiketListesi.html'));





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

    public function  etiketListesi($id=null) //Marka liste

    {

        $this->icbaslik = 'Etiket Listesi';

        $pagelist = new Pagelist($this->settings);



        return $pagelist->PageList(array(

            'title'=> 'Etiket Listesi',

            'icbaslik' => $this->icbaslik,

            'page'=>'etiketler',

            'button' => array(array('title'=>'Etiket Ekle','href'=> $this->BaseAdminURL($this->modulName.'/etiketEkle.html'),'color'=>'green')),

            'p'=>array(

                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),

                array('dataTitle'=>'baslik', 'class'=>'sort')

            ),

            'tools' =>array( array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/etiketEkle/'),'color'=>'blue'),

                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/etiketsil/'),'color'=>'red')),

            'pdata' => $this->dbConn->sorgu("select * from etiketler  ORDER   BY  id"),

            'baslik'=>array(

                array('title'=>'ID','width'=>'4%'),

                array('title'=>'Başlık','width'=>'70%')

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

    public function  etiketekle($id=null)

    {



        $this->icbaslik = 'Etiket Ekle';

        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from etiketler WHERE id='.$id);

        $text = '';

        $form = new Form($this->settings);

        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=> $this->BaseAdminURL($this->modulName.'/etiketKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));

        $text .= $form->select(array('title'=>'Etiket Dili','name'=>'lang','data'=> $form->parent(array('array'=>array(
            array('id'=>'tr','baslik'=>'Türkçe'),
            array('id'=>'en','baslik'=>'İngilizce'),



        ),'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'kid','selected'=> ((isset($urun['lang'])) ? $urun['lang'] :'tr') ),0,0)));

        $text .= $form->input(array('value'=>((isset($urun['baslik_tr']) ? $urun['baslik_tr'] :'')),'title'=>'Başlık','name'=>'baslik','id'=>'baslik','help'=>''));
       // $text .= $form->input(array('value'=>((isset($urun['baslik_en']) ? $urun['baslik_en'] :'')),'title'=>'Başlık','lang'=>'en','name'=>'baslik','id'=>'baslik','help'=>''));

   //     $text .= $form->textarea(array('value'=>((isset($urun['detay']) ? $urun['detay'] :'')),'title'=>'Detay','name'=>'detay','id'=>'detay','help'=>'','height'=>'120'));



        // $text .= $form->textEditor(array('value'=>((isset($urun['detay']) ? $urun['detay'] :'')),'title'=>'Ürün Detayı','name'=>'detay','id'=>'haberDetay','height' => '200'));

      //  $text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'İkon','name'=>'ozellikResim','resimBoyut'=>$this->settings->boyut('ozellik'),'src'=>((isset($urun['resim'])) ? $urun['resim'] :'')));

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


    public function  etiketsil($id=null)// Marka Sil

    {
        if($id) $this->dbConn->sil('DELETE FROM etiketler where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/etiketListesi.html'));
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
