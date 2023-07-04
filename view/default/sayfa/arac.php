<?
$dil_ekle = ($lang != "tr") ? $lang."/" : "";
$ids = ($lang != "tr") ? "lang_" : "";
if ($lang != "tr"){
    $kat = $this->teksorgu("SELECT *, (SELECT resim FROM haberler WHERE haberler.id = haberler_lang.master_id) as resim FROM haberler_lang WHERE lang_id = $id");
}
else {
    $kat = $this->teksorgu("SELECT * FROM haberler WHERE id = $id");
}
$detayResim = $this->resimGet($kat['resim']);
if($detayResim and file_exists($this->settings->config('folder')."haber/".$detayResim))
$detayResimAl = $this->BaseURL($this->resimal(860,400,$detayResim,$this->settings->config('folder')."haber/"));
else
$detayResimAl = $this->BaseURL($this->resimal(860,400,'no-haber.jpg',$this->settings->config('folder')));
$this->sayfaBaslik = $this->temizle($kat["baslik"])." - ".$this->ayarlar("title_".$lang);
?>


<section class="tophedic">
    <img src="<?=$this->themeURL?>images/icband.jpg" alt="">
    <div class="container">
        <div class="breactum">
            <ul>
                <li><a href="<?=$this->BaseURL($dil_ekle."index.html")?>"><?=$this->lang->header('index')?></a></li>
                <li><a href="<?=$this->BaseURL($dil_ekle."araclar.html")?>"><?=$this->lang->header('araclar')?></a></li>
                <li><a href=""><?=$this->temizle($kat['baslik'])?></a></li>
            </ul>
        </div>
    </div>
</section>

<section class="araclarPAGE">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="sidebar">
                    <h3><?=$this->lang->header('araclar')?></h3>
                    <ul>
                        <?
                        if ($lang != "tr"){
                            $haberler = $this->sorgu("SELECT *, (SELECT sira FROM haberler WHERE haberler.id = haberler_lang.master_id) as sira, (SELECT resim FROM haberler WHERE haberler.id = haberler_lang.master_id) as resim FROM haberler_lang WHERE dil = '$lang' ORDER BY sira ASC");
                        }
                        else {
                            $haberler = $this->sorgu("SELECT * FROM haberler ORDER BY sira ASC");
                        }
                        if (is_array($haberler)){
                        foreach ($haberler as $haber) {
                        $resim  = $this->resimGet($haber['resim']);
                        if($resim and file_exists($this->settings->config('folder')."haber/".$resim)){
                            $g_resim2 = $this->BaseURL($this->resimal(65,65,$resim,$this->settings->config('folder')."haber/", false));
                            $b_resim = $this->BaseURL($this->resimal(370,315,$resim,$this->settings->config('folder')."haber/", false));
                        }
                        else {
                            $g_resim2 = $this->BaseURL($this->resimal(65,65,'no-haber.jpg',$this->settings->config('folder')));
                        }
                        $sBaslik = $haber["baslik"];
                        $urlH = $this->BaseURL($dil_ekle.$this->lang->link('arac')."/".$this->permalink($sBaslik)."-".$haber[$ids."id"].'.html');
                        ?>
                             <li><a href="<?=$urlH?>"><?=$this->temizle($haber['baslik'])?></a></li>
                        <? } } ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="aracDetay">

                    <h1><?=$this->temizle($kat['baslik'])?></h1>

                    <img src="<?=$detayResimAl?>" width="100%" alt="">

                   <?=$this->temizle($kat['detay'])?>
                </div>

                <div class="rezervasyonDetay">
                    <h4><?=$this->lang->header('rezervasyon')?></h4>
                    <?php
                    if ( $_POST ){
                        $adsoyad = htmlspecialchars(trim($_POST['ad']));
                        $ad = htmlspecialchars(trim($_POST['ad']));
                        $telefon = htmlspecialchars(trim($_POST['telefon']));
                        $mesaj = htmlspecialchars(trim($_POST['arac']));
                        $tarih = htmlspecialchars(trim($_POST['tarih']));

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
                        $content = '<div style="background: #eee; padding: 10px; font-size: 14px"> <p> '.$ad.' </p> <p> '.$telefon.' </p> <p> '.$tarih.' </p> <p> '.$mesaj.'</p> </div>';
                        $mail->MsgHTML($content);
                        if($mail->Send()) {
                            // e-posta başarılı ile gönderildi
                            echo '<div class="alert alert-success">E-posta başarıyla gönderildi</div>';
                        } else {
                            // bir sorun var, sorunu ekrana bastıralım
                            echo '<div class="alert alert-danger">'.$mail->ErrorInfo.'</div>'; } } ?>
                    <form method="post">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="ad" placeholder="<?=$this->lang->header('ad')?>">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="telefon" placeholder="<?=$this->lang->header('telefon')?>">
                            </div>

                            <div class="form-group col-md-6 margin-b-0">
                                <select class="form-control" id="exampleFormControlSelect1" name="arac">
                                    <option value="<?=$this->temizle($kat['baslik'])?>"><?=$this->temizle($kat['baslik'])?></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-6 margin-b-0">
                                        <input type="date" class="form-control" name="tarih" placeholder="<?=$this->lang->header('alis-tarihi')?>">
                                    </div>
                                    <div class="col-md-6">
                                        <button style="  background: #fff;
  width: 100%;
  display: table;
  text-align: center;
  height: 45px;
  line-height: 44px;
  font-weight: bold;
  text-transform: uppercase;
  transition: .5s;"><?=$this->lang->header('gonder')?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="AramaAracDetay">
                    <h3><?=$this->temizle($kat['baslik'])?> <?=$this->lang->header('aracini')?></h3>
                    <b><i class="fa fa-phone" aria-hidden="true"></i><?=$this->ayarlar('telefon_merkez')?></b>
                    <p><?=$this->lang->header('numaradan')?></p>
                </div>

            </div>
        </div>
    </div>
</section>