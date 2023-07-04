<?php
namespace AdminPanel;

use AdminPanel\Form;

class Bakiye extends Settings  {

    public $SayfaBaslik = 'Bakiye';
    public $modulName = 'Bakiye';
    public $icbaslik ;
    private  $table ='bakiye';


    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

    public function index($id=null)
    {
        $this->liste($id);
    }

    public function ekle($id=null)
    {
        $this->icbaslik = 'Siparişler';
        if(isset($id) and $id) $data = $this->dbConn->tekSorgu('select * from '.$this->table.' WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($data['bakiye']) ? $data['bakiye'] :'')),'title'=>'Bakiye','name'=>'bakiye','id'=>'bakiye','help'=>' '));
        $text .= $form->submitButton();
        $text .= $form->formClose();
        //$modal = new Widget($this->settings);
        //$text .= $modal->infoform(array('title'=>'','govde'=>''));

        /*ÜYE HAREKELETLERİ SORGUSU*/

        if(isset($id) and $id) $bakiye_sorgu = $this->dbConn->tekSorgu('select sum(bakiye) as bakiye  from bakiye where kid = '.$id);

        $bakiye_toplam =  $bakiye_sorgu["bakiye"];

        if(isset($id) and $id) $bakiye_hareket = $this->dbConn->sorgu('select *  from bakiye where kid = '.$id);

        foreach ($bakiye_hareket as $deger ) {
            $hareketler .= $deger["tarih"].' tarihinde <b>'.$deger["bakiye"]."</b> tutarında bakiye eklendi.<br> <b>Açıklama:</b>.".$deger["aciklama"]."<hr>";
        }


        $text .= $modal->infoform(array('title'=>'Bakiye Hareketleri','govde'=>'<div><b>Toplam Bakiye : </b> '.$bakiye_toplam.'<br>'.$hareketler.' </div>'));

        return $text;
    }

    public function kaydet($id=null)
    {
        $post = array('bakiye' => $this->_POST('bakiye'),);
        if(isset($id) and $id):
            $this->dbConn->update($this->table,$post,$id);
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
            'title'=> 'Bakiye Yönetimi',
            'page'=>'Popup',
            'button' => array(array('title'=>'Bakiye Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'kid', 'class' => 'sort'),

                array('dataTitle'=>'bakiye', 'class'=>'sort'),
            ),

            'tools' =>array(array('title'=>'Detay','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            //'buton'=> array(array('type'=>'radio','dataname'=>'aktif','url'=>$this->BaseAdminURL($this->modulName.'/durum/'))),
            //'pdata' => $this->dbConn->sorgu('select * from '.$this->table.' ORDER BY id ASC'),
            'pdata' => $this->dbConn->sorgu('select sum(bakiye) as bakiye, id, (SELECT firmadi from uyelik WHERE bakiye.kid = uyelik.id) as kid from '.$this->table.' GROUP BY kid ORDER BY id ASC'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'3%'),
                array('title'=>'Üye Adı & Soyadı','width'=>'8%'),

                array('title'=>'Toplam Bakiye','width'=>'40%'),
            )

        ));



    }


    public function durum($id=null)
    {

        $durum = $this->_GET('durum');
        $id = $this->_GET('id');
        if($this->dbConn->update($this->table,array('aktif'=>$durum),$id)) echo 1;else echo 0;

        exit;
    }


    public function CustomPageCss($url)
    {
    }


    public function CustomPageJs($url)
    {

    }

}
