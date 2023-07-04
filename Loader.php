<?php

include( __DIR__.'/vendor/autoload.php');
include( __DIR__.'/include/Smap.php');
include( __DIR__.'/include/Functions.php');
include( __DIR__.'/include/Database.php');
include( __DIR__.'/include/Mail.php');
include( __DIR__.'/include/FrontClass.php');
include( __DIR__.'/include/Lang.php');
include( __DIR__.'/include/Form.php');

use Snowsoft\Captcha\Captcha;
if (!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}


class Loader extends FrontClass
{
   public $settings;
   public $themeURL;
   public $katalogURL;
   public $lang;
   public $theme = 'default';
   public function __construct($settings)
    {
      parent::__construct($settings);
      $this->settings = $settings;
      $this->_ayarlar();

        $getheader = getallheaders();
        $header =  ((isset($getheader["Comfort"])  and $getheader["Comfort"] == "mobilx") ? true:false);
         if($header)
          $this->theme = 'mobil/';
         else
          $this->theme = $this->settings->config('siteTemasi').'/';


      $this->themeURL = $this->settings->config('url').'view/'.$this->theme;
      $this->katalogURL = $this->settings->config('url').'view/'.$this->theme."e-katalog/";

    }




    public function sifrele($sifre){
        $password = 'vmdygaimder4321';
        $method = 'aes-256-cbc';
        $password = substr(hash('sha256', $password, true), 0, 32);

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        return base64_encode(openssl_encrypt($sifre, $method, $password, OPENSSL_RAW_DATA, $iv));
    }

    public function sifreCoz($sifreliVeri){

        $password = 'vmdygaimder4321';
        $method = 'aes-256-cbc';
        $password = substr(hash('sha256', $password, true), 0, 32);

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        return openssl_decrypt(base64_decode($sifreliVeri), $method, $password, OPENSSL_RAW_DATA, $iv);
    }



    public function pageTitle($data)
    {
       return $this->pageListTitle($data);
    }

    public function pageLoader($data=array())
    {


        $LangGET = new \Lang($data['lang']);
        $LangLink = new \Lang((($data['lang']=="tr") ? 'tr':'en'));
        $this->lang  = $LangGET;
        $data = array_merge(array('LangGET'=>$LangGET,'LangLink'=>$LangLink),$data);


        $text = "";

        if ($data["page"] != "e-katalog"){
            $text .= $this->_include('bolum/ust',$data,$this->theme);
        }


        if(!$this->dataMoveURL($data)):


         switch ($data['page']):
             case 'index':
                 $text .=  $this->_include('sayfa/index',$data,$this->theme);
             break;

            default:

             $text .=  $this->_include('sayfa/'.$data['page'],$data,$this->theme);
                if ($text == $this->_include('bolum/ust',$data,$this->theme))
                {
                    $text .= $this->_include('sayfa/hata',$data,$this->theme);
                }
            break;


             case 'kurumsal':
             case 'corporate':
                $text .= $this->_include('sayfa/kurumsal',$data,$this->theme);
             break;


             case 'urunler':
             case 'products':
                 $text .= $this->_include('sayfa/urunler',$data,$this->theme);
                 break;


             case 'urun-detay':
             case 'product-detail':
                 $text .= $this->_include('sayfa/urun-detay',$data,$this->theme);
                 break;


             case 'profil':
             case 'profile':
                 $text .= $this->_include('sayfa/profil',$data,$this->theme);
                 break;

             case 'urun-gruplari':
             case 'product-groups':
             case 'продакт-группа':
                $text .= $this->_include('sayfa/kategoriler',$data,$this->theme);
             break;

             case 'projeler':
             case 'projects':
             case 'проектов':
                $text .= $this->_include('sayfa/projeler',$data,$this->theme);
             break;

             case 'referanslar':
             case 'references':
             case 'ссылки':
                $text .= $this->_include('sayfa/referanslar',$data,$this->theme);
             break;


             case 'urunler':
             case 'products':
             case 'продукты':
              $text .= $this->_include('sayfa/urunler',$data,$this->theme);
             break;


             case 'temsilcilik':
             case 'representation':
             case 'представление':
              $text .= $this->_include('sayfa/temsilcilik',$data,$this->theme);
             break;


             case 'urun':
             case 'product':
             case 'продукт':
                $text .= $this->_include('sayfa/urun',$data,$this->theme);
             break;

             case 'foto-galeri':
             case 'photo-gallery':
             case 'фото-галерея':
                $text .= $this->_include('sayfa/foto-galeri',$data,$this->theme);
             break;

             case 'degirmen-blog':
             case 'degirmen-блог':
                $text .= $this->_include('sayfa/degirmen-blog',$data,$this->theme);
             break;

             case 'giris-yap':
             case 'login':
             case 'логин':
                $text .= $this->_include('sayfa/girisYap',$data,$this->theme);
             break;


             case 'haber':
             case 'new':
                $text .= $this->_include('sayfa/haber',$data,$this->theme);
             break;

             case 'etkinlik':
             case 'etkinlik':
                $text .= $this->_include('sayfa/etkinlik',$data,$this->theme);
             break;

             case 'haberler':
             case 'news':
                $text .= $this->_include('sayfa/haberler',$data,$this->theme);
             break;
             case 'koleksiyon':
             case 'collection':
                $text .= $this->_include('sayfa/koleksiyon',$data,$this->theme);
             break; case 'koleksiyonlar':
              case 'collections':
                 $text .= $this->_include('sayfa/koleksiyonlar',$data,$this->theme);
              break;


             case 'iletisim':
             case 'contact-us':
             case 'контакт':
              $text .= $this->_include('sayfa/iletisim',$data,$this->theme);
             break;


             case 'hata':
                $text .= $this->_include('sayfa/hata',$data,$this->theme);
             break;


         endswitch;


        if ($data["page"] != "e-katalog"){
             $text .= $this->_include('bolum/alt',$data,$this->theme);
        }

        return  $text;

        endif;

    }

