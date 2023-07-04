<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 29.04.2017
 * Time: 19:36
 */




$this->sabitlinkler = array(
    'tr' => array(
        'index','urunler','iletisim','belgelerimiz','referanslar','kurumsal','bahce-mobilyalari','evgerecleri','stadyum-koltuklari',
        'stadyum_koltugu_kalite_test_filmi','tribun_koltugu_teknik_ozellikleri','ekatalog','faydalibilgiler','urunlerimiz','haberler'
    ),
    'en' => array(   'index','products','contact','certificates','references','about-us','garden-furnitures','households','stadium-seats',
        'stadium_seat_quality_test_movie','tribune_seat_technical_features','ecatalogue','usefulinformation','products','news')

);


echo $this->SitemapCreate('sitemap.xml');



?>