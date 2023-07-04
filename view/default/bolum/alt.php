<?
$dil_ekle = "";
$ids = "";
    if ($lang != "tr"){
        $dil_ekle = $lang."/";
        $ids = "lang_";
    }
?>

<footer>
    <div class="container">
        <div class="row">
            <ul class="sosyalMedya">
                <li><a href="<?=$this->ayarlar('fbURL')?>"><i class="fa fa-facebook"></i></a></li>
                <li><a href="<?=$this->ayarlar('twURL')?>"><i class="fa fa-twitter"></i></a></li>
                <li><a href="<?=$this->ayarlar('insURL')?>"><i class="fa fa-instagram"></i></a></li>
            </ul>
            <div class="menuFooter">
                <ul>
                    <li><a href="<?=$this->BaseURL($dil_ekle."index.html")?>"><?=$this->lang->header('index')?></a></li>
                    <li><a href="<?=$this->BaseURL($dil_ekle."kurumsal.html")?>"><?=$this->lang->header('kurumsal')?></a></li>
                    <li><a href="<?=$this->BaseURL($dil_ekle."araclar.html")?>"><?=$this->lang->header('araclar')?></a></li>
                    <li><a href="<?=$this->BaseURL($dil_ekle."hizmetler.html")?>"><?=$this->lang->header('hizmetler')?></a></li>
                    <li><a href="<?=$this->BaseURL($dil_ekle."kurumsal/kiralama-sartlari-4.html")?>"><?=$this->lang->header('kiralama-sartlari')?></a></li>
                    <li><a href="<?=$this->BaseURL($dil_ekle."iletisim.html")?>"><?=$this->lang->header('iletisim')?></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<div class="footer-alt">
    <p>Copyright @ 2019 YILDIZ OTO KİRALAMA - Tüm Hakları Sakldır.</p>
</div>