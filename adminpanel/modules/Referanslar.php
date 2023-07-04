<?php

namespace AdminPanel;

use AdminPanel\Form;

class Referanslar extends Settings  {

    public  $SayfaBaslik = 'Markalar';
    public  $modulName = 'Referanslar';
    public  $icbaslik ;
    private $js = array();
    private $css = array();
    private $module = 3;
    private $table = "referanslar";
    private $tablelang = "referanslar_lang";


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

       $this->icbaslik = 'Marka Ekle';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);

        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        if($id) $data = $tabs->tabData($this->table,$id);
        
        foreach ($this->settings->lang('lang') as $dil=>$title):

            $tabForm[$dil]['text']  = $form->input(array('value'=>((isset($data[$dil]['firma']) ? $this->temizle($data[$dil]['firma']) :'')),'title'=>'Başlık','name'=>'firma','id'=>'firma','help'=>'Firma Adını buraya girebilirsiniz.','lang'=>$dil));

        endforeach;

        $text .= $tabs->tabContent($tabForm);

        $text .= $form->link(array('value'=>((isset($data["tr"]['sehir'])) ? $this->temizle($data["tr"]['sehir']) :''),'title'=>'link','name'=>'sehir','id'=>'sehir','help'=>'','lang'=>"tr"));

        $text .= $form->file(array('url'=>$this->BaseURL("upload").'/referanslar','folder'=>'referanslar','title'=>'Resim','name'=>'refResim','lang'=>'tr','resimBoyut'=>$this->settings->boyut('refResim'),'src'=>((isset($data['tr']['resim'])) ? $data['tr']['resim'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
       
        return $text;

    }

    public function kaydet($id=null)
    {

        foreach ($this->settings->lang('lang') as $dil=>$title):

            if($dil == "tr"):
                $post[$dil] = array(
                    'firma'=> $this->kirlet($this->_POST('firma',$dil)),
                    'sehir'=> $this->kirlet($this->_POST('sehir_tr')),
                    'dil'=>$dil,
                    'resim' => $this->_RESIM('refResim_tr')
                );

            else:
                $post[$dil] = array(
                    'firma'=> $this->kirlet($this->_POST('firma',$dil)),
                    'sehir'=> $this->kirlet($this->_POST('sehir_tr')),
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
               $this->dbConn->insert($this->tablelang, array_merge($post[$dil], array('dil' => $dil, 'master_id' => $lastid)));
                }
            endforeach;
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }



    public function sil($id=null)
    {
       if($id) $this->dbConn->sil('DELETE FROM '.$this->table.' where id='.$id);
       if($id) $this->dbConn->sil('DELETE FROM '.$this->tablelang.' where master_id='.$id);
       $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }


    /**
     * @param null $id
     * @return string
     */
    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        $ek = "";
        
        if (isset($_GET["kelime"])){
            $ek = "WHERE firma LIKE '%".$_GET["kelime"]."%'";
        }


        $toplamVeri = count($this->dbConn->sorgu("select * from $this->table $ek order by  sira"));

        $sayfa = (isset($_GET["sayfa"])) ? $this->kirlet(intval($_GET['sayfa'])) : 1;

        if (!is_numeric($sayfa)){
            $sayfa = 1;
        }

        $sayfaLimit = 50;

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
         'title'=> 'Marka Listesi',
         'sayfaLimit'=>$sayfaLimit,
         'page'=>$this->modulName,
         'button' => array(array('title'=>'Referans Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'red')),
         'p'=>array(
                      array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                      array('dataTitle'=>'firma', 'class'=>'sort')
                  ),
         'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                         array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),

          'buton'=> array(array('type'=>'radio','dataname'=>'durum','url'=>$this->BaseAdminURL($this->modulName.'/vitrin/')),
        

          ),
         
         'pdata' => $this->dbConn->sorgu("select * from $this->table $ek order by  sira LIMIT $gecerli,$sayfaLimit"),
         'toplamVeri'=>$toplamVeri,
         'ek'=>$ek,
         'search'=>true,

         'baslik'=>array(
             array('title'=>'ID','width'=>'4%'),
             array('title'=>'Başlık','width'=>'70%'),
             array('title'=>'Onay Durumu','width'=>'5%'),


             )

     ));


    }


     public function vitrin($id=null)
    {
        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);

        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);

        $bayiDuzenle = $this->dbConn->update($this->table,array('durum'=>$durum),$id);
        $langDuzenle = $this->dbConn->langUpdate($this->tablelang,array('durum'=>$durum),$id);
        
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