<?php

use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 29.04.2017
 * Time: 15:13
 */
class Smap
{


    public $sabitlinkler = array(
        'tr'=>array('index'),
        'en'=>array('index')
    );

    public $pagelink =  array(
        'en' =>array(1=>'garden-furnitures',2=>'stadium-seats',3=>'households'),
        'tr' =>array(1=>'bahce-mobilyalari',2=>'stadyum-koltuklari',3=>'evgerecleri')
    );





    public function __construct($settings)
    {
        parent::__construct($settings);

    }

    public function SitemapCreate($file)
    {

 $x=0;
        $linkURL = array(
            'sabit' => $this->sabitlinkler,
            'urun' => $this->UrunLinkleri(),
            'kategori' => $this->Kategoriler(),
            'haber' => $this->Haberler(),
            'bolge' => $this->Bolgeler(),
            'faydali' => $this->Faydali(),
            'referans' => $this->Referanslar(),
            'etiket' => $this->Etiketler()

        );

        $sitemap = new Sitemap(__DIR__ . '/../'.$file);

        if(is_array($linkURL))
            foreach ($linkURL as $LinkItem):

        if(is_array($LinkItem))
         foreach ($LinkItem as $key=>$linkler):
           if(is_array($linkler))

           foreach ($linkler as $link)
           {
               $x++;

              if(is_array($link)):
               if(isset($link['url']) and $link['url'])
               {
                   if(is_array($link['get']))
                   {
                 $sitemap->addItem($this->BaseURL($link['url'],$key,1), time(), Sitemap::WEEKLY, 0.3);
                foreach ($link['get'] as $get):
                    $x++;
                $sitemap->addItem($this->BaseURL($link['url'],$key,1).'?'.(($key=='en') ? 'color':'renk').'='.$get, time(), Sitemap::WEEKLY, 0.3);
                  endforeach;
                   }
               } else $sitemap->addItem($this->BaseURL($link['url'],$key,1), time(), Sitemap::WEEKLY, 0.3);
              else:
                  $sitemap->addItem($this->BaseURL($link,$key,1), time(), Sitemap::WEEKLY, 0.3);
              endif;






           }
         endforeach;

            endforeach;

       $sitemap->write();

       echo  $x.' Link Oluşturuldu';


    }




    public function UrunLinkleri()
    {
        $data = array();
        $lang = $this->settings->lang('lang');

        if(is_array($lang))
            foreach ($lang as $lang=>$name):
             $urunler = $this->sorgu("select org_urunid as id,url_$lang,tur,(select url_$lang from tumkategori where id= tumurunler.urunkid limit 1) as katurl from tumurunler");
           if(is_array($urunler))
            foreach ($urunler as $key=>$item)
            {
                $dosyaid = $item['id'];
             $dosyalar  = $this->sorgu("select url_$lang from dosyalar where type=1 and kid='$dosyaid'");
             if($item['url_'.$lang]) $data[$lang][$key] = array('url' => $this->pagelink[$lang][$item['tur']].'/'.(($item['tur'] == 2) ?  '':$item['katurl'].'/'  ).$item['url_'.$lang]);
                $dosya = array();
            if(is_array($dosyalar) and count($dosyalar)>0)
                foreach ($dosyalar as $keyrul=>$ditem):
                    if($ditem['url_'.$lang]) $dosya[$keyrul] = $ditem['url_'.$lang] ;

                endforeach;

                $data[$lang][$key]['get']  = $dosya;

            }
         endforeach;

           return $data;

    }


    public function Kategoriler()
    {
        $data = array();
        $lang = $this->settings->lang('lang');


        if(is_array($lang))
            foreach ($lang as $lang=>$name):

                $urunler = $this->sorgu("select * from tumkategori");
                if(is_array($urunler))
                    foreach ($urunler as $item)
                    {
                        if($item['url_'.$lang]) $data[$lang][] = $this->pagelink[$lang][$item['tur']].'/'.$item['url_'.$lang];
                    }
            endforeach;

        return $data;


    }



    public function Haberler()
    {
        $data = array();
        $lang = $this->settings->lang('lang');

        if(is_array($lang))
            foreach ($lang as $lang=>$name):

                if($lang == "en")
                    $urunler = $this->sorgu("select * from haberler_lang");
                  else
                    $urunler = $this->sorgu("select * from haberler");

                if(is_array($urunler))
                    foreach ($urunler as $item)
                    {
                        if($item['url']) $data[$lang][] = (($lang == "tr") ? 'haber':'news').'/'.$item['url'];
                    }
            endforeach;
        return $data;
    }

    public function Faydali()
    {
        $data = array();
        $lang = $this->settings->lang('lang');

        if(is_array($lang))
            foreach ($lang as $lang=>$name):

                if($lang == "en")
                    $urunler = $this->sorgu("select * from faydali_lang");
                else
                    $urunler = $this->sorgu("select * from faydali");

                if(is_array($urunler))
                    foreach ($urunler as $item)
                    {
                        if($item['url']) $data[$lang][] = (($lang == "tr") ? 'faydalibilgiler':'usefulinformation').'/'.$item['url'];
                    }
            endforeach;
        return $data;
    }

    public function Bolgeler()
    {
        $data = array();
        $lang = $this->settings->lang('lang');

        if(is_array($lang))
            foreach ($lang as $lang=>$name):

                if($lang == "en")
                    $urunler = $this->sorgu("select * from bolge_lang");
                else
                    $urunler = $this->sorgu("select * from bolge");

                if(is_array($urunler))
                    foreach ($urunler as $item)
                    {
                        if($item['url']) $data[$lang][] = (($lang == "tr") ? 'referanslar':'references').'/'.$item['url'];
                    }
            endforeach;
        return $data;
    }

    public function Referanslar()
    {
        $data = array();
        $lang = $this->settings->lang('lang');

        if(is_array($lang))
            foreach ($lang as $lang=>$name):

                if($lang == "en")
                    $urunler = $this->sorgu("select *,(select url from bolge_lang where master_id=referanslar.bolge limit 1) as refurl,
                    (select COUNT(id) from dosyalar where type=3 and kid=referanslar.id) as dosyasayisi from referanslar");
                else
                    $urunler = $this->sorgu("select *,(select url from bolge where id=referanslar.bolge limit 1) as refurl,
                     (select COUNT(id) from dosyalar where type=3 and kid=referanslar.id) as dosyasayisi from referanslar");

                if(is_array($urunler))
                    foreach ($urunler as $item)
                    {

                        if($item['url'] and $item['dosyasayisi']>0) $data[$lang][] = (($lang == "tr") ? 'referanslar':'references').'/'.$item['refurl'].'/'.$item['url'];
                    }
            endforeach;
        return $data;
    }


    public function Etiketler()
    {
        $data = array();
        $lang = $this->settings->lang('lang');

        if(is_array($lang))
            foreach ($lang as $lang=>$name):
                 $urunler = $this->sorgu("select * from etiketler where lang='$lang'");

                if(is_array($urunler))
                    foreach ($urunler as $item)
                    {
                        if($item['url']) $data[$lang][] = 'tag/'.$item['url'];
                    }
            endforeach;
        return $data;
    }

}