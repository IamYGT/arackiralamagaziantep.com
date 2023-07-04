<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 21.04.2017
 * Time: 19:16
 */


exit();
$kategori = $this->sorgu('select * from referans');

if(is_array($kategori))
    foreach($kategori as $item):

        $this->update('referans',array('url'=>$this->permalink($item['isim'])),$item['id']);


    endforeach;





exit();

$x= 0 ;
$kategori = $this->sorgu('select * from projeler');

if(is_array($kategori))
    foreach($kategori as $item):

        $this->update('projeler',array('url'=>str_replace('--','-',$this->permalink($item['baslik']))),$item['id']);
        $x++;

 endforeach;


echo $x.' Proje eklendir';
exit();
  $kategori = $this->sorgu('select * from kategoriler');

  if(is_array($kategori))
      foreach($kategori as $item):

          $this->update('urunler',array('tur'=>$item['tur']),array('kid'=>$item['id']));


endforeach;


$kategori2 = $this->sorgu('select * from mkategori');

if(is_array($kategori2))
    foreach($kategori2 as $item):
        $this->update('murunler',array('tur'=>3),array('kid'=>$item['id']));
   endforeach;






exit();
$urunler = $this->sorgu('select * from murunler_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $etiketid = array();
        $urunid = $item['master_id'];

        if($item['etiket'])
        {
            $tagtr = explode(',',$item['etiket']);



            if(is_array($tagtr))
                foreach ($tagtr as $tag)
                {
                    if($tag) {
                        if(count($this->sorgu("select id from etiketler where baslik = '$tag'"))==0)
                        {
                            $this->insert('etiketler',array('baslik'=>$tag,'url'=>$this->permalink($tag),'lang'=>'en'));
                            $etiketid[] = $this->lastid();
                            $x++;
                        }
                        else
                        {
                            $tags =   $this->teksorgu("select id from etiketler where baslik = '$tag' limit 1");
                            $etiketid[] = $tags['id'];
                        }


                    }

                }




        }

        $this->update('murunler_lang',array('tags'=>json_encode($etiketid)),array('master_id'=>$urunid));

    }
echo $x.' Etiket Eklendi<br>';


$urunler = $this->sorgu('select * from urunler_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $etiketid = array();
        $urunid = $item['master_id'];

        if($item['etiket'])
        {
            $tagtr = explode(',',$item['etiket']);



            if(is_array($tagtr))
                foreach ($tagtr as $tag)
                {
                    if($tag) {
                        if(count($this->sorgu("select id from etiketler where baslik = '$tag'"))==0)
                        {
                            $this->insert('etiketler',array('baslik'=>$tag,'url'=>$this->permalink($tag),'lang'=>'en'));
                            $etiketid[] = $this->lastid();
                            $x++;
                        }
                        else
                        {
                            $tags =   $this->teksorgu("select id from etiketler where baslik = '$tag' limit 1");
                            $etiketid[] = $tags['id'];
                        }


                    }

                }




        }

        $this->update('urunler_lang',array('tags'=>json_encode($etiketid)),array('master_id'=>$urunid));

    }

echo $x.' Etiket Eklendi<br>';












$urunler = $this->sorgu('select * from urunler');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $etiketid = array();
        $urunid = $item['id'];

        if($item['etiket'])
        {
            $tagtr = explode(',',$item['etiket']);



            if(is_array($tagtr))
                foreach ($tagtr as $tag)
                {
                    if($tag) {
                        if(count($this->sorgu("select id from etiketler where baslik = '$tag'"))==0)
                        {
                            $this->insert('etiketler',array('baslik'=>$tag,'url'=>$this->permalink($tag),'lang'=>'tr'));
                            $etiketid[] = $this->lastid();
                            $x++;
                        }
                        else
                        {
                          $tags =   $this->teksorgu("select id from etiketler where baslik = '$tag' limit 1");
                          $etiketid[] = $tags['id'];
                        }


                    }

                }




        }

           $this->update('urunler',array('tags'=>json_encode($etiketid)),$urunid);

    }

echo $x.' Etiket Eklendi<br>';


$urunler = $this->sorgu('select * from murunler');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $etiketid = array();
        $urunid = $item['id'];

        if($item['etiket'])
        {
            $tagtr = explode(',',$item['etiket']);



            if(is_array($tagtr))
                foreach ($tagtr as $tag)
                {
                    if($tag) {
                        if(count($this->sorgu("select id from etiketler where baslik = '$tag'"))==0)
                        {
                            $this->insert('etiketler',array('baslik'=>$tag,'url'=>$this->permalink($tag),'lang'=>'tr'));
                            $etiketid[] = $this->lastid();
                            $x++;
                        }
                        else
                        {
                            $tags =   $this->teksorgu("select id from etiketler where baslik = '$tag' limit 1");
                            $etiketid[] = $tags['id'];
                        }


                    }

                }




        }

        $this->update('murunler',array('tags'=>json_encode($etiketid)),$urunid);

    }

