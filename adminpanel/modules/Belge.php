<?php

namespace AdminPanel;

use AdminPanel\Form;

class Belge extends Settings  {

    public $SayfaBaslik = 'Serfikalar';
    public  $modulName = 'Belge';
    public $icbaslik ;
    private $js = array();
    private $css = array();
    private $set;
    private $module = 'sertifika';
    private $table = 'sertifika';
    private $tablelang = 'sertifika_lang';


    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

    public function index()
    {

    }




    public function ekle($id=null)
    {

        $this->icbaslik = 'Serfika Ekle';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        if($id) $data = $tabs->tabData($this->table,$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']  = $form->input(array('value'=>((isset($data[$dil]['ad']) ? $data[$dil]['ad'] :'')),'title'=>'Belge Adı','name'=>'ad','id'=>'ad','help'=>'','lang'=>$dil));
        endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Resim','name'=>'belgeResim','resimBoyut'=>$this->settings->boyut('belge'),'src'=>((isset($data['tr']['resim']) ? $data['tr']['resim'] :''))));

        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;




    }



    public function kaydet($id=null)
    {

        $tablename = "sertifika";


        foreach ($this->settings->lang('lang') as $dil=>$title):


            if($dil == "tr"):
                $post[$dil] = array(
                    'ad'=> $this->_POST('ad',$dil),
                    'dil'=>$dil,
                    'resim' => $this->_RESIM('belgeResim'));




            else:
                $post[$dil] = array(
                    'ad'=> $this->_POST('ad',$dil),
                    'dil'=>$dil


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
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));

/*
        $post = array(
            'ad'=> $this->_POST('ad_tr'),
            'ad1'=> $this->_POST('ad1_en'),
          // 'detay'=>$this->kirlet($this->_POST('detay')),
            // 'kid'=> $this->_POST('kid'),
            //'url'=> strtolower($this->perma($this->_POST('baslik'))),
            'resim' => $this->_RESIM('belgeResim')
        );

        if(isset($id) and $id):
            $this->dbConn->update('sertifika',$post,$id);
        // kaydet
        else:
            $this->dbConn->insert('sertifika',$post);
        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));

*/
    }

    public function sil($id=null)
    {
        if($id){
            $this->dbConn->sil("DELETE FROM sertifika where id=".$id);
            $this->dbConn->sil("DELETE FROM sertifika_lang where master_id=".$id);
        }
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
            'title'=> 'Sertifika Listesi',
            'button' => array(array('title'=>'Sertifika Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'ad', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu('select * from sertifika ORDER   BY  sira'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'60%')
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