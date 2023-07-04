<?
$dil_ekle = "";
$ids = "";
if ($lang != "tr"){
    $dil_ekle = $lang."/";
    $ids = "lang_";
}
if ($lang != "tr"){
    $kurumsal = $this->teksorgu("SELECT *, (SELECT sira FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as sira, (SELECT resim FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as resim FROM yazilar_lang WHERE dil = '$lang' and master_id = 1");
}
else {
    $kurumsal = $this->teksorgu("SELECT * FROM yazilar WHERE id = 1");
}


if ($lang != "tr"){
    $markalar = $this->teksorgu("SELECT *, (SELECT sira FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as sira, (SELECT resim FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as resim FROM yazilar_lang WHERE dil = '$lang' and master_id = 3");
}
else {
    $markalar = $this->teksorgu("SELECT * FROM yazilar WHERE id = 3");
}


//$kurumsal = $this->teksorgu("SELECT * FROM yazilar WHERE id = 17");
$SayfaResim = $this->resimGet($kurumsal['resim']);
if($SayfaResim and file_exists($this->settings->config('folder')."sayfa/".$SayfaResim))
$SayfaResimAl = $this->BaseURL($this->resimal(520,300,$SayfaResim,$this->settings->config('folder')."sayfa/"));
else
$SayfaResimAl = $this->BaseURL($this->resimal(450,300,'no-haber.jpg',$this->settings->config('folder')));
$this->sayfaBaslik = $this->ayarlar("title_".$lang);
?>


<section class="slider">
    <div class="owl-carousel owl-theme" id="owl-slider">


        <?
        if ($lang != "tr"){
            $slayt = $this->sorgu("SELECT *, (SELECT sira FROM slayt WHERE slayt.id = slayt_lang.master_id) as sira, (SELECT resim FROM slayt WHERE slayt.id = slayt_lang.master_id) as resim FROM slayt_lang WHERE dil = '$lang' ORDER BY sira asc");
        }
        else {
            $slayt = $this->sorgu("SELECT * FROM slayt ORDER BY sira asc");
        }
        if (is_array($slayt)){
        foreach($slayt as $veri){
        $slayt_resim = $this->resimGet($veri['resim']);
        if($slayt_resim and file_exists($this->settings->config('folder')."slayt/".$slayt_resim)):
        $slayt_resim_al = $this->BaseURL($this->resimal(1920,600,$slayt_resim,$this->settings->config('folder')."slayt/"));
        ?>
        <div class="item">
            <div class="sliderRR" style="background-image:url(<?=$slayt_resim_al?>)">
                <div class="container">
                    <h4><?=$this->temizle($veri['baslik'])?></h4>
                    <a href="<?=$this->BaseURL($dil_ekle."araclar.html")?>"><?=$this->lang->header('araclar')?></a>
                </div>
            </div>
        </div>
        <?php endif; } } ?>
    </div>
</section>

<section class="araclar">
    <h3 class="baslik"><?=$this->lang->header('araclarimiz')?></h3>
    <div class="container">
        <div class="row">
            <div class="owl-carousel owl-theme" id="owl-araclar">


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
                    $g_resim = $this->BaseURL($this->resimal(0,1000,$resim,$this->settings->config('folder')."haber/", false));
                    $b_resim = $this->BaseURL($this->resimal(370,315,$resim,$this->settings->config('folder')."haber/", false));
                }
                else {
                    $g_resim = $this->BaseURL($this->resimal(260,400,'no-haber.jpg',$this->settings->config('folder')));
                }
                $sBaslik = $haber["baslik"];
                $urlH = $this->BaseURL($dil_ekle.$this->lang->link('arac')."/".$this->permalink($sBaslik)."-".$haber[$ids."id"].'.html');
                ?>
                <div class="item">
                    <div class="urunCar">
                        <img src="<?=$g_resim?>" alt="">
                        <div class="ic">
                            <h4><?=$this->temizle($haber['baslik'])?></h4>
                            <span>₺<?=$this->temizle($haber['ozet'])?></span>
                            <a href="<?=$urlH?>"><?=$this->lang->header('incele')?></a>
                        </div>
                    </div>
                </div>
                <? } } ?>

            </div>
        </div>
    </div>
</section>

