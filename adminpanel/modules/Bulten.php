<?php

namespace AdminPanel;

use AdminPanel\Form;

class Bulten extends Settings  {

    public $SayfaBaslik = 'E-Bülten';
    public  $modulName = 'Bulten';
    public $icbaslik ;
    private $js = array();
    private $css = array();
    private $set;


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

        $this->icbaslik = 'E-posta Ekle';
        if(isset($id) and $id) $haber = $this->dbConn->tekSorgu('select * from bulten WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        $text .= $form->input(array('value'=>((isset($haber['email']) ? $haber['email'] :'')),'title'=>'E-Posta','name'=>'email','id'=>'email','help'=>''));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));


        return $text;

    }


    public function kaydet($id=null)
    {

        $post = array('email'=> $this->_POST('email'),);
        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update('bulten',$post,$id);
        else:
            // kaydet
            $this->dbConn->insert('bulten',$post);
        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));

    }

    public function sil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM bulten where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    /**
     * @param null $id
     * @return string
     */
    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);
       $html ='';

        $html .= $pagelist->Pagelist(array(
            'title'=> 'E-posta Listesi',
            'button' => array(array('title'=>'E-posta Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'red'),
                //array('title'=>'E-posta Listesi','href'=>'','color'=>'green','data'=>array('target'=>'#bultenmodal','toggle'=>'modal'),'icon'=>'fa fa-list')
            ),
            'page'=>'bulten',
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'email', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'buton'=> array(
                //array('type'=>'radio','dataname'=>'durum','url'=>$this->BaseAdminURL($this->modulName.'/durum/'))
            ),
            'pdata' => $this->dbConn->sorgu('select * from bulten ORDER   BY  id'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'70%'),
                //array('title'=>'Aktif','width'=>'5%')
            )

        ));

        $modal = new Widget($this->settings);
        $html .=  $modal->bulten($this->dbConn->sorgu('select * from bulten order by id desc'),'bultenmodal');

        return $html;
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