echo $x.' Etiket Eklendi';





exit();

$urunler = $this->sorgu('select * from faydali_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {

        if($item['baslik'])
        {

            $this->update('faydali_lang',array('url'=>$this->permalink($item['baslik'])),array('lang_id'=>$item['lang_id']));
            $x++;

        }



    }

echo $x.' faydali[lang] Eklendi<br>';

$urunler = $this->sorgu('select * from faydali');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {

        if($item['baslik'])
        {

            $this->update('faydali',array('url'=>$this->permalink($item['baslik'])),$item['id']);
            $x++;

        }



    }

echo $x.' faydali Eklendi<br>';

exit();

$urunler = $this->sorgu('select * from haberler_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {

        if($item['baslik'])
        {

            $this->update('haberler_lang',array('url'=>$this->permalink($item['baslik'])),array('lang_id'=>$item['lang_id']));
            $x++;

        }



    }

echo $x.' Haber[lang] Eklendi<br>';

exit();


$urunler = $this->sorgu('select * from haberler');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {

        if($item['baslik'])
        {

            $this->update('haberler',array('url'=>$this->permalink($item['baslik'])),$item['id']);
            $x++;

        }



    }

echo $x.' Haber Eklendi<br>';




$urunler = $this->sorgu('select * from referanslar');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {

        if($item['firma'])
        {

            $this->update('referanslar',array('url'=>$this->permalink($item['firma'])),$item['id']);
            $x++;

        }



    }

echo $x.' referans Eklendi<br>';
exit();

$urunler = $this->sorgu('select * from bolge_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {

        if($item['ad'])
        {

            $this->update('bolge_lang',array('url'=>$this->permalink($item['ad'])),array('lang_id'=>$item['lang_id']));
            $x++;

        }



    }

echo $x.' Bölge Eklendi<br>';


$urunler = $this->sorgu('select * from bolge');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {

        if($item['ad'])
        {

         $this->update('bolge',array('url'=>$this->permalink($item['ad'])),$item['id']);
         $x++;

        }



    }

echo $x.' Bölge Eklendi';





exit();



$urunler = $this->sorgu('select * from dosyalar');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        if($item['renkadi_tr']){
        $this->update('dosyalar',array('url_tr'=>$this->permalink($item['renkadi_tr']),'url_en'=>$this->permalink($item['renkadi_en'])),$item['id']);
        $x++;
        }
    }

echo $x.' Dosya URL Değişti<br>';



exit();

$urunler = $this->sorgu('select * from kategoriler');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $this->update('kategoriler',array('url'=>$this->permalink($item['kategori'])),$item['id']);
        $x++;
    }

echo $x.' Kategori URL Değişti<br>';



$urunler = $this->sorgu('select * from kategoriler_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $this->update('kategoriler_lang',array('url'=>$this->permalink($item['kategori'])),array('lang_id'=>$item['lang_id']));
        $x++;
    }

echo $x.' Kategori[en] URL Değişti<br>';

$urunler = $this->sorgu('select * from mkategori');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $this->update('mkategori',array('url'=>$this->permalink($item['baslik'])),$item['id']);
        $x++;
    }

echo $x.'MP   Kategori URL Değişti<br>';

$urunler = $this->sorgu('select * from mkategori_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $this->update('mkategori_lang',array('url'=>$this->permalink($item['baslik'])),array('lang_id'=>$item['lang_id']));
        $x++;
    }

echo $x.' MP Kategori[en] URL Değişti<br>';




exit();

    $urunler = $this->sorgu('select * from urunler');
   $x=0;
    if(is_array($urunler))
        foreach ($urunler as $item)
        {
           $this->update('urunler',array('url'=>$this->permalink($item['baslik'])),$item['id']);
             $x++;
        }

        echo $x.' Ürün URL Değişti<br>';



$urunler = $this->sorgu('select * from urunler_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $this->update('urunler_lang',array('url'=>$this->permalink($item['baslik'])),array('lang_id'=>$item['lang_id']));
        $x++;
    }

echo $x.' Ürün[en] URL Değişti<br>';

$urunler = $this->sorgu('select * from murunler');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $this->update('murunler',array('url'=>$this->permalink($item['baslik'])),$item['id']);
        $x++;
    }

echo $x.'MP   Ürün URL Değişti<br>';

$urunler = $this->sorgu('select * from murunler_lang');
$x=0;
if(is_array($urunler))
    foreach ($urunler as $item)
    {
        $this->update('murunler_lang',array('url'=>$this->permalink($item['baslik'])),array('lang_id'=>$item['lang_id']));
        $x++;
    }

echo $x.' MP Ürün[en] URL Değişti<br>';
