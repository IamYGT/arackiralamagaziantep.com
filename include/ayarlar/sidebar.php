<?php
return [

    [
        'href' => 'Index',
        'title' =>'Anasayfa',
        'icon' => 'fa  fa-home',
        'active' => true,
        'display'=>true,
        'submenu' => null
    ],

    [ 'href' => 'Hizmetler/liste',
        'title' =>'Hizmetler',
        'icon' => 'fa  fa-cog',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],

    [ 'href' => 'Kur/liste',
        'title' =>'Kurlar',
        'icon' => 'fa  fa-dollar',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],

    [ 'href' => 'Fiyatlar/liste',
        'title' =>'Paket Seçim Fiyatları',
        'icon' => 'fa  fa-money',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],


    [ 'href' => 'Sigorta/liste',
        'title' =>'Sigortalı Gönderim Fiyatları',
        'icon' => 'fa  fa-plus',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],

    [ 'href' => 'Metro/liste',
        'title' =>'Bakü Metro',
        'icon' => 'fa  fa-bus',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],


    [ 'href' => 'Iller/liste',
        'title' =>'Bakü Dışı İller',
        'icon' => 'fa  fa-university',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],

    [ 'href' => 'Nasil/liste',
        'title' =>'Nasıl çalışır',
        'icon' => 'fa  fa-bullhorn',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],



    [ 'href' => 'Etkinlikler/liste',
        'title' =>'Etkinlikler',
        'icon' => 'fa  fa-bullhorn',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],


    [ 'href' => 'Popup/liste',
        'title' =>'Siparişler',
        'icon' => 'fa fa-product-hunt',
        'active' => true,
        'display'=>false,
        'submenu' => false,
    ],


    [ 'href' => 'Ekatalog/Liste/',
        'title' =>'E-Katalog',
        'icon' => 'fa  fa-copy',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],


    [ 'href' => 'Edergi/liste/',
        'title' =>'E-Dergi',
        'icon' => 'fa  fa-columns',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],


    [ 'href' => 'Uretim',
        'title' =>'Sektörler',
        'icon' => 'fa  fa-cogs',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'liste','title' =>'Sektör Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],

    [ 'href' => 'Belge',
        'title' =>'Sertifikalar',
        'icon' => 'fa fa-file-image-o',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Belge Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Belge Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],

    [ 'href' => 'Ihracat',
        'title' =>'İhracat',
        'icon' => 'fa fa-globe',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Ülke Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Ülke Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],

    [ 'href' => 'Araclar',
        'title' =>'Araçlar',
        'icon' => 'fa  fa-product-hunt',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Araç Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Araç Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
            [ 'href' => 'ikielaracekle','title' =>'2. El Araç Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'ikielaracliste','title' =>'2. El Araç Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],

        ]
    ],
    [ 'href' => 'Bilgi',
        'title' =>'Bilgi Bankası',
        'icon' => 'fa  fa fa-comments',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Bilgi Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Bilgi Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],

    [ 'href' => 'Yorumlar',
        'title' =>'Yorumlar',
        'icon' => 'fa  fa fa-comments',
        'active' => true,
        'display'=> false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Yorum Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Yorum Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],

    [ 'href' => 'Nedediler',
        'title' =>'Ne Dediler',
        'icon' => 'fa  fa fa-comments',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Yorum Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Yorum Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],

    [ 'href' => 'Sss',
        'title' =>'Sıkça Sorulan Sorular',
        'icon' => 'fa  fa-newspaper-o',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Soru Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Soru Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],


    [ 'href' => 'Tarifeler',
        'title' =>'Uygulamalar',
        'icon' => 'fa  fa-photo',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Liste','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],

    [ 'href' => 'Haberler/liste',
        'title' =>'Araçlar',
        'icon' => 'fa  fa-car',
        'active' => true,
        'display'=>true,
        'submenu' => false,
    ],

    [ 'href' => 'Iletisim/liste',
        'title' =>'İletişim',
        'icon' => 'fa  fa-phone',
        'active' => true,
        'display'=>false,
        'submenu' => false,
    ],


    [ 'href' => 'Reklamlar/liste',
        'title' =>'Reklamlar',
        'icon' => 'fa  fa-user',
        'active' => true,
        'display'=>false,
        'submenu' => false,
    ],


    [ 'href' => 'FiyatListesi',
        'title' =>'Fiyat Listesi',
        'icon' => 'fa  fa-money',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Fiyat Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Fiyat Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
            [ 'href' => 'kategoriEkle','title' =>'Fiyat Kategorisi  Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'kategoriListesi','title' =>'Fiyat Kategorisi Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],

    [ 'href' => '',
        'title' =>'Paketler',
        'icon' => 'fa fa-product-hunt',
        'active' => true,
        'display'=>false,
        'submenu' => []
    ],

    [ 'href' => 'Urunler',
        'title' =>'Ürünler',
        'icon' => 'fa fa-product-hunt',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'liste','title' =>'Ürün Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'kategoriListesi','title' =>'Ürün Grupları','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
            //  [ 'href' => 'sektorekle','title' =>'Sektör Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            //[ 'href' => 'sektor','title' =>'Sektör Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
            // [ 'href' => 'ozellikekle','title' =>'Özellik Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            //[ 'href' => 'ozellik','title' =>'Özellik Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
        ]
    ],

    [ 'href' => 'Bakiye/liste',
        'title' =>'Bakiye',
        'icon' => 'fa fa-dollar',
        'active' => true,
        'display'=>false,
    ],

    [ 'href' => 'Kategoriler/liste',
        'title' =>'Kategoriler',
        'icon' => 'fa fa-product-hunt',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],


    [ 'href' => 'Teknik/liste',
        'title' =>'Döküman Talep Listesi',
        'icon' => 'fa fa-product-hunt',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],

    [ 'href' => 'Temsilcilik/liste',
        'title' =>'Temsilcilik Talep Listesi',
        'icon' => 'fa fa-users',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],


    [ 'href' => 'Turlar',
        'title' =>'Turlar',
        'icon' => 'fa fa-bus',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Tur Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Tur Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'kategoriEkle','title' =>'Tur Kategorisi Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'kategoriListesi','title' =>'Tur Kategorisi Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
        ]
    ],
    [ 'href' => 'islamitatil',
        'title' =>'İslamitatil',
        'icon' => 'fa fa-bus',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'İslami Tatil Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'İslami Tatil Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'kategoriEkle','title' =>'İslami Tatil Kategorisi Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'kategoriListesi','title' =>'İslami Tatil Kategorisi Listele','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'ozellikekle','title' =>'Özellik Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'ozellik','title' =>'Özellik Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
            //[ 'href' => 'fiyatekle','title' =>'Fiyat Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            //[ 'href' => 'fiyat','title' =>'Fiyat Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
        ]
    ],


    [ 'href' => 'Bayilikler',
        'title' =>'Bayilikler',
        'icon' => 'fa  fa-home',
        'active' => false,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Bayilik Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Bayilik Listesi','icon' => 'fa  fa-list','active' => true,'display'=>true,'submenu' => null],
        ]
    ],

    [ 'href' => 'Galeri/liste',
        'title' =>'Foto Galeri',
        'icon' => 'fa fa-photo',
        'active' => true,
        'display'=>false,
        'submenu' => false
    ],

    [ 'href' => 'Video',
        'title' =>'Video Galeri',
        'icon' => 'fa  fa-video-camera',
        'active' => false,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Video Ekle','icon' => 'fa  fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Video Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
        ]
    ],

    [ 'href' => 'Video2',
        'title' =>'Anasayfa Video',
        'icon' => 'fa  fa-video-camera',
        'active' => false,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Video Ekle','icon' => 'fa  fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Video Listesi','icon' => 'fa fa-list','active' => true,'display'=>true,'submenu' => null],
        ]
    ],

    [ 'href' => 'Referanslar/liste',
        'title' =>'Markalar',
        'icon' => 'fa  fa-users',
        'display'=>false,
        'active' => false,
        'submenu' => false,
    ],


    [ 'href' => 'Magazalar/liste',
        'title' =>'Referanslar',
        'icon' => 'fa  fa-home',
        'display'=>false,
        'active' => false,
        'submenu' => false,
    ],

    [ 'href' => 'Hesaplama/liste',
        'title' =>'Hesaplama',
        'icon' => 'fa  fa-credit-card',
        'display'=>false,
        'active' => true,
        'submenu' => false,
    ],

    [ 'href' => 'Projeler/liste',
        'title' =>'Projeler',
        'icon' => 'fa  fa-cogs',
        'display'=>false,
        'active' => true,
        'submenu' => false,
    ],

    [ 'href' => 'Sayfa/Sayfaliste',
        'title' =>'Sayfalar',
        'icon' => 'fa fa-file-text',
        'active' => true,
        'display'=>true,
        'submenu' => false
    ],
    [ 'href' => 'Bulten',
        'title' =>'E-Bülten',
        'icon' => 'fa fa-home',
        'active' => false,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'E-mail Ekle','icon' => 'fa  fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'E-mail Listesi','icon' => 'fa  fa-list','active' => true,'display'=>true,'submenu' => null],
            //[ 'href' => 'BultenEkle','title' =>'Bülten Ekle','icon' => 'fa  fa-pencil','active' => true,'display'=>true,'submenu' => null],
            //[ 'href' => 'BultenListesi','title' =>'Bülten   Listesi','icon' => 'fa  fa-list','active' => true,'display'=>true,'submenu' => null],
        ]
    ],
    [ 'href' => 'Slayt/liste',
        'title' =>'Slayt',
        'icon' => 'fa fa-picture-o',
        'active' => true,
        'display'=>true,
        'submenu' => false
    ],
    [ 'href' => 'Uyeler',
        'title' =>'Üyeler',
        'icon' => 'fa fa-user',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Üye Ekle','icon' => 'fa fa-pencil','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Üye Listesi','icon' => 'fa  fa-list','active' => true,'display'=>true,'submenu' => null],
        ]
    ],

    [ 'href' => 'Notlar',
        'title' =>'Notlar',
        'icon' => 'fa  fa-sticky-note',
        'active' => true,
        'display'=>false,
        'submenu' => [
            [ 'href' => 'ekle','title' =>'Not Ekle','icon' => 'fa  fa-pencil','active' => true, 'display'=>true,'submenu' => null],
            [ 'href' => 'liste','title' =>'Not Listesi','icon' => 'fa  fa-list','active' => true, 'display'=>true, 'submenu' => null],
        ]
    ],



    ['href' =>'ayar',
        'title'=>'Genel Ayarlar',
        'icon' => 'fa  fa-cogs',
        'active'=> true,
        'display'=>true,
        'submenu'=> [
            [ 'href' => 'ayarlar' ,'title' =>'Ayarlar','icon' => 'fa  fa-cog','active' => true,'display'=>true,'submenu' => null],
            [ 'href' => 'sehirEkle','title' =>'Şehir Ekle','icon' => 'fa fa-globe','active' => true,'display'=>false,'submenu' => null],
            [ 'href' => 'sehirListesi','title' =>'Şehir Listesi','icon' => 'fa fa-globe','active' => true,'display'=>false,'submenu' => null],
            [ 'href' => 'bolgeEkle','title' =>'Bölge Ekle','icon' => 'fa fa-globe','active' => true,'display'=>false,'submenu' => null],
            [ 'href' => 'bolgeListesi','title' =>'Bölge Listesi','icon' => 'fa fa-globe','active' => true,'display'=>false,'submenu' => null],
        ]]
    ];
?>