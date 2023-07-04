<?php
/**
 * Created by PhpStorm.
 * User: Abdulkadir
 * Date: 23.10.2016
 * Time: 01:12
 */

return [

    /*

|--------------------------------------------------------------------------

|  İzin Verilen Resim Tipleri

|--------------------------------------------------------------------------

|

*/


    'allow_image_type'  => array('image/jpg','image/jpeg','image/png','image/gif'),


    /*

   |--------------------------------------------------------------------------

   |  İzin Verilen Dosya Tipleri

   |--------------------------------------------------------------------------

   |

   */

    'allow_file_type' => array('doc','docx','xls','xlsx','zip','rar','dot','rtf','text','txt','jpeg','jpg','png'),


    /*

   |--------------------------------------------------------------------------

   |  Dosya İkonları

   |--------------------------------------------------------------------------

   |

   */


    'file_type_icon' => array('doc'=>'fa fa-file-word-o',
        'docx'=>'fa fa-file-word-o',
        'dot'=>'fa fa-file-word-o',
        'rtf'=>'fa fa-file-word-o',
        'text'=>'fa fa-file-word-o',
        'txt'=>'fa fa-file-word-o',
        'xls'=>'fa fa-file-excel-o',
        'xlsx'=>'fa fa-file-excel-o',
        'zip'=>'fa fa-file-archive-o',
        'rar'=>'fa fa-file-archive-o',
        'jpeg' => 'fa fa-file-image-o',
        'jpg' => 'fa fa-file-image-o',
        'png' => 'fa fa-file-image-o',
    ),




];