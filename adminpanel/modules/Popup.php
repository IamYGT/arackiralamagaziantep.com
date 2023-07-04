<?php
namespace AdminPanel;

use AdminPanel\Form;

class Popup extends Settings  {

    public $SayfaBaslik = '';
    public $modulName = 'Popup';
    public $icbaslik ;
    private  $table ='siparisler';

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

        $text .= $form->link(array('value'=>((isset($data['link']) ? $data['link'] :'')),'title'=>'1. Link','name'=>'link','id'=>'link','help'=>' '));
        $text .= $form->input(array('value'=>((isset($data['fiyat']) ? $data['fiyat'] :'')),'title'=>'1. Fiyatı','name'=>'fiyat','id'=>'fiyat','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['kargo']) ? $data['kargo'] :'')),'title'=>'1. Kargo','name'=>'kargo','id'=>'kargo','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['tur']) ? $data['tur'] :'')),'title'=>'1. Numara','name'=>'tur','id'=>'tur','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['beden']) ? $data['beden'] :'')),'title'=>'1. Beden','name'=>'beden','id'=>'beden','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['renk']) ? $data['renk'] :'')),'title'=>'1. Renk','name'=>'renk','id'=>'renk','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['aciklama']) ? $data['aciklama'] :'')),'title'=>'1. Not','name'=>'aciklama','id'=>'aciklama','help'=>''));

        $text .= $form->link(array('value'=>((isset($data['link1']) ? $data['link1'] :'')),'title'=>'2.link','name'=>'link1','id'=>'link1','help'=>' '));
        $text .= $form->input(array('value'=>((isset($data['fiyat1']) ? $data['fiyat1'] :'')),'title'=>'2. Fiyatı','name'=>'fiyat1','id'=>'fiyat1','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['kargo1']) ? $data['kargo1'] :'')),'title'=>'2. Kargo','name'=>'kargo1','id'=>'kargo1','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['tur1']) ? $data['tur1'] :'')),'title'=>'2. Numara','name'=>'tur1','id'=>'tur1','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['beden1']) ? $data['beden1'] :'')),'title'=>'2. Beden','name'=>'beden1','id'=>'beden1','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['renk1']) ? $data['renk1'] :'')),'title'=>'2. Renk','name'=>'renk1','id'=>'renk1','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['aciklama1']) ? $data['aciklama1'] :'')),'title'=>'2. Not','name'=>'aciklama1','id'=>'aciklama1','help'=>''));

        $text .= $form->link(array('value'=>((isset($data['link2']) ? $data['link2'] :'')),'title'=>'3.link','name'=>'link2','id'=>'link2','help'=>' '));
        $text .= $form->input(array('value'=>((isset($data['fiyat2']) ? $data['fiyat2'] :'')),'title'=>'3. Fiyatı','name'=>'fiyat2','id'=>'fiyat2','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['kargo2']) ? $data['kargo2'] :'')),'title'=>'3. Kargo','name'=>'kargo2','id'=>'kargo2','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['tur2']) ? $data['tur2'] :'')),'title'=>'3. Numara','name'=>'tur2','id'=>'tur2','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['beden2']) ? $data['beden2'] :'')),'title'=>'3. Beden','name'=>'beden2','id'=>'beden2','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['renk2']) ? $data['renk2'] :'')),'title'=>'3. Renk','name'=>'renk1','id'=>'renk1','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['aciklama2']) ? $data['aciklama2'] :'')),'title'=>'3. Not','name'=>'aciklama2','id'=>'aciklama2','help'=>''));

        // $text .= $form->link(array('value'=>((isset($data['link3']) ? $data['link3'] :'')),'title'=>'4.link','name'=>'link1','id'=>'link3','help'=>' '));
        // $text .= $form->input(array('value'=>((isset($data['fiyat3']) ? $data['fiyat3'] :'')),'title'=>'4. Fiyatı','name'=>'fiyat3','id'=>'fiyat3','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['kargo3']) ? $data['kargo3'] :'')),'title'=>'4. Kargo','name'=>'kargo3','id'=>'kargo3','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['tur3']) ? $data['tur3'] :'')),'title'=>'4. Numara','name'=>'tur3','id'=>'tur3','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['beden3']) ? $data['beden3'] :'')),'title'=>'4. Beden','name'=>'beden3','id'=>'beden3','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['renk3']) ? $data['renk3'] :'')),'title'=>'4. Renk','name'=>'renk3','id'=>'renk3','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['aciklama3']) ? $data['aciklama3'] :'')),'title'=>'4. Not','name'=>'aciklama3','id'=>'aciklama3','help'=>''));
        //
        // $text .= $form->link(array('value'=>((isset($data['link4']) ? $data['link4'] :'')),'title'=>'5. Link','name'=>'link4','id'=>'link4','help'=>' '));
        // $text .= $form->input(array('value'=>((isset($data['fiyat4']) ? $data['fiyat4'] :'')),'title'=>'5. Fiyatı','name'=>'fiyat4','id'=>'fiyat4','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['kargo4']) ? $data['kargo4'] :'')),'title'=>'5. Kargo','name'=>'kargo4','id'=>'kargo4','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['tur4']) ? $data['tur4'] :'')),'title'=>'5. Numara','name'=>'tur4','id'=>'tur4','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['beden4']) ? $data['beden4'] :'')),'title'=>'5. Beden','name'=>'beden4','id'=>'beden4','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['renk4']) ? $data['renk4'] :'')),'title'=>'5. Renk','name'=>'renk4','id'=>'renk4','help'=>''));
        // $text .= $form->input(array('value'=>((isset($data['aciklama4']) ? $data['aciklama4'] :'')),'title'=>'5. Not','name'=>'aciklama4','id'=>'aciklama4','help'=>''));

        $text .= $form->input(array('value'=>((isset($data['secim']) ? $data['secim'] :'')),'title'=>'Paket Seçimi','name'=>'secim','id'=>'secim','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['birlestirme']) ? $data['birlestirme'] :'')),'title'=>'Paket Birleştirme','name'=>'birlestirme','id'=>'birlestirme','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['kontrol']) ? $data['kontrol'] :'')),'title'=>'Paket Kontrol','name'=>'kontrol','id'=>'kontrol','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['sigorta']) ? $data['sigorta'] :'')),'title'=>'Sigortalı Gönderim','name'=>'sigorta','id'=>'sigorta','help'=>''));
        $text .= $form->input(array('value'=>((isset($data['uye_id']) ? $data['uye_id'] :'')),'title'=>'Üye ID','name'=>'uye_id','id'=>'uye_id','help'=>''));
        //$text .= $form->submitButton();
        $text .= $form->formClose();
        //$modal = new Widget($this->settings);
        //$text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;
    }
    public function kaydet($id=null)
    {
        $post = array(
            'link' => $this->_POST('link'),
            'fiyat'=> $this->_POST('fiyat'),
            'kargo' => $this->_POST('kargo'),
            'tur' => $this->_POST('tur'),
            'beden' => $this->_POST('beden'),
            'renk' => $this->_POST('renk'),
            'aciklama' => $this->_POST('aciklama'),
            'secim' => $this->_POST('secim'),
            'birlestirme' => $this->_POST('birlestirme'),
            'kontrol' => $this->_POST('kontrol'),
            'sigorta' => $this->_POST('sigorta'),
            'link1' => $this->_POST('link1'),
            'fiyat1'=> $this->_POST('fiyat1'),
            'kargo1' => $this->_POST('kargo1'),
            'tur1' => $this->_POST('tur1'),
            'beden1' => $this->_POST('beden1'),
            'renk1' => $this->_POST('renk1'),
            'aciklama1' => $this->_POST('aciklama1'),
        );
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
            'title'=> 'Sipariş Listesi',
            'page'=>'Popup',
            //'button' => array(array('title'=>'Siparişler','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'link', 'class'=>'sort'),
                array('dataTitle'=>'fiyat', 'class' => 'sort'),
                array('dataTitle'=>'kargo', 'class' => 'sort'),
                array('dataTitle'=>'tur', 'class' => 'sort'),
                array('dataTitle'=>'beden', 'class' => 'sort'),
                array('dataTitle'=>'renk', 'class' => 'sort'),
                array('dataTitle'=>'uye_id', 'class' => 'sort'),
            ),

            'tools' =>array(array('title'=>'Detay','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            //'buton'=> array(array('type'=>'radio','dataname'=>'aktif','url'=>$this->BaseAdminURL($this->modulName.'/durum/'))),
            'pdata' => $this->dbConn->sorgu('select *, (SELECT firmadi from uyelik WHERE siparisler.uye_id = uyelik.id) as uye_id from '.$this->table.' ORDER BY id ASC'),
            //'pdata' => $this->dbConn->sorgu('select * from '.$this->table.' ORDER BY id ASC'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'3%'),
                array('title'=>'link','width'=>'8%'),
                array('title'=>'fiyat','width'=>'8%'),
                array('title'=>'kargo','width'=>'8%'),
                array('title'=>'tur','width'=>'8%'),
                array('title'=>'beden','width'=>'8%'),
                array('title'=>'renk','width'=>'8%'),
                array('title'=>'uyeid','width'=>'8%'),
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
