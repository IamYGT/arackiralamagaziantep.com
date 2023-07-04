<?php


namespace AdminPanel;


class Login extends Settings {

    public   $SayfaBaslik = 'Giriş';
    public   $modulName = 'Login';
    private  $siteURL;
    private  $set;
    private  $css;
    private  $js;

    public function __construct($settings)
    {
        parent::__construct($settings);
    }

    public function index($id=nul)
    {
        $control = array('modulName'=>$this->modulName,
            'BaseAdminURL'=>$this->BaseAdminURL(),
            'ThemeURL'=>$this->ThemeFile(),
            'settings' => $this->settings
        );
            $this->load('theme/'.$this->settings->config('adminTheme'). '/login', $control);

        exit;
    }

    public function cikis($id=null)
     {

         $_SESSION['login'] = "";
         setcookie('login','',time()-3600);
         $this->RedirectURL($this->BaseAdmin('login.html'));
         exit;
     }

    public function kontrol()
    {

        $userGet = (isset($_POST['user'])) ? $this->koru($_POST['user']) : null;
        $passGet = (isset($_POST['pass'])) ? $this->koru($_POST['pass']) : null;
        $hatirla  = (isset($_POST['hatirla'])) ? $_POST['hatirla'] : null;

        $user =  $this->get_element('kullanici');
        $username =  ($user == $userGet) ? true:false;

        $pass = $this->get_element('sifre');
        $password =  ($pass == sha1(md5($passGet))) ? true:false;

        if($username and $password):
        $key = sha1(md5($user.$pass.$this->settings->config('passkey')));
        $_SESSION['loginS'] = $key;
        if($hatirla==1) setcookie('loginC',$key,time() + 2678400);
        echo 1;
        else:
        echo 0;
        endif;


    }

   public  function sifremiUnuttum()
   {
       $control = array('modulName'=>$this->modulName,'control'=>$this,
           'settings' => $this->settings);
       $this->load('theme/'.$this->settings->config('adminTheme'). '/sifremiUnuttum', $control);

       exit;
   }

   public function mailgonder()
   {
       $user = $this->get_element('kullanici');
       $pass = $this->get_element('sifre');
       $eposta = $this->get_element('eposta');


       $userGet = (isset($_POST['user'])) ? $this->koru($_POST['user']) : null;
       $epostaGet = (isset($_POST['eposta'])) ? $_POST['eposta'] : null;
       $usernamevar = ($user== $userGet) ? true:false;
       $epostavar =  ($eposta == $epostaGet) ? true:false;


       if($usernamevar and $epostavar):

       $tarih = strtotime(date('d/m/Y'));
       $key = sha1(md5($user.$pass.$this->settings->config('passkey').$tarih));
       $this->get_element('newpasskey',"$key");
       $govde  = '
       <p> <h4> Sayın Müşterimiz : '.$user.';</h4> <br><br>
       Yeni şifreniz için aşagıdaki linki kullanabilirsiniz
       <br><br>
       <a href="'.$this->BaseAdmin("login/yeniSifre/$key").'"> Yeni Şifreniz için Tıklayınız </a>
      </p>
      <p style="color:#c20000;">Bu Link bu gün için geçerlidir</p><br>
      <p> Tarih : '.date('d/m/Y').'</p>';
       $subject ="Bu E-posta web sitesinden gönderilmiştir.\n";
       $headers  = 'From: ' . $eposta  . "\r\n";
       $headers .= 'Return-Path: ' . $eposta  . "\r\n";
       $headers .= 'MIME-Version: 1.0' ."\r\n";
       $headers .= 'Content-Type: text/HTML; charset=UTF-8' . "\r\n";
       $headers .= 'Content-Transfer-Encoding: 8bit'. "\n\r\n";

       if(mail($eposta ,$subject,$govde,$headers))
           echo 1; else   echo 0;

           else:
               echo 0;
               endif;


   }

   public function yeniSifre($id=null)
   {
       $newpasskey = $this->get_element('newpasskey');
       $user = $this->get_element('kullanici');
       $pass = $this->get_element('sifre');
       $tarih = strtotime(date('d/m/Y'));
       $key = sha1(md5($user.$pass.$this->settings->config('passkey').$tarih));
       if(($newpasskey == $id) and ($newpasskey == $key)):
       $cont = array('key'=>$id,'control'=>$this,  'settings' => $this->settings);
       $this->load('theme/'.$this->settings->config('adminTheme') . '/yenisifre', $cont);
       else:
       echo 'Onay kodu hatalı veya süresi geçmiş tekrar  login ekranında bulunan "Şifrem Unuttum" linkine <a href="'.$this->BaseAdmin('login.html').'">tıklayınız.</a>';
       endif;


       exit;
   }

   public function sifrekaydet()
   {
       $sifre = (isset($_POST['sifre'])) ? $this->koru($_POST['sifre']) : null;
       $sifre2 = (isset($_POST['sifre2'])) ? $this->koru($_POST['sifre2']) : null;
       $key = (isset($_POST['key'])) ? $this->koru($_POST['key']) : null;

      if(($sifre == $sifre2)):
     if($key == $this->get_element('newpasskey')):

      $this->get_element('sifre',sha1(md5($sifre)));
      $this->get_element('newpasskey','');
      echo 1;
      else:
         echo 2;
         endif;
      else:
      echo 0;
      endif;


   }
}
