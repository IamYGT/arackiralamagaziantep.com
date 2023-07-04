<?php


namespace AdminPanel;


class Sirala extends Settings
{

    public $settings;
    public $SayfaBaslik = 'Sıralama';

    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->settings = $settings;
    }

    public function index()
    {
        return 'Sıralama';
    }
    public  function Video()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'videolar')) echo 'Videolar Sıralandı';
    }

    public function katalog()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'katalog')) echo 'E-Katalog Sıralandı';
    }
    public function Bayilik()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'bayilikler')) echo 'Bayilikler Sıralandı';
    }
    public function Slogan()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'slogan')) echo 'Sloganlar Sıralandı';
    }

    public function Tarifeler()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'tarifeler')) echo 'Alan Sıralandı';
    }

    public  function Sektor()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'sektorler')) echo 'Sektorler Sıralandı';
    }

    public  function fotogaleri()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'fotogaleri')) echo 'Galeri Sıralandı';
    }

    public  function fiyatkategorisi()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'fiyatkategorisi')) echo 'Kategori Sıralandı';
    }

    public  function fiyat()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'fiyatlistesi')) echo 'Fiyat Listesi Sıralandı';
    }

    public  function popup()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'popup')) echo 'Popup Sıralandı';
    }

    public  function Araclar()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'araclar')) echo 'Araçlar Sıralandı';
    }

    public  function sss()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'sss')) echo 'SSS Sıralandı';
    }


    public  function Marka()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'markalar')) echo 'Markalar Sıralandı';
    }

    public  function dosyalar()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'dosyalar')) echo 'Dosyalar Sıralandı';
    }

    public  function duyurular()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'duyurular')) echo 'Duyurular Sıralandı';
    }

    public  function bulten()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'bultenmail')) echo 'E-postalar Sıralandı';
    }

     public  function islamkategorisi()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'islamkategorisi')) echo 'Kategoriler Sıralandı';
    }
    public  function islamitatil()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'islamitatil')) echo 'Oteller Sıralandı';
    }

    public  function mpUrun()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'murunler')) echo 'Ürünler Sıralandı';
    }

    public  function Urun()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        $page = $_GET["page"];
        if($this->sirala($sirala,'urunler', $page)) echo 'Ürünler Sıralandı';
    }

    public  function urunGrubu()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'kategoriler')) echo 'Ürün Grubu Sıralandı';
    }

    public  function UrunRenk()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'urun_renkleri')) echo 'Ürün Renkleri Sıralandı';
    }

    public  function mpurunGrubu()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'mkategori')) echo 'Ürün Grubu Sıralandı';
    }

    public  function Slayt()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'slayt')) echo 'Slaytlar Sıralandı';
    }

    public  function Sayfa()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'yazilar')) echo 'Sayfalar Sıralandı';
    }

    public  function Yazi()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'yazilar')) echo 'Yazilar Sıralandı';
    }

    public  function haberler()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'haberler')) echo 'Haberler Sıralandı';
    }

    public  function iletisim()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'iletisim')) echo 'İletişim Bilgileri Sıralandı';
    }

    public  function Referanslar()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'referanslar')) echo 'Referanslar Sıralandı';
    }

    public  function Projeler()
    {
        $sirala = (isset($_GET['sirala'])) ? $_GET['sirala']:0;
        if($this->sirala($sirala,'projeler')) echo 'Projeler Sıralandı';
    }

} 