    // ajax/*
    public function ajaxLoader($page)
    {
        if($this->settings->security('google') == false and isset($_SESSION['_CAPTCHA']['config']))
        $captcha_config = unserialize($_SESSION['_CAPTCHA']['config']);
        else
            $captcha_config= '';
        if($this->settings->security('google'))
            $vadilation = $this->GooglereCAPTCHACont(Request::POST('g-recaptcha-response'));
        else
            $vadilation = (Request::POST('captcha') == $captcha_config['code']);

            switch ($page):

                case 'siteharitasi':
                    echo  $this->_include('ajax/siteharitasi',[]);
                    break;

                case 'eskiseo':

                    $page = Request::GET('page','index');
                    $type = Request::GET('type','master');
                    $id   = Request::GET('id',0);
                    $kid  = Request::GET('kid',0);
                    $lang = Request::GET('lang','tr');
                    $url = Request::GET('url','');
                    $urunurl = Request::GET('urunurl','');
                    $katurl = Request::GET('katurl','');

                if(!$this->dataMoveURL([

                    'page' =>$page,
                    'id' => $id,
                    'kid' => $kid,
                    'lang' => $lang,
                    'url' => $url,
                    'katurl' => $katurl,
                    'urunurl'=>$urunurl


                ])) $this->MoveURL();

                    break;


                case 'urun':

                        echo $this->_include('ajax/resim',['resimurl'=> Request::GETURL('url'),
                            'arka'=> Request::GETURL('arka')]);

                        break;


                case 'resimtasi':

                    echo $this->_include('ajax/resimtasi',[]);

                    break;

                case 'urunurl':

                    echo $this->_include('ajax/urunurl',[]);

                    break;

                case 'uruntalepformu':
                $govde = $this->_include('ajax/teklif',
                    array(
                        'firma'=>Request::POST('firmaadi'),
                        'isim'=>Request::POST('ilgilikisi'),
                        'telefon'=>Request::POST('telefon'),
                        'eposta'=>Request::POST('email'),
                        'mesajiniz'=>Request::POST('mesajiniz'),
                    ));
                if($this->TokenCont('uruntalep',Request::POST('token'))):
                if($vadilation)
                echo $this->_SEND($this->ayarlar('eposta'),$this->ayarlar('eposta'),'Teklif Talep Formu',$govde);
                else  echo 2;
                else: echo 33;
                endif;
                break;
                case 'test':
                    echo $this->_include('ajax/test');
                    break;


            case 'iletisimForm':


                $govde = $this->_include('ajax/iletisim',
                    array(
                        'adi'=>Request::POST('adi'),
                        'soyadi'=>Request::POST('soyadi'),
                        'mesaj'=>Request::POST('mesaj'),

                        'telefon'=>Request::POST('telefon'),
                        'konu'=>Request::POST('konu'),
                        'eposta'=>Request::POST('email'),
                    ));
                //

              //  if($this->TokenCont('frcontact',Request::POST('token'))):

                if($vadilation){
                    echo $this->_SEND($this->ayarlar('eposta'),$this->ayarlar('eposta'),'Web Sitesi - İletişim Formu',$govde);
                }
                else {
                    echo 3;
                }
                break;

                case 'loginForm':
                  $email = $this->temizle($this->koru(Request::POST('email')));
                  $sifre = $this->temizle($this->koru(Request::POST('sifre')));

                  $k_sifre = $this->sifrele($sifre);


                  $kontrol = $this->teksorgu("select * from uyelik WHERE eposta = '$email' and sifre = '$k_sifre' and aktif = 1");

                       if ($kontrol){
                            echo 1;
                            $_SESSION["k_giris"] = $kontrol["id"];
                       }

                   else {
                        echo 2;
                   }

               break;



               case 'resetPassword':

                  $mail = $this->koru($this->kirlet(Request::POST('email')));

                  $kontrol = $this->teksorgu("SELECT * FROM uyelik WHERE eposta = '$mail'");

                  if ($kontrol){
                    $govde = $this->_include('ajax/reset',
                        array(
                            'firmadi'=>$kontrol["firmadi"],
                            'yetkili'=>$kontrol["adisoyadi"],
                            'sifre'=>$this->sifreCoz($kontrol["sifre"]),
                        ));
                      echo $this->_SEND($this->ayarlar('eposta'),$mail,'Sifre Hatırlatma',$govde);
                  }
                  else {
                    echo "3";
                  }






                   break;

                   case 'loginForm':
                     $email = $this->temizle($this->koru(Request::POST('email')));
                     $sifre = $this->temizle($this->koru(Request::POST('sifre')));

                     $k_sifre = $this->sifrele($sifre);


                     $kontrol = $this->teksorgu("select * from uyelik WHERE eposta = '$email' and sifre = '$k_sifre' and aktif = 1");

                      if ($kontrol){
                           echo 1;
                           $_SESSION["k_giris"] = $k_sifre;
                      }

                      else {
                           echo 2;
                      }

                  break;


               case 'cikis':

                 unset($_SESSION["k_giris"]);
                 echo "1";

              break;


                case 'talep':


                $govde1 = $this->_include('ajax/talep',
                    array(
                        'adi'=>Request::POST('adi'),
                        'mesaj'=>Request::POST('mesaj'),
                        'konu'=>Request::POST('konu'),
                        'tel'=>Request::POST('tel'),
                        'email'=>Request::POST('email'),
                    ));
                //

              //  if($this->TokenCont('frcontact',Request::POST('token'))):
                if($vadilation)
                echo $this->_SEND($this->ayarlar('eposta'),$this->ayarlar('eposta'),'Talep Formu',$govde1);
                else echo 2;
                // else: echo 3;
               // endif;
                break;


                case 'basvuru':

                $govde1 = $this->_include('ajax/basvuru',
                    array(
                        'tc_kimlik'=>$this->kirlet(Request::POST('tc_kimlik')),
                        'adi_soyadi'=>$this->kirlet(Request::POST('adi_soyadi')),
                        'email'=>Request::POST('email'),
                        'dogum_yeri_ve_tarihi'=>$this->kirlet(Request::POST('dogum_yeri_ve_tarihi')),
                        'cinsiyeti_medeni_hali_cocuk_sayisi'=>$this->kirlet(Request::POST('cinsiyeti_medeni_hali_cocuk_sayisi')),
                        'ehliyet'=>$this->kirlet(Request::POST('ehliyet')),
                        'askerlik_durumu'=>$this->kirlet(Request::POST('askerlik_durumu')),
                        'cep_telefonu'=>$this->kirlet(Request::POST('cep_telefonu')),
                        'adresi'=>$this->kirlet(Request::POST('adresi')),
                        'yabanci_dil'=>$this->kirlet(Request::POST('yabanci_dil')),
                        'meslegi'=>$this->kirlet(Request::POST('meslegi')),
                        'ne_zaman_baslayabilecegi'=>$this->kirlet(Request::POST('ne_zaman_baslayabilecegi')),
                        'istenilen_gorev'=>$this->kirlet(Request::POST('istenilen_gorev')),
                        'istenilen_ucret'=>$this->kirlet(Request::POST('istenilen_ucret')),
                        'sigara'=>$this->kirlet(Request::POST('sigara')),
                        'hukumluluk'=>$this->kirlet(Request::POST('hukumluluk')),
                        'engel'=>$this->kirlet(Request::POST('engel')),
                        'seyahat'=>$this->kirlet(Request::POST('seyahat')),
                        'mezuniyet'=>$this->kirlet(Request::POST('universite_bolum')),
                        'not'=>$this->kirlet(Request::POST('not')),
                        'bilgisayar'=>$this->kirlet(Request::POST('bilgisayar')),
                        'eski_isyeri'=>$this->kirlet(Request::POST('eski_isyeri')),
                        'tarih'=>date("d-m-Y H:i"),
                    ));

                if($vadilation)
                echo $this->_SEND($this->ayarlar('eposta'),$this->ayarlar('eposta'),'İş Başvuru Formu',$govde1);
                else echo 2;
                // else: echo 3;
               // endif;
                break;


                case 'katalog':
                $govde = $this->_include('ajax/katalog',$govde,$this->theme);

                case 'video':
                    echo   $this->_include('ajax/'.$page,['id'=>$this->koru(Request::GETURL('id',0)),
                         'katurl' => $this->koru(Request::GET('katurl')),
                        'lang'=>$this->koru(Request::GETURL('lang','tr'))]);
                    break;
                case 'ikgonder':
                $govde = $this->_include('ajax/ikgonder',array('govde'=>Request::POST('govde')));
                $konu = Request::GETURL('konu');
                if($this->GooglereCAPTCHACont(Request::POST('g-recaptcha-response')))
                    echo $this->_SEND($this->ayarlar('eposta'),$this->ayarlar('eposta'),$konu,$govde);
                else echo 2;
                break;
                case 'form':
                echo   $this->_include('ajax/form');
                break;


                case 'bulten':
                     $ekle = $this->insert('bulten',array(
                    'pozisyon' => $this->kirlet(Request::POST('pozisyon')),
                    'ad' => $this->kirlet(Request::POST('ad')),
                    'dogumyeri' => $this->kirlet(Request::POST('dogumyeri')),
                    'dogumtarihi' => $this->kirlet(Request::POST('dogumtarihi')),
                    'cinsiyeti' => $this->kirlet(Request::POST('cinsiyeti')),
                    'medenihali' => $this->kirlet(Request::POST('medenihali')),
                    'kangrubu' => $this->kirlet(Request::POST('kangrubu')),
                    'boy' => $this->kirlet(Request::POST('boy')),
                    'kilo' => $this->kirlet(Request::POST('kilo')),
                    'seyehatengeli' => $this->kirlet(Request::POST('seyehatengeli')),
                    'saglikproblemi' => $this->kirlet(Request::POST('saglikproblemi')),
                    'sabika' => $this->kirlet(Request::POST('sabika')),
                    'ehliyet' => $this->kirlet(Request::POST('ehliyet')),
                    'tanidik' => $this->kirlet(Request::POST('tanidik')),
                    'ikamet' => $this->kirlet(Request::POST('ikamet')),
                    'ililce' => $this->kirlet(Request::POST('ililce')),
                    'posta' => $this->kirlet(Request::POST('posta')),
                    'evtel' => $this->kirlet(Request::POST('evtel')),
                    'ceptel' => $this->kirlet(Request::POST('ceptel')),
                    'mail' => $this->kirlet(Request::POST('mail')),
                    'beklenti' => $this->kirlet(Request::POST('beklenti')),
                    'askerlik' => $this->kirlet(Request::POST('askerlik')),
                    'mezun' => $this->kirlet(Request::POST('mezun')),
                    'bolum' => $this->kirlet(Request::POST('bolum')),
                    'yil' => $this->kirlet(Request::POST('yil')),
                    'dilbilgi' => $this->kirlet(Request::POST('dilbilgi')),
                    'konusma' => $this->kirlet(Request::POST('konusma')),
                    'okuma' => $this->kirlet(Request::POST('okuma')),
                    'yazma' => $this->kirlet(Request::POST('yazma')),
                    'kurum' => $this->kirlet(Request::POST('kurum')),
                    'gorev' => $this->kirlet(Request::POST('gorev')),
                    'telefonu' => $this->kirlet(Request::POST('telefonu')),
                     ));
                    echo ($ekle) ? "1" : '2';
                 break;


                case 'odeme':
                    $uye_id = $_SESSION["k_giris"];
                    $ekle = $this->insert('odeme',array(
                        'banka' => $this->kirlet(Request::POST('banka')),
                        'isim' => $this->kirlet(Request::POST('isim')),
                        'k_numarasi' => $this->kirlet(Request::POST('k_numarasi')),
                        'cvc' => $this->kirlet(Request::POST('cvc')),
                        'skt' => $this->kirlet(Request::POST('skt')),
                        'b_tur' => $this->kirlet(Request::POST('b_tur')),
                        'aktif' => '1',
                        'uye_id'=>$uye_id
                    ));

                    echo ($ekle) ? "1" : '2';

                    break;


                case 'guncelle':
                    $firma   = $this->koru($this->kirlet(Request::POST('firma')));
                    $yetkili = $this->koru($this->kirlet(Request::POST('yetkili')));
                    $telefon = $this->koru($this->kirlet(Request::POST('telefon')));
                    $email = $this->koru($this->kirlet(Request::POST('email')));
                    $cinsiyet = $this->koru($this->kirlet(Request::POST('cinsiyet')));
                    $kimlik = $this->koru($this->kirlet(Request::POST('kimlik')));
                    $fin = $this->koru($this->kirlet(Request::POST('fin')));
                    $dogum = $this->koru($this->kirlet(Request::POST('dogum')));
                    $duzen = $this->update('uyelik', array(
                        'firmadi'   =>  $firma,
                        'adisoyadi'   =>  $yetkili,
                        'telefon' =>  $telefon,
                        'eposta' =>  $email,
                        'cinsiyet'     =>  $cinsiyet,
                        'kimlik'     =>  $kimlik,
                        'fin'     =>  $fin,
                        'dogum'     =>  $dogum,
                    ), $_SESSION["k_giris"]);

                    echo ($duzen) ? "1" : '2';

                    break;



                case 'uyeOl':
                    $firma   = $this->koru($this->kirlet(Request::POST('firma')));
                    $yetkili = $this->koru($this->kirlet(Request::POST('yetkili')));
                    $telefon = $this->koru($this->kirlet(Request::POST('telefon_prefix'))).' '.$this->koru($this->kirlet(Request::POST('telefon')));
                    $email = $this->koru($this->kirlet(Request::POST('email')));
                    $sifre = $this->sifrele($this->koru($this->kirlet(Request::POST('sifre'))));
                    $sifre2 = $this->sifrele($this->koru($this->kirlet(Request::POST('sifre2'))));
                    $cinsiyet = $this->koru($this->kirlet(Request::POST('cinsiyet')));
                    $kimlik = $this->koru($this->kirlet(Request::POST('kimlik')));
                    $fin = $this->koru($this->kirlet(Request::POST('fin')));
                    $dogum = $this->koru($this->kirlet(Request::POST('dogum')));
                    $referans= $this->koru($this->kirlet(Request::POST('referans')));
                    $mail = $this->sorgu("select eposta from uyelik where eposta='$email'");
                    if ($sifre != $sifre2) {
                     echo '4';
                    }
                   else  if (count($mail)>0){
                        echo "3";
                    }
                    else {
                        $datas = array(
                            'firmadi'   =>  $firma,
                            'adisoyadi' =>  $yetkili,
                            'telefon'   =>  $telefon,
                            'eposta'    =>  $email,
                            'sifre'     =>  $sifre,
                            'cinsiyet'     =>  $cinsiyet,
                            'kimlik'     =>  $kimlik,
                            'fin'     =>  $fin,
                            'dogum'     =>  $dogum,
                            'referans'     =>  $referans,
                            'aktif'     => 0
                        );
                        $ekle = $this->insert('uyelik',$datas);
                        $govde2 = $this->_include('ajax/yeniUyelik',array(
                            'firmadi'   =>  $firma,
                            'adisoyadi' =>  $yetkili,
                            'telefon'   =>  $telefon,
                            'eposta'    =>  $email,
                            'cinsiyet'  =>  $cinsiyet,
                            'kimlik'     =>  $kimlik,
                            'referans'     =>  $referans,
                            'fin'     =>  $fin,
                            'dogum'     =>  $dogum,
                        ));
                        echo $this->_SEND($this->ayarlar('eposta'),$this->ayarlar('eposta'),'Yeni Üyelik Başvurusu',$govde2);
                    }
                    break;




            case 'temsilcilik':


                $tarih = date("d.m.Y");

              if($vadilation){
                 $ekle = $this->insert('temsilcilik',array(
                    'ulke' => $this->kirlet(Request::POST('ulke')),
                    'sehir' => $this->kirlet(Request::POST('sehir')),
                    'ad_soyad' => $this->kirlet(Request::POST('ad_soyad')),
                    'email' => $this->kirlet(Request::POST('email')),
                    'cep' => $this->kirlet(Request::POST('cep')),
                    'ofis_tel' => $this->kirlet(Request::POST('ofis_tel')),
                    'ofis_adres' => $this->kirlet(Request::POST('ofis_adres')),
                    'mesajiniz' => $this->kirlet(Request::POST('mesajiniz')),
                    'sirket_adi' => $this->kirlet(Request::POST('sirket_adi')),
                    'is_sektoru' => $this->kirlet(Request::POST('is_sektoru')),
                    'operasyonlar' => $this->kirlet(Request::POST('operasyonlar')),
                    'is_sektoru_2' => $this->kirlet(Request::POST('is_sektoru_2')),
                    'markalar' => $this->kirlet(Request::POST('markalar')),
                    'magazalar' => $this->kirlet(Request::POST('magazalar')),
                    'sirket_kurulus' => $this->kirlet(Request::POST('sirket_kurulus')),
                    'tarih'=>$tarih,
                    'ip'  =>  $_SERVER['SERVER_ADDR']
                ));

                echo ($ekle) ? "1" : '2';

              }

              else {
                echo 3;
              }


            break;

            case 'k_giris':

                $k_sifre  = $this->kirlet(Request::POST('k_sifre'));
                $sifrele = $this->sifrele($k_sifre);

                $sifre = $this->teksorgu("select * from teknik_sifre WHERE sifre='$sifrele'");

               if ($sifre){
                    echo 1;
                    $_SESSION["k_giris"] = $this->sifrele($sifrele);
               }
               else {
                    echo 2;
               }
            break;
         endswitch;
    }
}
