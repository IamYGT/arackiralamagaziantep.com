<?php


namespace AdminPanel;

use AdminPanel\Form;

class Basindabiz extends Settings  {

    public  $SayfaBaslik = 'Basindabiz';
    public  $modulName = 'Basindabiz';
    public  $icbaslik ;
    private $js = array();
    private $css = array();
    private $module='basin';
    private $table ='basindabiz';
    private $tablelang = 'basindabiz_lang';




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
        $this->icbaslik = 'Basın Haberi Ekle';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
       if($id) $data = $tabs->tabData($this->table,$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']  = $form->input(array('value'=>((isset($data[$dil]['baslik']) ? $data[$dil]['baslik'] :'')),'title'=>'Haber Başlığı','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->textarea(array('value'=>((isset($data[$dil]['ozet']) ? $data[$dil]['ozet'] :'')),'title'=>'Özet','name'=>'ozet','id'=>'ozet','help'=>'Özeti buraya girebilirsiniz.','height'=>'120','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay']) ? $this->temizle($data[$dil]['detay']) :'')),'title'=>'Haber Detayı','name'=>'detay','id'=>'haberDetay','height' => '350','lang'=>$dil));
         // $tabForm[$dil]['text'].= $form->input(array('value'=>((isset($haber['baslik']) ? $haber['baslik'] :'')),'title'=>'Haber Başlığı','name'=>'baslik','id'=>'baslik','help'=>''));
         endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Haber Resmi','name'=>'HaberResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('haber'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $fileUpload = $modal->fileLoad(['name'=>'files','params' => array('modul'=>$this->module,'folder'=>'../'.$this->settings->config('folder').$this->module.'/','baslik'=>'baslik_tr','id'=>$id),'sql'=>(($id) ? $this->dbConn->sorgu("select * from dosyalar where type='{$this->module}' and data_id='$id' ORDER   BY  sira"):array())]);
        $text .= $modal->infoform(array('title'=>'Ek Resim Yükle','govde'=>$fileUpload));
        return $text;


    }

    public function kaydet($id=null)
    {

            foreach ($this->settings->lang('lang') as $dil=>$title):
              if($dil == "tr"):
                    $post[$dil] = array(
                        'baslik'=> $this->_POST('baslik',$dil),
                        'tarih' =>date('m/d/Y H:i:s'),
                        'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                        'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),
                        'dil'=>$dil,
                        // 'kid'=> $this->_POST('kid',$dil),
                        'url'=> $this->SeoURL($this->table,array('name'=>'baslik','value'=>$this->_POST('baslik',$dil),'id'=>$id)),
                        'resim' => $this->_RESIM('HaberResim_tr'));


                else:
                    $post[$dil] = array(
                        'baslik'=> $this->_POST('baslik',$dil),
                        'detay'=>$this->kirlet($this->_POST('detay',$dil)),
                        'url'=> $this->SeoURL($this->table.'_lang',array('name'=>'baslik','value'=>$this->_POST('baslik',$dil),'id'=>$id)),
                        'ozet'=>$this->kirlet($this->_POST('ozet',$dil)),
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
                    unset($post[$dil]['resim']);
                    unset($post[$dil]['tarih']);
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

        return $pagelist->Pagelist(array(
            'title'=> 'Basın Haberi Listesi',
            'page'=>'haberler',
            'button' => array(array('title'=>'Haber Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu("select * from $this->table  order by  sira"),
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
        $text = '';
        foreach($this->js as $js) $text .= $js;
        return $text;
    }

} 