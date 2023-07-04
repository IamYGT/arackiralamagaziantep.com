<?php
/**
 * Created by PhpStorm.
 * User: Abdulkadir
 * Date: 23.10.2016
 * Time: 01:12
 */
$_URL =  explode('.',$_SERVER["HTTP_HOST"]);
$_URL  = $_URL[count($_URL)-1];

return [

    /*

    |--------------------------------------------------------------------------

    | Site URL si

    |--------------------------------------------------------------------------

    |

    */

    'url' =>  (($_SERVER['SERVER_PORT'] =="443") ? 'https://':'http://').$_SERVER["HTTP_HOST"].(($_URL=="dev") ? '/':str_replace('/adminpanel','',str_replace('index.php','',$_SERVER["PHP_SELF"]))),

    /*

|--------------------------------------------------------------------------

|  Site İzleme İsmi

|--------------------------------------------------------------------------

|

*/

   'adminAnalyticsCode' => 'UA-87157922-1',
    /*

|--------------------------------------------------------------------------

|  Varsayılan tema

|--------------------------------------------------------------------------

|

*/

    'version' => '1.5.6',


    'siteTemasi' => 'default',




    /*

  |--------------------------------------------------------------------------

  |Yapım Aşamasında  True/False

  |--------------------------------------------------------------------------

  |

  */


    'yapimAsamasinda' => false,
    /*

     |--------------------------------------------------------------------------

     | Şifreleme Key

     |--------------------------------------------------------------------------

     |

     */


    'passkey' => 'panelkey00xx',



    /*

 |--------------------------------------------------------------------------

 | default database

 |--------------------------------------------------------------------------

 |

 */


    'defaultDb' => 'pdo',

   /*

 |--------------------------------------------------------------------------

 | veri limitleri

 |--------------------------------------------------------------------------

 |

 */



    'referansLimit' => 50,

    'veriLimit' => 30,



    /*

   |--------------------------------------------------------------------------

   | Panel Klasör İsmi

   |--------------------------------------------------------------------------

   |

   */



    'adminfolder' => 'adminpanel',

    /*

     |--------------------------------------------------------------------------

     | Admin Panel Seo  true/false

     |--------------------------------------------------------------------------

     |

     */



    'adminSeo' => false,

    /*

 |--------------------------------------------------------------------------

 | Resim  Klasörü

 |--------------------------------------------------------------------------

 |

 */


    'folder'=>'upload/',

    /*

     |--------------------------------------------------------------------------

     | Yönetim Paneli Teması
     |--------------------------------------------------------------------------

     |

     */

    'adminTheme' => 'admin',



    'cdnURL' => 'https://cdn.vemedya.com/',


    'urlUzanti' => '.html'


];