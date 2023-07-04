<?php

namespace AdminPanel;


class Ayar extends Settings {

    public $SayfaBaslik = 'Ayarlar';
    public $settings ;
    private $modulName = 'Ayar';


    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->settings = $settings;
        $this->AuthCheck();
    }


    public function index($id=nul)
    {
     return $this->ayarlar($id);

    }
    public function harita($id=nul)
    {
        $control = array('control'=>$this,
            'settings' => $this->settings);
        $this->load('helper/harita/index',$control);

        exit;

    }

	public function Dosyasil()
	{

	$resim = isset($_POST['resim']) ? json_decode(base64_decode($_POST['resim'])):null;
	 if($resim and file_exists('../upload/'.$resim[0]))  {  unlink('../upload/'.$resim[0]); echo 1;} else echo 0;
	 exit;
	}


    public function ayarlar($id=nul)
    {

        $text  = '';
        $form = new Form($this->settings);
       // $form = new Form($this->set);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .='<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
         <li class="active"><a href="#ayarlar" data-toggle="tab" aria-expanded="true">Ayarlar</a></li>
         <li class=""><a href="#iletisim" data-toggle="tab" aria-expanded="false">İletişim Bilgileri</a></li>
         <li class=""><a href="#sosyal" data-toggle="tab" aria-expanded="false">Sosyal Medya</a></li>
         <li class=""><a href="#user" data-toggle="tab" aria-expanded="false">Kullanıcı Ayarları</a></li>
         <li class=""><a href="#eposta" data-toggle="tab" aria-expanded="false">E-posta Ayarları</a></li>
         <li class="" style="display: none;"><a href="#theme" data-toggle="tab" aria-expanded="false">Tema Ayarları</a></li>
    </ul>
    <div class="tab-content">
        <!-- Font Awesome Icons -->
        <div class="tab-pane active" id="ayarlar">';
        $tabForm = array();
        $tabs = new Tabs($this->settings);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text'] = $form->input(array('value' => $this->get_element('title_'.$dil),'title'=>'Site Title','name'=>'title','id'=>'title','lang'=>$dil,'help'=>'Site  başlığını buraya girebilirsiniz.'));
           // $tabForm[$dil]['text'].= $form->input(array('value' => $this->get_element('title_en'),'title'=>'Site Title','name'=>'title','id'=>'title','lang'=>'en','help'=>'Site  başlığını buraya girebilirsiniz.'));
           //$text .= $form->file(array('url' => $this->BaseURL('upload'),'src' => $this->get_element('logo'),'title'=>'Logo','name'=>'logo','id'=>'title','resimBoyut'=>$this->settings->boyut('logo'),'help'=>''));
            $tabForm[$dil]['text'].= $form->textarea(array('value'=>$this->get_element('description_'.$dil),'title'=>'Açıklama','name'=>'description','id'=>'description','lang'=>$dil,'height'=>'80','help'=>'Açıklamanızı buraya girebilirsiniz.'));
          //  $tabForm[$dil]['text'].= $form->textarea(array('value'=>$this->get_element('description_en'),'title'=>'Açıklama','name'=>'description','id'=>'description','lang'=>'en','height'=>'80','help'=>'Açıklamanızı buraya girebilirsiniz.'));
            $tabForm[$dil]['text'] .= $form->textarea(array('value'=>$this->get_element('keywords_'.$dil),'title'=>'Anahtar kelime','name'=>'keywords','id'=>'keywords','lang'=>$dil,'height'=>'80','help'=>'Anahtar Kelimenizi buraya girebilirsiniz.'));
          //  $tabForm[$dil]['text'].= $form->textarea(array('value'=>$this->get_element('keywords_en'),'title'=>'Anahtar kelime','name'=>'keywords','id'=>'keywords','lang'=>'en','height'=>'80','help'=>'Anahtar Kelimenizi buraya girebilirsiniz.'));
      endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->input(array('value'=>$this->get_element('sayac'),'title'=>'Google Analytics Kodu','name'=>'sayac','id'=>'sayac','height'=>'80','help'=>'Google Analytics kodunuzu buraya girebilirsiniz. ÖRN:UA-87157922-1'));
        $text .= $form->input(array('value'=>$this->get_element('eposta'),'title'=>'E-posta','type'=>'email', 'name'=>'eposta','id'=>'title','help'=>'İletişim Formunun gönderileceği mail adresini buraya girebilirsiniz.'));
        $text .= $form->harita(array('url'=>$this->BaseAdminURL($this->modulName.'/harita'.((isset($id)) ? '/'.$id :'')),'value'=>$this->get_element('kordinant'),'title'=>'Yerinizi Google Haritadan Seçiniz','type'=>'email', 'name'=>'kordinant','id'=>'title','help'=>''));
        // $text .= $form->harita(array('url'=>$this->BaseAdminURL($this->modulName.'/harita'.((isset($id)) ? '/'.$id :'')),'value'=>$this->get_element('kordinant_ist'),'title'=>'Yerinizi Google Haritadan Seçiniz (İstanbul)','type'=>'email', 'name'=>'kordinant','id'=>'title','help'=>''));
        //$text .= $form->input(array('value'=>$this->get_element('cagrimerkezi'),'title'=>'Çağrı Merkezi','type'=>'text', 'name'=>'cagrimerkezi','id'=>'telefon','help'=>''));
        //    $text .= $form->harita(array('url'=>$this->BaseAdminURL($this->modulName.'/harita'.((isset($id)) ? '/'.$id :'')),'value'=>$this->get_element('kordinant_ist'),'title'=>'Yerinizi Google Haritadan Seçiniz (İstanbul)','type'=>'email', 'name'=>'kordinant_ist','id'=>'title','help'=>''));

    //    $text .= $form->input(array('value'=>$this->get_element('arac'),'title'=>'Araç Sayısı','type'=>'text', 'name'=>'arac','id'=>'arac','help'=>''));
      //  $text .= $form->input(array('value'=>$this->get_element('mutlumusteri'),'title'=>'Mutlu Müşteri','type'=>'text', 'name'=>'mutlumusteri','id'=>'mutlumusteri','help'=>''));
        //$text .= $form->input(array('value'=>$this->get_element('2elarac'),'title'=>'2. El Araç Satışı','type'=>'text', 'name'=>'2elarac','id'=>'2elarac','help'=>''));

        $text .=' </div>
        <!-- /#fa-icons -->

        <!-- glyphicons-->
         <div class="tab-pane" id="eposta">';

        $text .= $form->select(array('title'=>'Posta Doğrulama Tipi','name'=>'mailType','data'=> $form->parent(array('array'=>array(array('id'=>'phpmail','text'=> 'Php Mail'),array('id'=>'smtp','text'=>'Smtp Mail')),'option'=>array('value'=>'id','title'=>'text'),'selected'=>$this->get_element('mailType')),0,0)));
        $text .= $form->input(array('value' => $this->get_element('SmtpHost'),'title'=>'Smtp Host','name'=>'SmtpHost','id'=>'SmtpHost','help'=>''));
        $text .= $form->input(array('value' => $this->get_element('SmtpMail'),'title'=>'Smtp E-posta','name'=>'SmtpMail','id'=>'SmtpMail','help'=>''));
        $text .= $form->input(array('value' => $this->get_element('SmtpUser'),'title'=>'Smtp Kullanıcı Adı','name'=>'SmtpUser','id'=>'SmtpUser','help'=>''));
        $text .= $form->input(array('value' => $this->get_element('SmtpPass'),'title'=>'Smtp Şifre','SmtpPass'=>'title','id'=>'SmtpPass', 'name'=>'SmtpPass' ,'help'=>''));
        $text .= $form->input(array('value' => ($this->get_element('SmtpPort')) ? $this->get_element('SmtpPort'):587,'title'=>'Smtp Port','name'=>'SmtpPort','id'=>'SmtpPort','help'=>''));
       // $text .= $form->input(array('value' => $this->get_element('SmtpSecret'),'title'=>'Smtp Şifreleme','name'=>'SmtpSecret','id'=>'SmtpSecret','help'=>''));
        $text .= $form->select(array('title'=>'Smtp Şifreleme','name'=>'SmtpSecret','data'=> $form->parent(array('array'=>array(array('id'=>'tls','text'=> 'TLS'),array('id'=>'ssl','text'=>'SSL')),'option'=>array('value'=>'id','title'=>'text'),'selected'=>$this->get_element('SmtpSecret')),0,0)));


       $text .=' </div>
        <!-- /#fa-icons -->

        <!-- glyphicons-->
         <div class="tab-pane" id="iletisim">';
        $tabsList =  $this->settings->sube('subeler');
        $tabks =  $this->settings->sube('kisaltma');
        $tabsForm = array();
        $tabs = new Tabs($this->settings,$tabsList);
        $x=0;
        if(is_array($tabsList))
            foreach ($tabsList as $name=>$value):
             $tabsForm[$name]['text'] = $form->input(array('value'=>$this->get_element('unvan_'.$name),'title'=>'Ünvan ['.$tabks[$x].']','type'=>'text', 'name'=>'unvan_'.$name,'id'=>'unvan','help'=>''));
             $tabsForm[$name]['text'].= $form->input(array('value'=>$this->get_element('telefon_'.$name),'title'=>'Telefon ['.$tabks[$x].']','type'=>'text', 'name'=>'telefon_'.$name,'id'=>'telefon','help'=>''));
             $tabsForm[$name]['text'] .=$form->input(array('value'=>$this->get_element('gsm_'.$name),'title'=>'Gsm ['.$tabks[$x].']','type'=>'text', 'name'=>'gsm_'.$name,'id'=>'gsm','help'=>''));
             //$tabsForm[$name]['text'].= $form->input(array('value'=>$this->get_element('faks_'.$name),'title'=>'Faks ['.$tabks[$x].']','type'=>'text', 'name'=>'faks_'.$name,'id'=>'faks','help'=>''));
             $tabsForm[$name]['text'].= $form->input(array('value'=>$this->get_element('adres_'.$name),'title'=>'Adres ['.$tabks[$x].']','type'=>'text', 'name'=>'adres_'.$name,'id'=>'adres','help'=>''));
             //$tabsForm[$name]['text'].= $form->input(array('value'=>$this->get_element('adres2_'.$name),'title'=>'Adres2 ['.$tabks[$x].']','type'=>'text', 'name'=>'adres2_'.$name,'id'=>'adres2','help'=>''));
             //$tabsForm[$name]['text'].= $form->input(array('value'=>$this->get_element('bilgi_'.$name),'title'=>'Bilgi Hattı ['.$tabks[$x].']','type'=>'text', 'name'=>'bilgi_'.$name,'id'=>'bilgi','help'=>''));
             //$tabsForm[$name]['text'].= $form->input(array('value'=>$this->get_element('whatsapp_'.$name),'title'=>'Whatsapp No ['.$tabks[$x].']','type'=>'text', 'name'=>'whatsapp_'.$name,'id'=>'bilgi','help'=>''));

             $tabsForm[$name]['text'].= $form->input(array('value'=>$this->get_element('ileteposta_'.$name),'title'=>'E-posta ['.$tabks[$x].']','type'=>'text', 'name'=>'ileteposta_'.$name,'id'=>'ileteposta','help'=>''));
                $x++;
      endforeach;
        $text .= $tabs->tabContentArray($tabsForm);

        //$text .= $form->input(array('value'=>$this->get_element('diseposta'),'title'=>'Dış Ticaret E-posta','type'=>'text', 'name'=>'diseposta','id'=>'diseposta','help'=>''));
       //$text .= $form->input(array('value'=>$this->get_element('acilis'),'title'=>'Açılış Saatleri','type'=>'text', 'name'=>'acilis','id'=>'acilis','help'=>''));

        $text .='
        </div>
          <div class="tab-pane" id="user">';
        $text .= $form->input(array('value'=>$this->get_element('kullanici'),'title'=>'Kullanıcı Adı','type'=>'text', 'name'=>'kullanici','id'=>'title','help'=>''));
        $text .= $form->input(array('value'=>'','title'=>'Şifre','type'=>'text', 'name'=>'sifre','id'=>'title','help'=>''));

        $text .='  </div>

        <div class="tab-pane" id="theme">';
        $text .= $form->select(array('title'=>'Tema Renk','name'=>'ThemeColor','data'=> $form->parent(array('array'=>array(
            array('id'=>'skin-blue','text'=> 'Mavi'),
            array('id'=>'skin-blue-light','text'=>'Mavi-Beyaz'),
            array('id'=>'skin-yellow','text'=>'Sarı'),
            array('id'=>'skin-yellow-light','text'=>'Sarı-Beyaz'),
            array('id'=>'skin-green','text'=>'Yeşil'),
            array('id'=>'skin-green-light','text'=>'Yeşil-Beyaz'),
            array('id'=>'skin-purple','text'=>'Mor'),
            array('id'=>'skin-purple-light','text'=>'Mor-Beyaz'),
            array('id'=>'skin-red','text'=>'Kırmızı'),
            array('id'=>'skin-red-light','text'=>'Kırmızı-Beyaz'),
            array('id'=>'skin-black','text'=>'Siyah'),
            array('id'=>'skin-black-light','text'=>'Siyah-Beyaz')

            ),
            'option'=>array('value'=>'id','title'=>'text'),'selected'=>$this->get_element('ThemeColor')),0,0)));
        $text .= $form->select(array('title'=>'Kutu Renk','name'=>'BoxColor','data'=> $form->parent(array('array'=>array(
            array('id'=>'box-default','text'=>'Gri'),
            array('id'=>'box-success','text'=> 'Yeşil'),
            array('id'=>'box-warning','text'=>'Turuncu'),
            array('id'=>'box-danger','text'=>'Kırmızı'),

        ),
            'option'=>array('value'=>'id','title'=>'text'),'selected'=>$this->get_element('BoxColor')),0,0)));
        $text .= $form->select(array('title'=>'Widget Renk','name'=>'WidgetColor','data'=> $form->parent(array('array'=>array(
            array('id'=>'','text'=>'Gri'),
            array('id'=>'bg-aqua','text'=> 'Mavi'),
            array('id'=>'bg-green','text'=>'Yeşil'),
            array('id'=>'bg-yellow','text'=>'Sarı'),
            array('id'=>'bg-red','text'=>'Sarı-Beyaz')

        ),
            'option'=>array('value'=>'id','title'=>'text'),'selected'=>$this->get_element('WidgetColor')),0,0)));

        $text .= '<hr><br clear="all">     ';

        $text .='  </div>

        <div class="tab-pane" id="sosyal">';
         $text .= $form->input(array('value'=>$this->get_element('fbURL'),'title'=>'Facebook Sayfa URL','type'=>'text', 'name'=>'fbURL','id'=>'title','help'=>''));
         $text .= $form->input(array('value'=>$this->get_element('twURL'),'title'=>'Twitter URL','type'=>'text', 'name'=>'twURL','id'=>'twURL','help'=>''));
         $text .= $form->input(array('value'=>$this->get_element('insURL'),'title'=>'Instagram URL','type'=>'text', 'name'=>'insURL','id'=>'insURL','help'=>''));
         //$text .= $form->input(array('value'=>$this->get_element('fourURL'),'title'=>'Foursquare URL','type'=>'text', 'name'=>'fourURL','id'=>'title','help'=>''));
         //$text .= $form->input(array('value'=>$this->get_element('ytbURL'),'title'=>'Youtube URL','type'=>'text', 'name'=>'ytbURL','id'=>'title','help'=>''));
         //$text .= $form->input(array('value'=>$this->get_element('gogleURL'),'title'=>'Google URL','type'=>'text', 'name'=>'gogleURL','id'=>'gogleURL','help'=>''));
         $text .= $form->input(array('value'=>$this->get_element('linURL'),'title'=>'LinkedIn URL','type'=>'text', 'name'=>'linURL','id'=>'linURL','help'=>''));
         //$text .= $form->input(array('value'=>$this->get_element('pinURL'),'title'=>'Pinterest URL','type'=>'text', 'name'=>'pinURL','id'=>'pinURL','help'=>''));
         $text .='</div></div></div>';





           //$text .= '<hr> <br clear="all"> <h3>İletişim Bilgileri - İstanbul</h3><br clear="all">  ';
          //$text .= $form->input(array('value'=>$this->get_element('unvanIst'),'title'=>'Ünvan','type'=>'text', 'name'=>'unvanIst','id'=>'unvan','help'=>''));
         //$text .= $form->input(array('value'=>$this->get_element('telefonIst'),'title'=>'Telefon','type'=>'text', 'name'=>'telefonIst','id'=>'telefon','help'=>''));
        //$text .= $form->input(array('value'=>$this->get_element('faksIst'),'title'=>'Faks','type'=>'text', 'name'=>'faksIst','id'=>'faks','help'=>''));
       //$text .= $form->input(array('value'=>$this->get_element('adresIst'),'title'=>'Adres','type'=>'text', 'name'=>'adresIst','id'=>'adres','help'=>''));
      //$text .= $form->input(array('value'=>$this->get_element('iletepostaIst'),'title'=>'İletişim E-posta','type'=>'text', 'name'=>'iletepostaIst','id'=>'ileteposta','help'=>''));


        $text .= $form->submitButton(array('submit'=>'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;

    }

    public function kaydet($id=nul)
    {
        foreach($_POST as $name => $value)
        {

            if($name == "logo") {
                $this->dbConn->update('ayarlar',array('value' => $this->_RESIM($name)),array('name'=>$name));
            }
           elseif($name == "sifre")  {
                if($value) {
                    $value = sha1(md5($value));
                    $this->dbConn->update('ayarlar',array('value' => $value),array('name'=>$name));
                    if($this->get_element('sifre') != $value)
                    {
                        unset($_COOKIE['loginC']);
                        setcookie('loginC', null, -1, '/');
                    }
                } }
            else
           $this->dbConn->update('ayarlar',array('value' => $value),array('name'=>$name));
        }

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/ayarlar.html'));

    }

    public function sehirListesi($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        return $pagelist->Pagelist(array(
            'title'=> 'Şehir Listesi',

            'button' => array(array('title'=>'Şehir Ekle','href'=>$this->BaseAdminURL($this->modulName.'/sehirEkle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'sehir', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/sehirEkle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/sehirSil/'),'color'=>'red')),

            'pdata' => $this->dbConn->sorgu('select * from sehirler ORDER   BY  id'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'70%'),

            )

        ));
    }


    public function bolgeListesi($id=null)
    {
        $pagelist = new Pagelist($this->settings);

        return $pagelist->Pagelist(array(
            'title'=> 'Bölge Listesi',

            'button' => array(array('title'=>'Şehir Ekle','href'=>$this->BaseAdminURL($this->modulName.'/bolgeEkle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'ad', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/bolgeEkle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/bolgeSil/'),'color'=>'red')),

            'pdata' => $this->dbConn->sorgu('select * from bolge ORDER   BY  id'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'70%'),

            )

        ));
    }

    public function sehirEkle($id=null)
    {
        $this->icbaslik = 'Şehir Ekle';
        if(isset($id) and $id) $haber = $this->dbConn->tekSorgu('select * from sehirler WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/sehirkaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($haber['sehir']) ? $haber['sehir'] :'')),'title'=>'Şehir Adı','name'=>'sehir','id'=>'sehir','help'=>'Şehir Adını buraya girebilirsiniz.'));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;

    }

    public function bolgeEkle($id=null)
    {
        $this->icbaslik = 'Bölge Ekle';
        $tabForm = array();
        $form = new Form($this->settings);
        $tabs = new Tabs($this->settings);
        $text = $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/bolgeKaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        if($id) $data = $tabs->tabData('bolge',$id);
        foreach ($this->settings->lang('lang') as $dil=>$title):
            $tabForm[$dil]['text']  = $form->input(array('value'=>((isset($data[$dil]['ad']) ? $data[$dil]['ad'] :'')),'title'=>'Bölge Adı','name'=>'ad','id'=>'ad','help'=>'','lang'=>$dil));
            endforeach;
        $text .= $tabs->tabContent($tabForm);
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));
        return $text;
    }

    public function sehirSil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM sehirler where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/sehirListesi.html'));
    }


    public function bolgeKaydet($id=null)
    {
        $tablename = "bolge";


        foreach ($this->settings->lang('lang') as $dil=>$title):
            $post[$dil] = array(
                'ad'=> $this->_POST('ad',$dil),
                'dil'=>$dil,


            );
        endforeach;

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update($tablename,$post['tr'],$id);
            foreach ($this->settings->lang('lang') as $dil=>$title):
                if($dil!='tr') {
                    if(count($this->dbConn->sorgu("select * from ".$tablename."_lang where dil='".$dil."' and master_id='".$id."' "))==1)
                        $this->dbConn->update($tablename.'_lang', $post[$dil],array('master_id'=>$id));
                    else
                        $this->dbConn->insert($tablename.'_lang',array_merge($post[$dil],array('master_id'=>$id)));
                }
            endforeach;
        else:
            // kaydet
            $this->dbConn->insert($tablename,$post['tr'],$id);
            $lastid = $this->dbConn->lastid();
            foreach ($this->settings->lang('lang') as $dil=>$title):

                if($dil!='tr') {

                    $this->dbConn->insert($tablename.'_lang', array_merge($post[$dil], array('dil' => $dil, 'master_id' => $lastid)));
                }

            endforeach;
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/bolgeListesi.html'));
    }

    public function bolgesil($id=null)
    {
        if($id){
            $this->dbConn->sil("DELETE FROM bolge where id=".$id);
            $this->dbConn->sil("DELETE FROM bolge_lang where master_id=".$id);
        }
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/bolgeListesi.html'));
    }


    public function sehirkaydet($id=null)
    {
        $post = array(
            'sehir'=> $this->_POST('sehir'),

        );

        if(isset($id) and $id):
            //Güncelle
            $this->dbConn->update('sehirler',$post,$id);
        else:
            // kaydet
            $this->dbConn->insert('sehirler',$post);
        endif;

        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/sehirListesi.html'));
    }

}
