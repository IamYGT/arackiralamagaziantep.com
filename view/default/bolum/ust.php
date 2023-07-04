<?
$dil_ekle = "";
$ids = "";
if ($lang != "tr"){
    $dil_ekle = $lang."/";
    $ids = "lang_";
}
?>

<div class="topheader">
    <div class="container">
        <ul class="cont1">
            <li><a href="#"><span><i class="fa fa-home" aria-hidden="true"></i></span> <?=$this->ayarlar('adres_merkez')?></a></li>
            <li><a href="#"><span><i class="fa fa-phone" aria-hidden="true"></i></span> <?=$this->ayarlar('telefon_merkez')?></a></li>
        </ul>
        <ul class="cont2">
            <li><a href="<?=$this->ayarlar('fbURL')?>"><i class="fa fa-facebook"></i></a></li>
            <li><a href="<?=$this->ayarlar('twURL')?>"><i class="fa fa-twitter"></i></a></li>
            <li><a href="<?=$this->ayarlar('insURL')?>"><i class="fa fa-instagram"></i></a></li>
            <li style="margin-left:50px;"><a style="border-right:1px solid #eee;padding-right:10px" href="<?=$this->BaseURL('index.html')?>">TR</a></li>
            <li><a href="<?=$this->BaseURL('en/index.html')?>">EN</a></li>
        </ul>
    </div>
</div>
<header>
    <nav class="navbar sticky-top navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?=$this->BaseURL($dil_ekle.'index.html')?>"><img src="<?=$this->themeURL?>images/logo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto w-100 justify-content-end">
                    <li class="nav-item active"><a class="nav-link" href="<?=$this->BaseURL($dil_ekle.'index.html')?>"><?=$this->lang->header('index')?> <span class="sr-only">(current)</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?=$this->BaseURL($dil_ekle.'kurumsal.html')?>"><?=$this->lang->header('kurumsal')?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?=$this->BaseURL($dil_ekle.'araclar.html')?>"><?=$this->lang->header('araclar')?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?=$this->BaseURL($dil_ekle.'hizmetler.html')?>"><?=$this->lang->header('hizmetler')?></a></li>
                    <li class="nav-item">
                        <a class="nav-link"
                           <? if ($lang == "tr") { ?>
                           href="<?=$this->BaseURL('kurumsal/kiralama-sartlari-4.html')?>" <? } else { ?> href="<?=$this->BaseURL('en/kurumsal/kiralama-sartlariiii-4.html')?>" <? } ?> >
                            <?=$this->lang->header('kiralama-sartlari')?>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?=$this->BaseURL($dil_ekle.'iletisim.html')?>"><?=$this->lang->header('iletisim')?></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>