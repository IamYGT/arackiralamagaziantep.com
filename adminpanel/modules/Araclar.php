<?php

namespace AdminPanel;


class Araclar extends Settings {

    public   $SayfaBaslik = 'Araç Listesi';
    public   $modulName = 'Araclar';
    private  $siteURL;
    private  $set;
    private  $css= array();
    private  $js = array();

    private $module = 'araclar';
    private $table = 'araclar';
    private $tablelang = 'araclar_lang';
    private $table2 = 'ikielaraclar';
    private $tablelang2 = 'ikielaraclar_lang';

    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->siteURL = $this->BaseAdminURL();
        $this->set = $settings;
        $this->AuthCheck();
    }

    /**
     * @param null $id
     * @return string
     */
    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        return $pagelist->Pagelist(array(
            'title'=> 'Araç Listesi',
            'page'=>'araclar',
            'button' => array(array('title'=>'Araç Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'marka', 'class'=>'sort'),
                array('dataTitle'=>'aractipi', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu('select * from '.$this->table.'  order by  sira'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Marka','width'=>'30%'),
                array('title'=>'Araç Tipi','width'=>'30%')
            )

        ));


    }


    public function ikielaracliste($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        return $pagelist->Pagelist(array(
            'title'=> 'İkinci El Araç Listesi',
            'page'=>'araclar',
            'button' => array(array('title'=>'İkinci El Araç Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ikielaracekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'marka', 'class'=>'sort'),
                array('dataTitle'=>'model', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ikielaracekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/ikielaracsil/'),'color'=>'red')),
            'buton'=>array(
                array('type'=>'button2','title'=>'Resim Ekle','class'=>'btn btn-primary','url'=>$this->BaseAdminURL('AracFoto/ResimEkle/'),'modul'=>10,'folder'=>'../'.$this->settings->config('folder').'araclar/')


            ),
            'pdata' => $this->dbConn->sorgu('select * from '.$this->table2.' order by  sira'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Marka','width'=>'30%'),
                array('title'=>'Model','width'=>'30%'),
                array('title'=>'Resim Ekle','width'=>'5%')
            )

        ));


    }

    public function ekle($id=null)
    {
        $this->icbaslik = 'Araç Ekle';
        $tabForm = array();
        $form = new Form($this->set);
        $tabs = new Tabs($this->set);
        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        if($id) $data = $tabs->tabData($this->table,$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']   = $form->select(array('title'=>'Araç Türü','lang'=>$dil,'name'=>'kid','data'=> $form->parent(array('sql'=>"select * from arackat where ",'option'=>array('value'=>'id','title'=>'kategori'),'kat'=>'ustu','selected'=>((isset($data[$dil]['kid']) ? $data[$dil]['kid'] :0)) ),0,0)));
      //     $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['aracismi']) ? $data[$dil]['aracismi'] :'')),'title'=>'Araç İsmi','name'=>'aracismi','id'=>'aracismi','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['marka']) ? $data[$dil]['marka'] :'')),'title'=>'Marka','name'=>'marka','id'=>'marka','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['aractipi']) ? $data[$dil]['aractipi'] :'')),'title'=>'Araç Tipi','name'=>'aractipi','id'=>'aractipi','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['versiyon']) ? $data[$dil]['versiyon'] :'')),'title'=>'Versiyon','name'=>'versiyon','id'=>'versiyon','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['modelyili']) ? $data[$dil]['modelyili'] :'')),'title'=>'Model Yılı','name'=>'modelyili','id'=>'modelyili','help'=>'','lang'=>$dil));
           // $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['kamaci']) ? $data[$dil]['kamaci'] :'')),'title'=>'Kasa Tipi','name'=>'kasatipi','id'=>'kasatipi','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['kamaci']) ? $data[$dil]['kamaci'] :'')),'title'=>'Kullanım Amacı','name'=>'kamaci','id'=>'kamaci','help'=>'','height'=>'120','lang'=>$dil));
            $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['yakittipi']) ? $data[$dil]['yakittipi'] :'')),'title'=>'Yakıt Tipi','name'=>'yakittipi','id'=>'yakittipi','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['vitestipi']) ? $data[$dil]['vitestipi'] :'')),'title'=>'Vites Tipi','name'=>'vitestipi','id'=>'vitestipi','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['silindirhacmi']) ? $data[$dil]['silindirhacmi'] :'')),'title'=>'Silindir Hacmi','name'=>'silindirhacmi','id'=>'silindirhacmi','help'=>'','lang'=>$dil));
           // $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay']) ? $this->temizle($data[$dil]['detay']) :'')),'title'=>'Haber Detayı','name'=>'detay','id'=>'haberDetay','height' => '350','lang'=>$dil));
            // $tabForm[$dil]['text'].= $form->input(array('value'=>((isset($haber['baslik']) ? $haber['baslik'] :'')),'title'=>'Haber Başlığı','name'=>'baslik','id'=>'baslik','help'=>''));
        endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Araç Resmi','name'=>'AracResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('arac'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :''),'help'=>'Araç Resimleri 870x600 boyutlarında olmalıdır.'));
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
            $post[$dil] = array(
             //   'aracismi'=> $this->_POST('aracismi_'.$dil),
                'marka'=> $this->_POST('marka_'.$dil),
                'aractipi'=> $this->_POST('aractipi_'.$dil),
                'versiyon'=> $this->_POST('versiyon_'.$dil),
                'modelyili'=> $this->_POST('modelyili_'.$dil),
                'kamaci'=> $this->_POST('kamaci_'.$dil),
                'yakittipi'=> $this->_POST('yakittipi_'.$dil),
                'vitestipi'=> $this->_POST('vitestipi_'.$dil),
                'silindirhacmi'=> $this->_POST('silindirhacmi_'.$dil),
                'tarih' =>date('m/d/Y H:i:s'),
                //  'detay'=>$this->kirlet($this->_POST('detay_'.$dil)),
                //'ozet'=>$this->kirlet($this->_POST('ozet_'.$dil)),
                'dil'=>$dil,
                'kid'=> $this->_POST('kid_'.$dil),
                'url'=> strtolower($this->perma($this->_POST('aracismi_'.$dil))),
                'resim' => $this->_RESIM('AracResim_tr'));

        if($dil!="tr") unset($post[$dil]['resim']);
        endforeach;

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update($this->table,$post['tr'],$id);
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {
                    if(count($this->dbConn->sorgu("select * from ".$this->tablelang." where dil='$dil'  and master_id='$id' "))==1)
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

    public function ikielaracekle($id=null)
    {
        $this->icbaslik = '2. El Araç Ekle';
        $tabForm = array();
        $form = new Form($this->set);
        $tabs = new Tabs($this->set);
        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/ikielarackaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        if($id) $data = $tabs->tabData($this->table2,$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
          //  $tabForm[$dil]['text']   = $form->input(array('value'=>((isset($data[$dil]['aracismi']) ? $data[$dil]['aracismi'] :'')),'title'=>'Araç İsmi','name'=>'aracismi','id'=>'aracismi','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text']  = $form->input(array('value'=>((isset($data[$dil]['marka']) ? $data[$dil]['marka'] :'')),'title'=>'Marka','name'=>'marka','id'=>'marka','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['model']) ? $data[$dil]['model'] :'')),'title'=>'Model','name'=>'model','id'=>'model','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['modelyili']) ? $data[$dil]['modelyili'] :'')),'title'=>'Model Yılı','name'=>'modelyili','id'=>'modelyili','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['versiyon']) ? $data[$dil]['versiyon'] :'')),'title'=>'Versiyon','name'=>'versiyon','id'=>'versiyon','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['renk']) ? $data[$dil]['renk'] :'')),'title'=>'Renk','name'=>'renk','id'=>'renk','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['kasa']) ? $data[$dil]['kasa'] :'')),'title'=>'Kasa','name'=>'kasa','id'=>'kasa','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['vites']) ? $data[$dil]['vites'] :'')),'title'=>'Vites Tipi','name'=>'vites','id'=>'vites','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['yakit']) ? $data[$dil]['yakit'] :'')),'title'=>'Yakıt Tipi','name'=>'yakit','id'=>'yakit','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['fiyat']) ? $data[$dil]['fiyat'] :'')),'title'=>'Fiyat','name'=>'fiyat','id'=>'fiyat','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->input(array('value'=>((isset($data[$dil]['kilometre']) ? $data[$dil]['kilometre'] :'')),'title'=>'Kilometre','name'=>'kilometre','id'=>'kilometre','help'=>'','lang'=>$dil));
            $tabForm[$dil]['text'] .= $form->textarea(array('value'=>((isset($data[$dil]['aciklama']) ? $data[$dil]['aciklama'] :'')),'title'=>'Açıklama','name'=>'aciklama','id'=>'aciklama','help'=>'','height'=>'120','lang'=>$dil));

            // $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['silindirhacmi']) ? $data[$dil]['silindirhacmi'] :'')),'title'=>'Silindir Hacmi','name'=>'silindirhacmi','id'=>'silindirhacmi','help'=>'','lang'=>$dil));
            // $tabForm[$dil]['text'] .= $form->textEditor(array('value'=>((isset($data[$dil]['detay']) ? $this->temizle($data[$dil]['detay']) :'')),'title'=>'Haber Detayı','name'=>'detay','id'=>'haberDetay','height' => '350','lang'=>$dil));
            // $tabForm[$dil]['text'].= $form->input(array('value'=>((isset($haber['baslik']) ? $haber['baslik'] :'')),'title'=>'Haber Başlığı','name'=>'baslik','id'=>'baslik','help'=>''));
        endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Araç Resmi','name'=>'AracResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('2elarac'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));
         $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $fileUpload = $modal->fileLoad(['name'=>'files','params' => array('modul'=>$this->module,'folder'=>'../'.$this->settings->config('folder').$this->module.'/','baslik'=>'baslik_tr','id'=>$id),'sql'=>(($id) ? $this->dbConn->sorgu("select * from dosyalar where type='{$this->module}' and data_id='$id' ORDER   BY  sira"):array())]);
        $text .= $modal->infoform(array('title'=>'Ek Resim Yükle','govde'=>$fileUpload));
        return $text;


    }

    public function ikielarackaydet($id=null)
    {

        foreach ($this->settings->lang('lang') as $dil=>$title):
            $post[$dil] = array(
             // 'aracismi'=> $this->_POST('aracismi_'.$dil),
                'marka'=> $this->_POST('marka_'.$dil),
                'model'=> $this->_POST('model_'.$dil),
                'versiyon'=> $this->_POST('versiyon_'.$dil),
                'modelyili'=> $this->_POST('modelyili_'.$dil),
                'renk'=> $this->_POST('renk_'.$dil),
                'kasa'=> $this->_POST('kasa_'.$dil),
                'vites'=> $this->_POST('vites_'.$dil),
                'fiyat'=> $this->_POST('fiyat_'.$dil),
                'kilometre'=> $this->_POST('kilometre_'.$dil),
                'yakit'=> $this->_POST('yakit_'.$dil),
                'aciklama'=> $this->_POST('aciklama_'.$dil),
            //  'silindirhacmi'=> $this->_POST('silindirhacmi_'.$dil),
                'tarih' =>date('m/d/Y H:i:s'),
            //  'detay'=>$this->kirlet($this->_POST('detay_'.$dil)),
            //  'ozet'=>$this->kirlet($this->_POST('ozet_'.$dil)),
                'dil'=>$dil,
             //   'kid'=> $this->_POST('kid_'.$dil),
                'url'=> strtolower($this->perma($this->_POST('aracismi_'.$dil))),
                'resim' => $this->_RESIM('AracResim_tr'));

            if($dil!="tr") unset($post[$dil]['resim']);
        endforeach;

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update($this->table2,$post['tr'],$id);
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {
                    if(count($this->dbConn->sorgu("select * from ".$this->tablelang2." where dil='$dil'  and master_id='$id' "))==1)
                    {
                        $this->dbConn->update($this->tablelang2, $post[$dil],array('master_id'=>$id,'dil'=>$dil));
                    }
                    else
                        $this->dbConn->insert($this->tablelang2,array_merge($post[$dil],array('dil'=>$dil,'master_id'=>$id)));
                }
            endforeach;
        else:
            // kaydet
            $this->dbConn->insert($this->table2,$post['tr'],$id);
            $lastid = $this->dbConn->lastid();
            $this->FileSessionSave($lastid,$this->module);
            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    $this->dbConn->insert($this->tablelang2, array_merge($post[$dil], array('dil' => $dil, 'master_id' => $lastid)));
                }
            endforeach;
        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/ikielaracliste.html'));
    }


    public function sil($id=null)
    {
        if($id){
            $this->dbConn->sil("DELETE FROM ".$this->table." where  id=".$id);
            $this->dbConn->sil("DELETE FROM ".$this->$this->tablelang." where  master_id=".$id);

        }
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }


    public function ikielaracsil($id=null)
    {
        if($id) {
            $this->dbConn->sil("DELETE FROM ".$this->table2." where  id=".$id);
            $this->dbConn->sil("DELETE FROM ".$this->tablelang2." where  master_id=".$id);

        }
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/ikielaracliste.html'));
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
