<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 20.03.2017
 * Time: 15:04
 */





$yazilar  = $this->sorgu("select * from yazilar ");
$x=0;
$y = 0;
if(is_array($yazilar))
    foreach ($yazilar as $item):

        $resim  = explode(',',$item['resim_']);
        $id = $item['id'];


        if(count($resim)>0)
        {
            $kapakresim = $resim[0];
            unset($resim[0]);
            if($kapakresim) {
                //$this->update('yazilar',array('resimyeni'=>$kapakresim),$id);
                if($kapakresim and file_exists('metalsunucu/upload/'.$kapakresim)) {
                    if (rename('metalsunucu/upload/' . $kapakresim, 'upload/' . $kapakresim)) $y++;;
                }

                }

            if(count($resim)>0)
                foreach ($resim as $res)
                {
                    /*
                    $this->insert('dosyalar',array(
                        'tur' => 1,
                        'type' => 1,
                        'dosya' => $res,
                        'kid' => $id

                    ));
                    */

                    if($res and file_exists('metalsunucu/upload/'.$res)) {
                        if (rename('metalsunucu/upload/' . $res, 'upload/sayfa/' . $res)) $x++;;
                    }



                }



        }



        endforeach;



echo $x.'Ek Resim Taşındı ve '.$y.' Ana Resim Taşındı';

exit();
$projeler = $this->sorgu("select * from referanslar ");
$x=0;
if(is_array($projeler))
    foreach ($projeler as $item):

        if($item['logo'] and file_exists('metalsunucu/upload/'.$item['logo'])) {
            if (rename('metalsunucu/upload/' . $item['logo'], 'upload/proje/' . $item['logo'])) $x++;
        }
        endforeach;




            echo $x.' Resim Taşındı';
exit();
 $projeler = $this->sorgu("select * from projeler ");
$x=0;
  if(is_array($projeler))
      foreach ($projeler as $proje):

          $galeriid = $proje['galeri'];
  $sira = 0;

        $galeri = $this->sorgu("select * from fotolar where album_id = '$galeriid' order by sira");

        if(is_array($galeri))
            foreach ($galeri as $item):
                $sira++;

                $this->insert('dosyalar',array(
                    'type' => 5,
                    'kid' => $proje['id'],
                    'dosya' => $item['resim'],
                    'sira' => $sira,
                    'tur' => 1,


                ));

          /*
                if($item['resim'] and file_exists('metalsunucu/upload/'.$item['resim'])) {
              if (rename('metalsunucu/upload/' . $item['resim'], 'upload/proje/' . $item['resim'])) $x++;

          }
          */
          endforeach;

          endforeach;


echo $x.' Resim Taşındı';


exit();
$referanslar = $this->sorgu("select * from projeler order by sira");

 if(is_array($referanslar))
     foreach ($referanslar as $item)
     {
         $this->update('dosyalar',array('kid'=>$item['id']),$item['album_id']);
     }





exit();
  $xi =0 ;
      $resimler = $this->sorgu('select * from dosyalar where type=3');

      if(is_array($resimler))
      {
          foreach ($resimler as $item)
          {
              for($i=1;$i<2;$i++):
                  if(isset($item['dosya'])) {

                      $resim[$i] = $item['dosya'];

                      if($resim[$i] and file_exists('upload/'.$resim[$i]))
                      {
                          if(rename('upload/'.$resim[$i],'upload/referans/'.$resim[$i]))
                      {
                         //  $this->insert('dosyalar',array('dosya'=>$resim[$i],'type'=>3,'kid'=>$item['album_id'],'sira'=>0));
                          $xi++;
                      }

                      }

                      /*
                      if($item['komp'] and file_exists('upload/DosyaYok/'.$item['komp']))
                      {
                          if(rename('upload/DosyaYok/'.$item['komp'],'upload/'.$item['komp']))
                          {
                              // $this->insert('dosyalar',array('dosya'=>$resim[$i],'type'=>2,'kid'=>$item['id'],'sira'=>0));
                              $xi++;
                          }

                      }
                      */

                  }
              endfor;
          }
      }

      echo $xi. ' Resim Taşındı';