<section class="rezervasyon">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4><?=$this->lang->header('online')?></h4>
                <p>
                    <?=$this->lang->header('arac-kiralama')?>
                </p>
            </div>
            <div class="col-md-8">
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
                                <option><?=$this->lang->header('arac-seciniz')?></option>
                                <?
                                if ($lang != "tr"){
                                    $haberler = $this->sorgu("SELECT *, (SELECT sira FROM haberler WHERE haberler.id = haberler_lang.master_id) as sira, (SELECT resim FROM haberler WHERE haberler.id = haberler_lang.master_id) as resim FROM haberler_lang WHERE dil = '$lang' ORDER BY sira ASC");
                                }
                                else {
                                    $haberler = $this->sorgu("SELECT * FROM haberler ORDER BY sira ASC");
                                }
                                foreach ($haberler as $haber) {
                                ?>
                                <option value="<?=$this->temizle($haber['baslik'])?>"><?=$this->temizle($haber['baslik'])?></option>
                                <? } ?>
                            </select>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="row">
                                 <div class="form-group col-md-6 margin-b-0">
                                    <input type="date" class="form-control" name="tarih" placeholder="<?=$this->lang->header('alis-tarihi')?>">
                                </div>

                                <div class="col-md-6">
                                    <button><?=$this->lang->header('gonder')?></button>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>



<section class="nelerYaptik">
    <h3 class="baslik"><?=$this->lang->header('neler')?></h3>
    <div class="container">
        <div class="row">
            <div class="owl-carousel owl-theme" id="owl-neler">

                <?
                if ($lang != "tr"){
                    $yazilar = $this->sorgu("SELECT *, (SELECT sira FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as sira, (SELECT resim FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as resim FROM yazilar_lang WHERE kid = 2 and dil = '$lang' ORDER BY sira ASC");
                }
                else {
                    $yazilar = $this->sorgu("SELECT * FROM yazilar WHERE kid = 2 ORDER BY sira ASC");
                }
                if (is_array($yazilar)){
                foreach ($yazilar as $yazi) {
                $resim  = $this->resimGet($yazi['resim']);
                if($resim and file_exists($this->settings->config('folder')."sayfa/".$resim)){
                $g_resim = $this->BaseURL($this->resimal(370,315,$resim,$this->settings->config('folder')."sayfa/", false));
                }
                else {
                $g_resim = $this->BaseURL($this->resimal(260,400,'no-haber.jpg',$this->settings->config('folder')));
                }
                $sBaslik = $yazi["baslik"];
                $urlHi = $this->BaseURL($dil_ekle.$this->lang->link('hizmet')."/".$this->permalink($sBaslik)."-".$yazi[$ids."id"].'.html');
                ?>
                        <div class="item">
                            <div class="ic">
                                <a href="<?=$urlHi?>">
                                    <img src="<?=$g_resim?>" alt="">
                                    <h3><?=$this->temizle($yazi['baslik'])?></h3>
                                </a>
                            </div>
                        </div>
                    <? } } ?>
            </div>
        </div>
    </div>
</section>


<section class="hemenCALL">
    <div class="container">
        <div class="row">
            <h4><?=$this->lang->header('hemen-arayin')?></h4>
            <a href="tel:<?=$this->ayarlar('telefon_merkez')?>"><?=$this->ayarlar('telefon_merkez')?></a>
        </div>
    </div>
</section>


<section class="markalar">
    <div class="container">
        <div class="row">
            <div class="owl-carousel owl-theme" id="owl-markalar">
                <?
                $veri_id = ($lang != "tr") ? $markalar["master_id"] : $markalar["id"];
                $resimSor = $this->sorgu("SELECT *, baslik as baslik_tr FROM dosyalar WHERE type='sayfa' and data_id = {$veri_id} ORDER BY sira ASC ");
                if(is_array($resimSor)){
                foreach ($resimSor as $veri):
                $resim  = $this->resimGet($veri['dosya']);
                if($resim and file_exists($this->settings->config('folder')."sayfa/".$resim)){
                $g_resim = $this->BaseURL($this->resimal2(205,205,$resim,$this->settings->config('folder')."sayfa/", false));
                $b_resim = $this->BaseURL($this->resimal2(0,800,$resim,$this->settings->config('folder')."sayfa/", false));
                }
                ?>
                <div class="item">
                    <img src="<?=$g_resim?>" alt="">
                </div>
                <? endforeach; } ?>
            </div>
        </div>
    </div>
</section>