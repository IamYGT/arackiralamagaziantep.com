<?php
namespace AdminPanel;
class Galeri extends Settings {
    public $SayfaBaslik = 'Foto Galeri';
    public $modulName = 'galeri';
    public $icbaslik;
    private $table = "fotogaleri";
    private $tablelang = "fotogaleri_lang";
    private $module = 'galeri';
    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }
    public function index($id=nul)
    {
        return $this->liste($id);
    }
    public function ekle($id=null)
    {
       $this->icbaslik = 'Galeri Ekle';
        $text = '';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        if($id) $data = $tabs->tabData($this->table,$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text'] = $form->input(array('value'=>((isset($data[$dil]['baslik'])) ? $this->temizle($data[$dil]['baslik']) :''),'title'=>'Galeri Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));
        endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->file(array('url'=>$this->BaseURL('upload').'/'.$this->module,'folder'=>$this->module,'title'=>'Resim','name'=>'resim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('galeri'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        return $text;
    }
    public function durum($id=null)
    {
        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);
        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        $urunDuzenle = $this->dbConn->update($this->table,array('vitrin'=>$durum),$id);
        $langDuzenle = $this->dbConn->langUpdate($this->tablelang,array('vitrin'=>$durum),$id);
        if($urunDuzenle && $langDuzenle) echo 1;else echo 0;
        exit();
    }
    public function liste($id=null)
    {
        $this->icbaslik = 'Galeri Listesi';
        $pagelist = new Pagelist($this->settings);
        return $pagelist->PageList(array(
            'title'=> 'Galeri Listesi',
            'page'=>'fotogaleri',
            'button' => array(array('title'=>'Galeri Ekle','href'=> $this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(
               array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'buton'=> array(   array('type'=>'radio','dataname'=>'vitrin','url'=>$this->BaseAdminURL($this->modulName.'/durum/')),
              //  array('type'=>'button','title'=>'Resim Ekle','class'=>'btn btn-primary','url'=>$this->BaseAdminURL('Dosya/resimekle'),'modul'=>2,'folder'=>'../'.$this->settings['folder'].'galeri/')
                array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','dataname'=>'durum','url'=>$this->BaseAdminURL($this->modulName.'/fotoekle/'))
            ),
            'pdata' => $this->dbConn->sorgu("select * from fotogaleri where masterid=0 ORDER BY sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'70%'),
                array('title'=>'Aktif','width'=>'5%'),
               array('title'=>'Resimler','width'=>'8%'),
            )
        ));
    }
    public  function kaydet($id=null)
    {
        foreach ($this->settings->lang('lang') as $dil=>$title):
            if($dil == 'tr'):
                $post[$dil] = array(
                    'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                    'resim' => $this->_RESIM('resim_tr'),
                    'dil' => $dil
                );
        else:
            $post[$dil] = array(
                'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                'dil' => $dil
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
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {
                    $this->dbConn->insert($this->tablelang, array_merge($post[$dil], array('master_id' => $lastid)));
                }
            endforeach;
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste'.(($this->_POST('kid_tr')) ? "/".$this->_POST('kid_tr'):'.html')));
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
            'flitpage' => array('title'=>'Galeri Seç','sql'=> "select * from fotogaleri where masterid=0 and  ",'option'=>array('value'=>'id','title'=>'baslik'),'kat'=>'kid','name'=>'fotogaleri'),
            'pfolder'=>'../'.$this->settings->config('folder').$this->module."/",
            'page'=>'dosyalar',
             //'button' => array(array('title'=>'Fotograf Ekle','href'=> $this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'dosya', 'class'=>'sort')
            ),
            'tools' =>array(
               array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/fotoduzenle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/fotosil/'),'color'=>'red')),
            'yukle'=> array('type'=>'button','title'=>'Resim Ekle','class'=>'btn btn-danger','modul'=>$this->module,'folder'=>'../'.$this->settings->config('folder').$this->module."/",'name'=>$baslik, 'baslik'=>$baslik),
            'buton'=> array(
                //array('type'=>'radio','dataname'=>'durum','url'=>$this->BaseAdminURL($this->modulName.'/durum/')),
            ),
            'pdata' => $this->dbConn->sorgu("select * from dosyalar where type='$this->module' and data_id='$id' ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'Sıra No','width'=>'6%'),
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
        $text .= $form->input(array('value'=>((isset($urun['baslik']) ? $urun['baslik'] :'')),'title'=>' <img src="https://cdn..com/admin/assets/flags/tr.png" width="25px" style="margin-right:10px;">Başlık','name'=>'baslik','id'=>'baslik','help'=>''));
        $text .= $form->input(array('value'=>((isset($urun['baslik_en']) ? $urun['baslik_en'] :'')),'title'=>' Başlık','name'=>'baslik','id'=>'baslik','help'=>'', 'lang'=>"en"));
        $text .= $form->input(array('value'=>((isset($urun['baslik_ru']) ? $urun['baslik_ru'] :'')),'title'=>' Başlık','name'=>'baslik','id'=>'baslik','help'=>'', 'lang'=>"ru"));
        $text .= $form->input(array('value'=>((isset($urun['baslik_ar']) ? $urun['baslik_ar'] :'')),'title'=>' Başlık','name'=>'baslik','id'=>'baslik','help'=>'', 'lang'=>"ar"));
        $text .= $form->file(array('url'=>$this->BaseURL('upload')."/".$this->module,'folder'=>$this->module,'title'=>'Resim','name'=>'fotoResim','resimBoyut'=>$this->settings->boyut('galeri'),'src'=>((isset($urun['dosya'])) ? $urun['dosya'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        return $text;
    }
    public  function fotokaydet($id=null)
    {
        $post = array(
            'baslik'=> $this->kirlet($this->_POST('baslik')),
            'baslik_en'=> $this->kirlet($this->_POST('baslik_en')),
            'baslik_ru'=> $this->kirlet($this->_POST('baslik_ru')),
            'baslik_ar'=> $this->kirlet($this->_POST('baslik_ar')),
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
    public function sil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM '.$this->table.' where id='.$id);
        if($id) $this->dbConn->sil('DELETE FROM '.$this->tablelang.' where master_id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }
} 