<?
$dil_ekle = ($lang != "tr") ? $lang."/" : "";
$ids = ($lang != "tr") ? "lang_" : "";
$mid = ($lang != "tr") ? "master_" : "";
if ($lang != "tr"){
    $kurumsal = $this->teksorgu("SELECT * FROM yazilar_lang WHERE lang_id = $id and dil = '$lang'");
}
else {
    $kurumsal = $this->teksorgu("SELECT * FROM yazilar WHERE id = $id");
}
if ($id == 0){
   if ($lang != "tr"){
        $qq = $this->teksorgu("SELECT *, (SELECT sira FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as sira FROM yazilar_lang WHERE dil = '$lang' and kid = 1 ORDER BY sira ASC");
    }
    else {
        $qq = $this->teksorgu("SELECT * FROM yazilar WHERE kid = 1 ORDER BY sira ASC");
    }
    $sBaslik = $qq["baslik"];
    if ($lang == "ar"){
      $m_id = $qq["master_id"];
      $enSor = $this->teksorgu("SELECT baslik FROM yazilar_lang WHERE master_id = $m_id and dil = 'en'");
      $sBaslik = $enSor["baslik"];
    }
    $urlq = $this->BaseURL($dil_ekle.$this->lang->link('kurumsal')."/".$this->permalink($sBaslik)."-".$qq[$ids."id"].'.html');
    $this->RedirectURL($urlq);
}
$this->sayfaBaslik = $this->temizle($kurumsal["baslik"])." - ".$this->ayarlar("title_".$lang);
?>

<section class="tophedic">
    <img src="<?=$this->themeURL?>images/icband.jpg" alt="">
    <div class="container">
        <div class="breactum">
            <ul>
                <li><a href="<?=$this->BaseURL($dil_ekle."index.html")?>"><?=$this->lang->header('index')?></a></li>
                <li><a href="<?=$this->BaseURL($dil_ekle."kurumsal.html")?>"><?=$this->lang->header('kurumsal')?></a></li>
                <li><a href=""><?=$this->temizle($kurumsal['baslik'])?></a></li>
            </ul>
        </div>
    </div>
</section>

<section class="contentSayfa">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="sidebar">
                    <h3><?=$this->lang->header('kurumsal')?></h3>
                    <ul>
                        <?
                        if ($lang != "tr"){
                            $yazilar = $this->sorgu("SELECT *, (SELECT sira FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as sira, (SELECT resim FROM yazilar WHERE yazilar.id = yazilar_lang.master_id) as resim FROM yazilar_lang WHERE kid = 1 and dil = '$lang' ORDER BY sira ASC");
                        }
                        else {
                            $yazilar = $this->sorgu("SELECT * FROM yazilar WHERE kid = 1 ORDER BY sira ASC");
                        }
                        foreach ($yazilar as $yazi) {
                        $sBaslik = $yazi["baslik"];
                        $urlY = $this->BaseURL($dil_ekle.$this->lang->link('kurumsal')."/".$this->permalink($sBaslik)."-".$yazi[$ids."id"].'.html');
                        ?>
                        <li><a href="<?=$urlY?>"><?=$this->temizle($yazi['baslik'])?></a></li>
                        <? } ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="icSyf">
                    <h5><?=$this->temizle($kurumsal['baslik'])?></h5>
                    <p>
                        <?=$this->temizle($kurumsal['detay'])?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
