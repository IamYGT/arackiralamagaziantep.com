<?
$dil_ekle = "";
$ids = "";
$logo = "";
if ($lang != "tr"){
    $dil_ekle = $lang."/";
    $ids = "lang_";
}
$this->sayfaBaslik = $this->lang->header("iletisim")." - ".$this->ayarlar("title_".$lang);
?>


<section class="tophedic">
    <iframe src="https://www.google.com/maps/d/embed?mid=1OeA_1ojncQPHvErDP5n54TjoULZ1cBnq" width="100%" height="480"></iframe>
    <div class="container">
        <div class="breactum" style="bottom: 8px;">
            <ul>
                <li><a href="<?=$this->BaseURL($dil_ekle."index.html")?>"><?=$this->lang->header('index')?></a></li>
                <li><a href="<?=$this->BaseURL($dil_ekle."iletisim.html")?>"><?=$this->lang->header('iletisim')?></a></li>
            </ul>
        </div>
    </div>
</section>


<section class="iletisim">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="Left">
                    <h2><?=$this->lang->header('iletisim-bilgileri')?></h2>
                    <ul>
                        <li><b>Adres:</b> <?=$this->ayarlar('adres_merkez')?> </li>
                        <li><b><?=$this->lang->header('telefon')?>:</b> <?=$this->ayarlar('telefon_merkez')?> </li>
                        <li><b>Gsm:</b> <?=$this->ayarlar('gsm_merkez')?></li>
                        <li><b><?=$this->lang->header('posta')?>:</b> <?=$this->ayarlar('ileteposta_merkez')?></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="Right">
                    <h2><?=$this->lang->header('iletisim-formu')?></h2>
                    <?php
                    if ( $_POST ){
                        $adsoyad = htmlspecialchars(trim($_POST['mail']));
                        $email= htmlspecialchars(trim($_POST['mail']));
                        $ad = htmlspecialchars(trim($_POST['ad']));
                        $telefon = htmlspecialchars(trim($_POST['telefon']));
                        $mesaj = htmlspecialchars(trim($_POST['mesaj']));

                        $eposta1 =  "yildizrentacar2019@gmail.com";
                        include 'mail/class.phpmailer.php';
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->SMTPAuth = true;
                        $mail->Host = 'mail.izray.com.tr';
                        $mail->Port = 465;
                        $mail->SMTPSecure = 'ssl';
                        $mail->Username = 'web@izray.com.tr';
                        $mail->Password = 'izraycomtrdk';
                        $mail->SetFrom($mail->Username, 'Yıldız Rent A Car');
                        $mail->AddAddress($eposta1, $adsoyad);
                        $mail->CharSet = 'UTF-8';
                        $mail->Subject = 'Yıldız Rent A Car';
                        $content = '<div style="background: #eee; padding: 10px; font-size: 14px"> <p> '.$ad.' </p> <p> '.$email.' </p> <p> '.$telefon.' </p> <p> '.$mesaj.'</p> </div>';
                        $mail->MsgHTML($content);
                        if($mail->Send()) {
                            // e-posta başarılı ile gönderildi
                            echo '<div class="alert alert-success">E-posta başarıyla gönderildi</div>';
                        } else {
                            // bir sorun var, sorunu ekrana bastıralım
                            echo '<div class="alert alert-danger">'.$mail->ErrorInfo.'</div>'; } } ?>
                        <form method="post">

                            <div class="form-group">
                                <input type="text" class="form-control" name="ad" placeholder="<?=$this->lang->header('ad')?>">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="telefon" placeholder="<?=$this->lang->header('telefon')?>">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="mail" placeholder="<?=$this->lang->header('posta')?>">
                            </div>

                            <div class="form-group">
                                <textarea type="text" class="form-control" name="mesaj" placeholder="<?=$this->lang->header('mesaj')?>"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary"><?=$this->lang->header('gonder')?></button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</section>