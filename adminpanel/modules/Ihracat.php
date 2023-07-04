<?php

namespace AdminPanel;

use AdminPanel\Form;

class Ihracat extends Settings  {

    public $SayfaBaslik = 'İhracat';
    public  $modulName = 'Ihracat';
    public $icbaslik ;
    private $js = array();
    private $css = array();
    private $module = 'ihracat';
    private $table = 'ihracat';
    private $tablelang = 'ihracat';



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

        $this->icbaslik = 'Ülke Ekle';
        if(isset($id) and $id) $ihracat = $this->dbConn->tekSorgu('select * from '.$this->table.' WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        $text .= $form->input(array('value'=>((isset($ihracat['ulke']) ? $ihracat['ulke'] :'')),'title'=>'Ülke Adı','name'=>'ulke','id'=>'ulke','help'=>''));
        $text .= $form->harita(array('url'=>$this->BaseAdminURL('ayar/harita'.((isset($id)) ? '/'.$id :'')),'value'=>((isset($ihracat['kordinant']) ? $ihracat['kordinant'] :'')),'title'=>'Ülkeyi Haritadan Seçiniz', 'name'=>'kordinant','id'=>'title','help'=>''));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;


    }



    public function kaydet($id=null)
    {


        $post = array(
            'ulke'=> $this->_POST('ulke'),
            'kordinant'=>$this->_POST('kordinant'),
            // 'kid'=> $this->_POST('kid'),
            //'url'=> strtolower($this->perma($this->_POST('baslik'))),
            //'resim' => $this->_RESIM('urunResim')
        );

        if(isset($id) and $id):
            $this->dbConn->update($this->table,$post,$id);
        // kaydet
        else:
            $this->dbConn->insert($this->table,$post);
        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function sil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM '.$this->table.' where id='.$id);
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
            'title'=> 'Ülke Listesi',
            'button' => array(array('title'=>'Ülke Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'ulke', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu('select * from '.$this->table.' ORDER   BY  sira'),
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