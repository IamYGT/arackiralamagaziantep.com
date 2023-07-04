<?php
namespace AdminPanel;

class Slayt extends Settings
{

    public $settings;

    public $SayfaBaslik = 'Slayt';

    public  $modulName = 'Slayt';

    private $table ='slayt';

    private $tablelang = 'slayt_lang';

    private $module = "slayt";



    public function __construct($settings)

    {

        parent::__construct($settings);

        $this->settings = $settings;

        $this->AuthCheck();

    }



    public function index()

    {

        return 'Slayt';

    }





    public function ekle($id=null)

    {



       $this->icbaslik = 'Slayt Ekle';

       /*
        if(isset($id) and $id) $haber = $this->dbConn->tekSorgu('select * from slayt WHERE id='.$id);

        $text = '';

        $form = new Form($this->settings);

        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));

        $text .= $form->input(array('value'=>((isset($haber['baslik']) ? $haber['baslik'] :'')),'title'=>'Başlık (Siyah Renk)','name'=>'baslik','id'=>'baslik','help'=>''));

        $text .= $form->input(array('value'=>((isset($haber['baslik_sari']) ? $haber['baslik_sari'] :'')),'title'=>'Başlık (Sarı Renk)','name'=>'baslik_sari','id'=>'baslik','help'=>''));

        $text .= $form->input(array('value'=>((isset($haber['detay']) ? $haber['detay'] :'')),'title'=>'Slayt Detayı','name'=>'detay','id'=>'detay','help'=>''));

        $text .= $form->input(array('value'=>((isset($haber['link']) ? $haber['link'] :'')),'title'=>'Link','name'=>'link','id'=>'link','help'=>''));



        $text .= $form->file(array('url'=>$this->BaseURL('upload'),'title'=>'Slayt Resim','name'=>'slaytResim','resimBoyut'=>$this->settings->boyut('slayt'),'src'=>((isset($haber['resim'])) ? $haber['resim'] :'')));



        $text .= $form->submitButton();

        $text .= $form->formClose();

        $modal = new Widget($this->settings);

        $text .= $modal->infoform(array('title'=>'','govde'=>''));

        return $text;
    */

        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);



       $this->icbaslik = 'Slayt Ekle';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));

       if($id) $data = $tabs->tabData($this->table,$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']  = $form->input(array('value'=>((isset($data[$dil]['baslik']) ? $this->temizle($data[$dil]['baslik']) :'')),'title'=>'Slogan (Büyük)','name'=>'baslik','id'=>'baslik','help'=>'','lang'=>$dil));

            $tabForm[$dil]['text']  .= $form->input(array('value'=>((isset($data[$dil]['baslik_sari']) ? $this->temizle($data[$dil]['baslik_sari']) :'')),'title'=>'Slogan (Küçük)','name'=>'baslik_sari','id'=>'baslik_sari','help'=>'','lang'=>$dil));

        endforeach;

        $text .= $tabs->tabContent($tabForm);

        $text .= $form->file(array('url'=>$this->BaseURL("upload").'/'.$this->module,'folder'=>$this->module,'title'=>'Slayt Resmi','name'=>'slaytResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('slayt'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));

        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();


        return $text;





    }





    public function kaydet($id=null)

    {
        /*
        $post = array(

            'baslik'=> $this->_POST('baslik'),

            'baslik_sari'=> $this->_POST('baslik_sari'),

            'detay'=> $this->_POST('detay'),

            'resim' => $this->_RESIM('slaytResim'),

            'link' => $this->_POST('link')

        );







        if(isset($id) and $id):

            $this->dbConn->update('slayt',$post,$id);

        else:

            $this->dbConn->insert('slayt',$post);

        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
        */

         foreach ($this->settings->lang('lang') as $dil=>$title):
              if($dil == "tr"):
                    $post[$dil] = array(
                        'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),

                        'baslik_sari'=> $this->kirlet($this->_POST('baslik_sari', $dil)),

                        'resim' => $this->_RESIM('slaytResim_tr'),
                        'dil'=>$dil

                    );

                else:
                    $post[$dil] = array(
                        'baslik'=> $this->kirlet($this->_POST('baslik',$dil)),
                        'baslik_sari'=> $this->kirlet($this->_POST('baslik_sari', $dil)),

                        'dil'=>$dil
                    );
                endif;
            endforeach;



        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update($this->table,$post['tr'],$id);

            foreach ($this->settings->lang('lang') as $dil=>$title):
               if($dil!='tr') {

                 if(count($this->dbConn->sorgu("select * from $this->tablelang where dil='$dil' and master_id='$id' "))==1)
                 {
                     $this->dbConn->update($this->tablelang, $post[$dil],array('master_id'=>$id,'dil'=>$dil));

                 }

                   else {
                   $this->dbConn->insert($this->tablelang,array_merge($post[$dil],array('dil'=>$dil,'master_id'=>$id)));
                    }
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
        ob_start();
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }



    public function sil($id=null)

    {

        $rec2 = $this->dbConn->tekSorgu("SELECT * FROM $this->table WHERE id='$id'");

        $resim2= $this->resimGet($rec2["resim"]);

        $this->ResimSil($resim2,"../".$this->settings->config('folder')."/"); // Eski resmi sil

        if($id) $this->dbConn->sil('DELETE FROM slayt where id='.$id);

        if($id) $this->dbConn->sil('DELETE FROM slayt_lang where master_id='.$id);

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));

    }
    /**
     * @param null $id
     * @return string
     */
    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);
        return $pagelist->Pagelist(array(

            'title'=> 'Slayt Listesi',
            'page'=>'Slayt',
            'button' => array(array('title'=>'Slayt Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'red')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                            array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'buton'=> array(array('type'=>'radio','dataname'=>'vitrin','url'=>$this->BaseAdminURL($this->modulName.'/durum/'))),
            'pdata' => $this->dbConn->sorgu('select * from slayt ORDER   BY  sira,id'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Slogan','width'=>'60%'),
                array('title'=>'Aktif','width'=>'5%')
            )
        ));
    }
    public function durum($id=null)
    {
      $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);
      $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        if($this->dbConn->update('slayt',array('vitrin'=>$durum),$id)) echo 1;else echo 0;
        exit;
    }
    public function CustomPageCss($url)

    {

        // Sadece bu sayfa için gerekli Stil dosyaları eklenebilir

        $text = '';

        if(isset($this->css ) and is_array($this->css ))

        foreach($this->css as $css) $text .= $css;

        return $text;



    }





    public function CustomPageJs($url)

    {

        // Sadece bu sayfa için gerekli javascript dosyaları eklenebilir

        $text = '';

        if(isset($this->js ) and is_array($this->js ))

        foreach($this->js as $js) $text .= $js;

        return $text;

    }



}
