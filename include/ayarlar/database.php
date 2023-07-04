<?php

return [
    /*
     |--------------------------------------------------------------------------
    |  Veritabanı Baglantı  Bilgileri
	Örn:
	'pdo' =>
     array(
         'local'=>array(
             'host' => 'localhost',
             'dbname' => '',
             'user' =>'',
             'password' => '',
             'charset' => 'utf8',
             'driver' => 'pdo_mysql',
             'debug' => true
         ),
         'host' =>
             array(
                 'host' => 'localhost',
                 'dbname' => '',
                 'user' =>'',
                 'password' => '',
                 'charset' => 'utf8',
                 'driver' => 'pdo_mysql',
                 'debug' => false
             )
     ),
    |--------------------------------------------------------------------------
    |
    */
    //
    'pdo' => [
        'local'=>array(
            'host' => 'localhost',
            'dbname' => 'rent',
            'user' =>'root',
            'password' => 'root',
            'charset' => 'utf8',
            'driver' => 'pdo_mysql',
            'debug' => true
        ),

        'host' =>
            [
                'host' => 'localhost',
                'dbname' => 'db_kiralama',
                'user' =>  'db_kiralama',
                'password' => '#P18ky4b',
                'charset' => 'utf8',
                'driver' => 'pdo_mysql',
                'debug' => false
            ]
    ]
];
