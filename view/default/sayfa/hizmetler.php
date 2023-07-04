<?
$dil_ekle = "";
$ids = "";
$logo = "";
if ($lang != "tr"){
    $dil_ekle = $lang."/";
    $ids = "lang_";
}
$this->sayfaBaslik = "Blog - ".$this->ayarlar("title_".$lang);
?>
<section class="tophedic">
    <img src="<?=$this->themeURL?>images/icband.jpg" alt="">
    <div class="container">
        <div class="breactum">
            <ul>
                <li><a href="<?=$this->BaseURL($dil_ekle."index.html")?>"><?=$this->lang->header('index')?></a></li>
                <li><a href="<?=$this->BaseURL($dil_ekle."hizmetler.html")?>"><?=$this->lang->header('hizmetler')?></a></li>
            </ul>
        </div>
    </div>
</section>



<section class="hizmetlerPAGE">
    <h3 class="baslik"><?=$this->lang->header('hizmetler')?></h3>
    <div class="container">
        <div class="row">


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
            <div class="col-md-3">
                <div class="ic">
                    <div class="ic">
                        <a href="<?=$urlHi?>">
                            <img src="<?=$g_resim?>" alt="">
                            <h3><?=$this->temizle($yazi['baslik'])?></h3>
                        </a>
                    </div>
                </div>
            </div>
            <? } } ?>

        </div>
    </div>
</section>
