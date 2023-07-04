<?
$dil_ekle = "";
$ids = "";
$logo = "";
if ($lang != "tr"){
    $dil_ekle = $lang."/";
    $ids = "lang_";
}
$this->sayfaBaslik = "Araçlar - ".$this->ayarlar("title_".$lang);
?>

<section class="tophedic">
    <img src="<?=$this->themeURL?>images/icband.jpg" alt="">
    <div class="container">
        <div class="breactum">
            <ul>
                <li><a href="<?=$this->BaseURL($dil_ekle."index.html")?>"><?=$this->lang->header('index')?></a></li>
                <li><a href="<?=$this->BaseURL($dil_ekle."araclar.html")?>"><?=$this->lang->header('araclar')?></a></li>
            </ul>
        </div>
    </div>
</section>

<section class="araclarPAGE">
    <h3 class="baslik"><?=$this->lang->header('araclarimiz')?></h3>
    <div class="container">
        <div class="row">
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
                $g_resim = $this->BaseURL($this->resimal(0,900,$resim,$this->settings->config('folder')."haber/", false));
                $b_resim = $this->BaseURL($this->resimal(370,315,$resim,$this->settings->config('folder')."haber/", false));
            }
            else {
                $g_resim = $this->BaseURL($this->resimal(370,315,'no-haber.jpg',$this->settings->config('folder')));
            }
            $sBaslik = $haber["baslik"];
            $urlA = $this->BaseURL($dil_ekle.$this->lang->link('arac')."/".$this->permalink($sBaslik)."-".$haber[$ids."id"].'.html');
            ?>
            <div class="col-md-3">
                <div class="urunCar">
                    <img src="<?=$g_resim?>" alt="">
                    <div class="ic">
                        <h4><?=$this->temizle($haber['baslik'])?></h4>
                        <span>₺<?=$this->temizle($haber['ozet'])?></span>
                        <a href="<?=$urlA?>"><?=$this->lang->header('incele')?></a>
                    </div>
                </div>
            </div>
            <? } } ?>



        </div>
    </div>
</section>