<?php

namespace AdminPanel;
include( __DIR__.'/phpmailer/class.phpmailer.php');
use AdminPanel\Form;

class Uyeler extends Settings  {

    public $SayfaBaslik = 'Üye Listesi';
    public $modulName = 'Uyeler';
    public $icbaslik ;


    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

    public function index($id=null)
    {
      $this->liste($id);
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


    public function ekle($id=null)
    {

        $this->icbaslik = 'Müşteri Listesi';
        if(isset($id) and $id) $haber = $this->dbConn->tekSorgu('select * from uyelik WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        $text .= $form->input(array('value'=>((isset($haber['firmadi']) ? $haber['firmadi'] :'')),'title'=>'Adı Soyadı','name'=>'firmadi','id'=>'firmadi','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['telefon']) ? $haber['telefon'] :'')),'title'=>'Telefon Numarası','name'=>'telefon','id'=>'telefon','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['adisoyadi']) ? $haber['adisoyadi'] :'')),'title'=>'Adres','name'=>'adisoyadi','id'=>'adisoyadi','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['eposta']) ? $haber['eposta'] :'')),'title'=>'E-Posta','name'=>'eposta','id'=>'eposta','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['cinsiyet']) ? $haber['cinsiyet'] :'')),'title'=>'Cinsiyet','name'=>'cinsiyet','id'=>'cinsiyet','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['kimlik']) ? $haber['kimlik'] :'')),'title'=>'Kimlik Numarası','name'=>'kimlik','id'=>'kimlik','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['fin']) ? $haber['fin'] :'')),'title'=>'Fin','name'=>'fin','id'=>'fin','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['dogum']) ? $haber['dogum'] :'')),'title'=>'Doğum Tarihi','name'=>'dogum','id'=>'dogum','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['sifre']) ? $this->sifreCoz($haber['sifre']) :'')),'title'=>'Şifre','name'=>'sifre','id'=>'sifre','help'=>''));
        $text .= $form->input(array('value'=>((isset($haber['referans']) ? $haber['referans'] :'')),'title'=>'Referans Müşteri Kodu','name'=>'referans','id'=>'referans','help'=>''));

        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        $modal = new Widget($this->settings);
        $text .= $modal->infoform(array('title'=>'','govde'=>''));

        return $text;
    }

    public function kaydet($id=null)
    {
        $post = array(
            'firmadi'=> $this->_POST('firmadi'),
            'telefon'=> $this->_POST('telefon'),
            'adisoyadi'=> $this->_POST('adisoyadi'),
            'eposta'=> $this->_POST('eposta'),
            'cinsiyet'=> $this->_POST('cinsiyet'),
            'kimlik'=> $this->_POST('kimlik'),
            'fin'=> $this->_POST('fin'),
            'dogum'=> $this->_POST('dogum'),
            'sifre'=> $this->sifrele($this->_POST('sifre')),
            'tarih' =>date('m/d/Y H:i:s'),

        );

        if(isset($id) and $id):
            $this->dbConn->update('uyelik',$post,$id);
        else:
            $this->dbConn->insert('uyelik',$post);
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function bakiye($id=null)
    {
        $this->icbaslik = 'Siparişler';
        if(isset($id) and $id) $data = $this->dbConn->tekSorgu('select * from bakiye WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/bakiye_kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($data['bakiye']) ? $data['bakiye'] :'')),'title'=>'Bakiye','name'=>'bakiye','id'=>'bakiye','help'=>' '));
        $text .= $form->input(array('value'=>((isset($data['aciklama']) ? $data['aciklama'] :'')),'title'=>'Açıklama','name'=>'aciklama','id'=>'aciklama','help'=>' '));
        $text .= $form->submitButton();
        $text .= $form->formClose();
        $modal = new Widget($this->settings);

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


    public function bakiye_kaydet($id='kid')
    {
        $post = array('bakiye' => $this->_POST('bakiye'),);
        if(isset($id) and $id):
            //$this->dbConn->insert('bakiye',$post,$id);
            $this->dbConn->insert('bakiye',array(
                'bakiye' => $this->_POST('bakiye'),
                'aciklama' => $this->_POST('aciklama'),
                'kid'=>$id
            ));
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function durum($id=null)
    {

        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);
        //$durum = (($durum==1) ? 0 :1);
        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        if($this->dbConn->update('uyelik',array('aktif'=>$durum),$id)) echo 1;else echo 0;

        exit;
    }

    public function sil($id=null)
    {
      if($id) $this->dbConn->sil('DELETE FROM uyelik where id='.$id);
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
            'title'=> 'Müşteri Listesi',
            'page'=>'uyeler',
            'button' => array(array('title'=>'Müşteri Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'firmadi', 'class'=>'sort'),
                array('dataTitle'=>'eposta', 'class'=>'sort')
            ),
            'tools' =>array(
              array('title'=>'Bakiye Ekle','icon'=>'fa fa-money','url'=>$this->BaseAdminURL($this->modulName.'/bakiye/'),'color'=>'green'),

              array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),

                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')

              ),
            'buton'=> array(array('type'=>'radio','dataname'=>'aktif','url'=>$this->BaseAdminURL($this->modulName.'/durum/')),
            array('type'=>'button2','title'=>'<i class="fa fa-envelope"></i>','class'=>'btn btn-primary sendEmail','dataname'=>'email','url'=>$this->BaseAdminURL($this->modulName.'/sendEmail/'))
          ),
            'pdata' => $this->dbConn->sorgu('select * from uyelik ORDER   BY  sira,id'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Adı Soyadı','width'=>'20%'),
                array('title'=>'E-Posta','width'=>'20%'),
                array('title'=>'Aktif','width'=>'5%'),
                array('title'=>'Email','width'=>'5%'),
            )
        ));

    }


    public  function _SMTP_MAIL_SEND($to,$subject,$govde,$mailCC=null)
    {
        //Create a new PHPMailer instance
        $mail = new \PHPMailer(true);
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;

        $mail->CharSet = 'UTF-8';
        //Ask for HTML-friendly debug output
        //Set the hostname of the mail server
        $mail->Host = $this->get_element('SmtpHost');
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = ($this->get_element('SmtpPort')) ? $this->get_element('SmtpPort'):587;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Set the encryption system to use - ssl (deprecated) or tls
        (($this->get_element('SmtpSecret') == 0) ? $mail->SMTPSecure = $this->get_element('SmtpSecret') :null)  ;
        //Username to use for SMTP authentication
        $mail->Username = $this->get_element('SmtpUser');
         //Password to use for SMTP authentication
        $mail->Password = $this->get_element('SmtpPass');


        //Set who the message is to be sent from
        $mail->setFrom($this->get_element('SmtpMail'), $this->get_element('title').' - '.$subject);
         //Set an alternative reply-to address
        //  $mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress($to,$to);
        //Set the subject line

        if ($mailCC != null){
            $mail->AddCC($mailCC, $mailCC); // CC MAİL
        }


        $mail->Subject =  $subject;
       //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($govde);
        //Replace the plain text body with one created manually
        //$mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
        if ($mail->send())  return 1; else return 0;

    }

    public function sendEmail($id=null)
    {

      if ($id && $id != ""){
        $uye = $this->dbConn->tekSorgu("SELECT * FROM uyelik WHERE id = $id");
        $subject = " Üyelik Başvurusu";
        $govde = '<!doctype html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>'.$subject.'</title>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin-ext" rel="stylesheet">
            <style media="all" type="text/css">

            body,*{
                font-family: "Open Sans", sans-serif !important;
            }
                  table td , table ,th { line-height: 25px;}
                @media all {
                    .btn-primary table td:hover {
                        background-color: #34495e !important;
                    }
                    .btn-primary a:hover {
                        background-color: #34495e !important;
                        border-color: #34495e !important;
                    }
                }

                @media all {
                    .btn-secondary a:hover {
                        border-color: #34495e !important;
                        color: #34495e !important;
                    }
                }

                @media only screen and (max-width: 620px) {
                    table[class=body] h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important;
                    }
                    table[class=body] h2 {
                        font-size: 22px !important;
                        margin-bottom: 10px !important;
                    }
                    table[class=body] h3 {
                        font-size: 16px !important;
                        margin-bottom: 10px !important;
                    }
                    table[class=body] p,
                    table[class=body] ul,
                    table[class=body] ol,
                    table[class=body] td,
                    table[class=body] span,
                    table[class=body] a {
                        font-size: 16px !important;
                    }
                    table[class=body] .wrapper,
                    table[class=body] .article {
                        padding: 10px !important;
                    }
                    table[class=body] .content {
                        padding: 0 !important;
                    }
                    table[class=body] .container {
                        padding: 0 !important;
                        width: 100% !important;
                    }
                    table[class=body] .header {
                        margin-bottom: 10px !important;
                    }
                    table[class=body] .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;
                    }
                    table[class=body] .btn table {
                        width: 100% !important;
                    }
                    table[class=body] .btn a {
                        width: 100% !important;
                    }
                    table[class=body] .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important;
                    }
                    table[class=body] .alert td {
                        border-radius: 0 !important;
                        padding: 10px !important;
                    }
                    table[class=body] .span-2,
                    table[class=body] .span-3 {
                        max-width: none !important;
                        width: 100% !important;
                    }
                    table[class=body] .receipt {
                        width: 100% !important;
                    }
                }

                @media all {
                    .ExternalClass {
                        width: 100%;
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;
                    }
                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    }
                }
            </style>
        </head>
        <body class="" style="font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f6f6f6; margin: 0; padding: 0;">
        <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" width="100%" bgcolor="#f6f6f6">
            <tr>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
                <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px;" width="580" valign="top">
                    <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                    <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">

                    </span>
                        <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff; border-radius: 3px;" width="100%">


                            <tr>
                                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                                        <tr>
                                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"></p>
                                                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"></p>
                                                <table border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box; display: block;" width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;" valign="top">
                                                              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;" width="100%">
                                                                <tbody>

                                                                  <tr>
                                                                      <td colspan="2">Merhaba <strong>'.$uye["adisoyadi"].'</strong><br>
                                                                      Asya Carpet web sitesindeki üyeliğiniz onaylanmıştır. Web sitemize email adresiniz ve şifrenizle giriş yaparak, sizlere özel koleksiyonlarımızı inceleyebilirsiniz.
                                                                      </td>
                                                                  </tr>

                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">İyi Çalışmalar.</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!-- END MAIN CONTENT AREA -->
                        </table>

                    </div>
                </td>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
            </tr>
        </table>
        </body>
        </html>
  ';


        if($this->_SMTP_MAIL_SEND($uye["eposta"],$subject,$govde,$mailCC)){
          echo "1";
        }
        else {
          echo "2";
        }

      }


        exit;
    }

    public function CustomPageCss($url)
    {
    }


    public function CustomPageJs($url)
    {

    }

}
