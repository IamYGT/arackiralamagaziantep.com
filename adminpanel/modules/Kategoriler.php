<?php
namespace AdminPanel;
use AdminPanel\Form;

class Kategoriler extends Settings  {

    public  $SayfaBaslik = 'Kategoriler';
    public  $modulName = 'Kategoriler';
    public  $icbaslik ;
    private $js = array();
    private $css = array();
    private $module='kategori';
    private $table ='kategoriler_s';
    private $tablelang = 'kategoriler_s_lang';

    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

    public function index($id=null)
    {
      return $this->liste($id);
    }

    public function ekle($id=null)
    {
        $this->icbaslik = 'Kategori Ekle';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        if($id) $data = $tabs->tabData($this->table,$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']  = $form->input(array('value'=>((isset($data[$dil]['kategori']) ? $this->temizle($data[$dil]['kategori']) :'')),'title'=>'Başlık','name'=>'kategori','id'=>'kategori','help'=>'','lang'=>$dil));
         endforeach;
        $text .= $tabs->tabContent($tabForm);
        //$text .= $form->date(array('value'=>((isset($data["tr"]['tarih']) ? date('d-m-Y',$data["tr"]['tarih']) : date('d-m-Y'))),'title'=>'Tarih','name'=>'tarih','id'=>'tarih','help'=>'', 'lang'=>"tr"));
        $text .= $form->file(array('url'=>$this->BaseURL('upload').'/'.$this->module,'folder'=>$this->module,'title'=>'Resim','name'=>'HaberResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('haber'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));

        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        return $text;

    }
    public function kaydet($id=null)
    {
            foreach ($this->settings->lang('lang') as $dil=>$title):
              if($dil == "tr"):
                    $post[$dil] = array(
                        'kategori'=> $this->kirlet($this->_POST('kategori',$dil)),
                        'dil'=>$dil,
                        'url'=> $this->SeoURL($this->table,array('name'=>'kategori','value'=>$this->kirlet($this->_POST('kategori',$dil)),'id'=>$id)),
                        'resim' => $this->_RESIM('HaberResim_tr')
                    );
                else:
                    $post[$dil] = array(
                        'kategori'=> $this->kirlet($this->_POST('kategori',$dil)),
                        'url'=> $this->SeoURL($this->table.'_lang',array('name'=>'kategori','value'=>$this->kirlet($this->_POST('kategori',$dil)),'id'=>$id)),
                        'dil'=>$dil
                    );

                endif;
            endforeach;



        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update($this->table,$post['tr'],$id);

            foreach ($this->settings->lang('lang') as $dil=>$title):
               if($dil!='tr') {

                 if(count($this->dbConn->sorgu("select * from $this->tablelang where dil='$dil'  and master_id='$id' "))==1)
                 {
                     $this->dbConn->update($this->tablelang, $post[$dil],array('master_id'=>$id,'dil'=>$dil));

                 }

                   else
                   $this->dbConn->insert($this->tablelang,array_merge($post[$dil],array('dil'=>$dil,'master_id'=>$id)));
               }
              endforeach;
         else:
            // kaydet
            $this->dbConn->insert($this->table,$post['tr'],$id);
            $lastid = $this->dbConn->lastid();
            $this->FileSessionSave($lastid,$this->module);
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
        if($id){
          //  $data = $this->dbConn->tekSorgu("select * from haberler where id='$id'");
            $this->dbConn->sil("DELETE FROM $this->table where id=".$id);
            $this->dbConn->sil("DELETE FROM $this->tablelang where master_id=".$id);
        }
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);


        $ek = "";

        if (isset($_GET["kelime"])){
            $ek = "WHERE baslik LIKE '%".$_GET["kelime"]."%' or detay LIKE '%".$_GET["kelime"]."%'";
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

        return $pagelist->Pagelist(array(
            'title'=> 'Kategori Listesi',
            'page'=>'kategoriler',
            'button' => array(array('title'=>'Haber Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'kategori', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),


            //'buton'=> array(array('type'=>'radio','dataname'=>'aktif','url'=>$this->BaseAdminURL($this->modulName.'/durum/')), array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','dataname'=>'fotoekle','url'=>$this->BaseAdminURL($this->modulName.'/fotoekle/'))),

            'pdata' => $this->dbConn->sorgu("select * from $this->table $ek order by  sira LIMIT $gecerli,$sayfaLimit"),
            'toplamVeri'=>$toplamVeri,
            'ek'=>$ek,
            'search'=>true,
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'70%'),
                //array('title'=>'Aktif','width'=>'7%'),
                //array('title'=>'Resim Ekle','width'=>'7%')
            )

        ));


    }



    public function fotoekle($id=0)
    {


        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from '.$this->table.' WHERE id='.$id);

        $baslik = $this->permalink($this->temizle($urun["kategori"]));
        $this->icbaslik = 'Resim Ekle';
        $pagelist = new Pagelist($this->settings);
        return $pagelist->Fotolist(array(
            'title'=> 'Resim Listesi',
            'icbaslik' => $this->icbaslik,
            'id'=>$id,
            'page'=>'dosyalar',
            'pfolder'=>'../'.$this->settings->config('folder').$this->module."/",
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

            'dosya' => $this->_RESIM('fotoResim'));

        // Güncelle
        if(isset($id) and $id):
            $this->dbConn->update('dosyalar',$post,$id);

        endif;
        $fotoid = $this->dbConn->tekSorgu("select * from dosyalar where id='$id'");
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/fotoekle/'.$fotoid['data_id']));
    }




    public function durum($id=null)
    {
        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);

        $bayiDuzenle = $this->dbConn->update($this->table,array('aktif'=>$durum),$id);
        $langDuzenle = $this->dbConn->langUpdate($this->tablelang,array('aktif'=>$durum),$id);

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
