<?

class FrontClass extends Mail
{
    public $settings;
    public $pageid;
    public $data;
    public $kid;
    public $sayfaBaslik;

    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->settings = $settings;

    }


    public function ayarlar($data)
    {
        if ($data):
            $d = $this->tekSorgu("select * from ayarlar where name='$data' ");
            return ($d['value']) ? $d['value'] : null;
        endif;

    }

    public function sayfaBaslik()
    {
        return $this->sayfaBaslik;
    }



    public function watermark($islem = 0, $klasor, $dosya, $logo){
        $par = explode(".", $dosya);
        $uzanti = $par[count($par) - 1];

        if ($islem == 0){
            switch ($uzanti) {
                case "jpg":
                case "jpeg":
                    $mevcut_resim = imagecreatefromjpeg($klasor.$dosya);
                break;

                case "png":
                    $mevcut_resim = imagecreatefrompng($klasor.$dosya);
                break;

                default:
                    $mevcut_resim = imagecreatefromjpeg($klasor.$dosya);
                break;
            }

            $eklenen_resim = imagecreatefrompng($logo);

            list($genislik, $yukseklik) = getimagesize($logo);

            $sag = (imagesx($mevcut_resim) - $genislik) / 2;
            $sol = (imagesy($mevcut_resim) - $yukseklik) / 2;


            imagealphablending($mevcut_resim, true);
            imagealphablending($eklenen_resim, true);

            imagecopy($mevcut_resim, $eklenen_resim, $sag, $sol, 0, 0, $genislik, $yukseklik);


            switch ($uzanti) {
                case "jpg":
                case "jpeg":
                    imagejpeg($mevcut_resim, $klasor.$dosya, 100);
                break;

                case "png":
                    imagepng($mevcut_resim, $klasor.$dosya, 100);
                break;

                default:
                    imagejpeg($mevcut_resim, $klasor.$dosya, 100);
                break;
            }

            imagedestroy($mevcut_resim);

            return true;
        }
        else {
            return false;
        }

    }


    public function getID($item, $lang)
    {
        return (($lang == 'tr') ? $item['id'] : $item['masterid']);
    }

    public function getKategoriBaslik($id, $lang)
    {
        $kat = $this->teksorgu("select * from tumkategori where id='$id'");
        if ($kat['ustu'] == 0)
            return (($kat['kategori' . $lang]) ? $kat['kategori' . $lang] : $kat['kategori']);
        else
            return $this->getKategoriBaslik($kat['ustu'], $lang);
    }

    public function select($table, $row, $selected = '')
    {

        $text = '';

        if ($row and $table):
            $select = $this->sorgu("select $row from $table GROUP  by $row order by $row");
            if (is_array($select))
                foreach ($select as $item):
                    if ($item[$row]) $text .= '<option value="' . $item[$row] . '" ' . (($selected and ($selected == $item[$row])) ? 'selected="selected"' : null) . '>' . $item[$row] . '</option>';
                endforeach;
        endif;
        return $text;

    }

    public function getList($table, $param = array(), $lang = 'tr', $order = '')
    {
        $osql = '';
        $sql = 'SELECT * FROM ' . $table . ' ';


        if (is_array($param) and count($param) > 0):
            $sql .= ' where ';
            $x = 0;
            foreach ($param as $name => $item):
                $x++;
                $sql .= $item . '=' . $item . ((count($param) < $param) ? ',' : '');
            endforeach;

        endif;
        if ($order) $sql .= ' ' . $order;
        $langlist = $this->settings->lang('lang');
        if (is_array($langlist))
            foreach ($langlist as $name => $item):


            endforeach;


    }


    public function submenu($ustu, $url)
    {

        $text = '';
        $ulist = $this->sorgu("select * from sayfakategori where ustu='$ustu' order by sira");

        if (is_array($ulist))
            foreach ($ulist as $s):
                $sid = $s['id'];
                $urunsay = $this->sorgu("select * from yazilar where ustu='$sid'");

                $text .= ' <li class="menu-item"><a href="' . strtolower($this->per($s['kategori'])) . ',' . $url . ',' . $s['id'] . '.html">' . $s['kategori'] . '</a>';
                if ($urunsay and count($urunsay) > 0):
                    $text .= '  <ul class="sub-menu">' . $this->submenu($sid) . '</ul>';
                endif;
                $text .= '</li>';

            endforeach;
        return $text;
    }


    public function BaseURL($url = null, $lang = 'tr', $uzanti = 0)
    {
        return $this->settings->config('url') . (($lang != "tr") ? $lang . '/' : null) . (($url) ? $url : null) . (($uzanti == 1) ? $this->settings->config('urlUzanti') : null);
    }


    public function teksayfa($id = null, $kid = 10)
    {
        if ($id > 0) $yazi = $this->tekSorgu("select * from yazilar where id='$id'");
        else $yazi = $this->tekSorgu("select * from yazilar where kid='$kid' order by sira");
        return $yazi;
    }

    public function tekhaber($id = null)
    {
        if ($id > 0) $yazi = $this->tekSorgu("select * from haberler where id='$id'");
        else $yazi = $this->tekSorgu("select * from haberler order by sira");
        return $yazi;
    }

    public function resimGet($resim)
    {
        if (self::isJSON($resim)):
            $files = json_decode($resim, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            return (isset($files['image']) and is_array($files)) ? (($files['crop'] == "true") ? "crop_" . $files['image'] : $files['image']) : null;
        else:
            return $resim;
        endif;
    }

    public function fileGet($file)
    {
        if (self::isJSON($file)):
            $files = json_decode($file, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            return $files;
        else:
            return $file;
        endif;
    }

    public function jsonGet($data)
    {

        if (self::isJSON($data)):
            $datas = json_decode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            return $datas;
        else:
            return $data;
        endif;


    }

    public function ozellikGet($id)
    {
        $a = array();
        $ozellik = $this->tekSorgu("select * from islamitatil where id='$id'");

        if (!is_null($ozellik['ozellik'])):
            if (self::isJSON($ozellik['ozellik'])):
                $oz = json_decode($ozellik['ozellik'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            else:
                $oz = $ozellik['ozellik'];
            endif;

            if (is_array($oz) and !is_null($oz))
                foreach ($oz as $item):

                    if (is_numeric($item)):
                        $b = $this->tekSorgu("select * from ozellik where id='$item'");

                        $a[] = $b['baslik'];

                    endif;

                endforeach;

        endif;

        return $a;

    }

    public function _include($file, $data = array(), $theme = null)
    {
        $sub = (file_exists('view')) ? 'view/' : null;

        if ($file . '.php' and file_exists($sub . $theme . $file . '.php')):
            if ($data) extract($data);
            ob_start();
            include($sub . $theme . $file . '.php');
            return ob_get_clean();
        else:
            $x = 0;
            if (isset($data['LangLink']))
                foreach ($data['LangLink']->header() as $key => $value):
                    if ($data['page'] == $this->permalink($value)):
                        if ($key and file_exists($sub . $theme . 'sayfa/' . $key . '.php')):
                            return $this->_include($theme . 'sayfa/' . $key, $data);
                            $x++;
                        endif;
                    endif;
                endforeach;
            //  if($x==0 and file_exists($sub.'error/404.php'))
            //return $this->_include('error/404',$data);

        endif;

    }


    public function dataMoveURL($data)
    {
        $url = str_replace("/", "", $_SERVER["REQUEST_URI"]);
        $getURL = $this->tekSorgu("select * from seo_url where url='{$url}'");


        if ($getURL) {
            if ($getURL['type'] == "etiket") {
                $link = $this->BaseURL('tag', $data['lang'], 1) . '?' . (($data['lang'] == 'tr') ? 'etiket' : 'tag') . '=' . $getURL['value'];
                $this->MoveNewURL($link);

                return true;

            } elseif ($getURL['type'] == "url") {
                $link = $this->BaseURL($getURL['value'], 'tr', 1);
                $this->MoveNewURL($link);

                return true;

            } elseif ($getURL['type'] == "faydali") {
                $id = $getURL['value'];
                if ($data['lang'] == "en")
                    $sorgu = $this->teksorgu("select * from faydali_lang where master_id = '{$id}'");
                else
                    $sorgu = $this->teksorgu("select * from faydali where id = '{$id}'");

                $link = (($data['lang'] == 'tr') ? 'faydalibilgiler' : 'usefulinformation') . '/' . $sorgu['url'];
                if ($sorgu)
                    $this->MoveNewURL($this->BaseURL($link, $data['lang'], 1));
                else
                    $this->MoveNewURL($this->BaseURL('index', $data['lang'], 1));

                return true;

            } elseif ($getURL['type'] == "haber") {
                $id = $getURL['value'];
                if ($data['lang'] == "en")
                    $sorgu = $this->teksorgu("select * from haberler_lang where master_id = '{$id}'");
                else
                    $sorgu = $this->teksorgu("select * from haberler where id = '{$id}'");

                $link = (($data['lang'] == 'tr') ? 'haber' : 'news') . '/' . $sorgu['url'];


                if ($sorgu)
                    $this->MoveNewURL($this->BaseURL($link, $data['lang'], 1));
                else
                    $this->MoveNewURL($this->BaseURL('index', $data['lang'], 1));


                return true;
            } elseif ($getURL['type'] == "urun") {
                $id = $getURL['value'];
                $urllag = 'url_' . $data['lang'];
                $pagelink = array('en' => array(1 => 'garden-furnitures', 2 => 'stadium-seats', 3 => 'households'), 'tr' => array(1 => 'bahce-mobilyalari', 2 => 'stadyum-koltuklari', 3 => 'evgerecleri'));
                $sorgu = $this->teksorgu("SELECT *,(select $urllag from tumkategori where id= tumurunler.urunkid limit 1) as katurl FROM tumurunler WHERE urunid = '{$id}' limit 1");
                $link = $pagelink[$data['lang']][$sorgu['tur']] . '/' . $sorgu['katurl'] . '/' . $sorgu['url_' . $data['lang']];

                if ($sorgu)
                    $this->MoveNewURL($this->BaseURL($link, $data['lang'], 1));
                else
                    $this->MoveNewURL($this->BaseURL('index', $data['lang'], 1));

                return true;
            } elseif ($getURL['type'] == 'kategori') {

                $id = $getURL['value'];
                $sorgu = $this->teksorgu("SELECT * FROM tumkategori WHERE id = '{$id}' limit 1");
                $link = $sorgu['type_' . $data['lang']] . '/' . $sorgu['url_' . $data['lang']];
                if ($sorgu)
                    $this->MoveNewURL($this->BaseURL($link, $data['lang'], 1));
                else
                    $this->MoveNewURL($this->BaseURL('index', $data['lang'], 1));

                return true;
            } else {
                return false;
            }


        }
    }

    public function MoveURL()
    {
        $lang = Request::GET('lang');
        $ptype = Request::GET('ptype');
        $id = Request::GET('id');
        $kid = Request::GET('kid');
        $tip = Request::GET('tip');


        if ($ptype == 'urun') {

            if ($tip == 2 or $tip == 1)
                $nid = ($id + 1000);
            else
                $nid = ($id + 2000);


            $pagelink = array('en' => array(1 => 'garden-furnitures', 2 => 'stadium-seats', 3 => 'households'), 'tr' => array(1 => 'bahce-mobilyalari', 2 => 'stadyum-koltuklari', 3 => 'evgerecleri'));
            $sorgu = $this->teksorgu("SELECT *,(select url_$lang from tumkategori where id= tumurunler.urunkid limit 1) as katurl FROM tumurunler  WHERE urunid = '{$nid}' limit 1");
            if ($tip == 2)
                $link = $pagelink[$lang][$sorgu['tur']] . '/' . $sorgu['url_' . $lang];
            else
                $link = $pagelink[$lang][$sorgu['tur']] . '/' . $sorgu['katurl'] . '/' . $sorgu['url_' . $lang];

            if ($sorgu)
                $this->MoveNewURL($this->BaseURL($link, $lang, 1));
            else
                $this->MoveNewURL($this->BaseURL('index', $lang, 1));

        } else if ($ptype == 'kategori') {

            $tip = Request::GET('tip');

            if ($kid < 100) {
                if ($tip == 3 or $tip == 2) $kid = ($kid + 100);
                if ($tip == 1) $kid = ($kid + 200);

            }

            $sorgu = $this->teksorgu("SELECT * FROM tumkategori WHERE id = '{$kid}' and tur='{$tip}' limit 1");
            $link = $sorgu['type_' . $lang] . '/' . $sorgu['url_' . $lang];

            if ($sorgu)
                $this->MoveNewURL($this->BaseURL($link, $lang, 1));
            else
                $this->MoveNewURL($this->BaseURL('index', $lang, 1));

        } elseif ($ptype == "referans") {

            $referans = $this->teksorgu("SELECT * FROM referanslar where id = '{$id}'");
            $bolgeid = $referans['bolge'];
            $sorgu = $this->teksorgu("SELECT BK.id as id, BK.ad AS baslik_tr, BL.ad AS baslik_en,BK.url as url_tr,BL.url as url_en FROM bolge BK, bolge_lang BL WHERE BK.id = BL.master_id and BK.id='{$bolgeid}' limit 1");
            $link = (($lang == 'tr') ? 'referanslar' : 'references') . '/' . $sorgu['url_' . $lang] . '/' . $referans['url'];
            if ($sorgu)
                $this->MoveNewURL($this->BaseURL($link, $lang, 1));
            else
                $this->MoveNewURL($this->BaseURL('index', $lang, 1));
        } elseif ($ptype == "bolge") {
            $sorgu = $this->teksorgu("SELECT BK.id as id, BK.ad AS baslik_tr, BL.ad AS baslik_en,BK.url as url_tr,BL.url as url_en FROM bolge BK, bolge_lang BL WHERE BK.id = BL.master_id and BK.id='{$id}' limit 1");
            $link = (($lang == 'tr') ? 'referanslar' : 'references') . '/' . $sorgu['url_' . $lang];
            if ($sorgu)
                $this->MoveNewURL($this->BaseURL($link, $lang, 1));
            else
                $this->MoveNewURL($this->BaseURL('index', $lang, 1));
        } elseif ($ptype == "faydali") {
            if ($lang == "en")
                $sorgu = $this->teksorgu("select * from faydali_lang where master_id = '{$id}'");
            else
                $sorgu = $this->teksorgu("select * from faydali where id = '{$id}'");

            $link = (($lang == 'tr') ? 'faydalibilgiler' : 'usefulinformation') . '/' . $sorgu['url'];
            if ($sorgu)
                $this->MoveNewURL($this->BaseURL($link, $lang, 1));
            else
                $this->MoveNewURL($this->BaseURL('index', $lang, 1));
        } elseif ($ptype == "haber") {
            //  $sorgu = $this->teksorgu("SELECT HK.id as id, HK.url as url_tr,HL.url as url_en FROM haberler HK, haberler_lang HL WHERE HK.id = HL.master_id AND HK.id = '$id' GROUP  by HK.id limit 1");

            if ($lang == "tr") {
                $sorgu = $this->teksorgu("SELECT * FROM haberler HK where  HK.id = '$id' GROUP  by HK.id limit 1");
            } else {
                $sorgu = $this->teksorgu("SELECT * FROM haberler_lang HK where  HK.master_id = '$id'  limit 1");
            }


            $link = (($lang == 'tr') ? 'haber' : 'news') . '/' . $sorgu['url'];
            if ($sorgu)
                $this->MoveNewURL($this->BaseURL($link, $lang, 1));
            else
                $this->MoveNewURL($this->BaseURL('index', $lang, 1));
        }


        // $url = $this->BaseURL();


    }

    public function MoveNewURL($url)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $url");
    }

    public function RedirectURL($url)
    {
        header('location:' . $url);
    }

    public function aktifbul($resimler)
    {
        if (is_array($resimler))
            foreach ($resimler as $item):

                if ($item['aktif']) {
                    return $item;
                    break;
                }

            endforeach;

    }

    public function _ayarlar()
    {
        $_SESSION['ayarlar'] = null;
        $_SESSION['ayarlar'] = array();
        $settings = $this->sorgu("select * from ayarlar");
        if (count($settings) > 0) {
            foreach ($settings as $name => $value):
                $_SESSION['ayarlar'][$value["name"]] = $value["value"];

            endforeach;
        }

    }

    public function aylar($ay, $tur = 1)
    {
        switch ($tur):
            case 1 :
                $aylar = array('Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara');
                break;
            case 2 :
                $aylar = array('OCA', 'ŞUB', 'MAR', 'NİS', 'MAY', 'HAZ', 'TEM', 'AĞU', 'EYL', 'EKİ', 'KAS', 'ARA');
                break;
            case 3 :
                $aylar = array('Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');
                break;
            case 4 :
                $aylar = array('OCAK', 'ŞUBAT', 'MART', 'NİSAN', 'MAYIS', 'HAZİRAN', 'TEMMUZ', 'AĞUSTOS', 'EYLÜL', 'EKİM', 'KASIM', 'ARALIK');
                break;
        endswitch;
        if (is_numeric($ay)) return $aylar[$ay - 1];

    }

    public function gunler($ay)
    {
        $aylar = array('PAZAR', 'PAZARTESİ', 'SALI', 'ÇARŞAMBA', 'PERŞEMBE', 'CUMA', 'CUMARTESİ');

        if (is_numeric($ay)) return $aylar[$ay];

    }

    public function teltemiz($tel)
    {
        $find = array(" ", "(", ")", "+", "-", ";");
        $str = str_replace($find, "", $tel);
        return $str;
    }

    public static function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    protected function getProductTitle($data)
    {
        $urunurl = $data['urunurl'];
        $langurl = 'url_' . $data['lang'];
        $get = array();

        $item = $this->teksorgu("select * from tumurunler where $langurl = '{$urunurl}'");
        $basekat = $this->teksorgu("SELECT * FROM tumkategori WHERE id = {$item['urunkid']}");
        if ($_GET["lang"] == "tr"):
            $get['title'] = $item["baslik_tr"] . ' - ' . $basekat['baslik_tr'];
            $duzenli = str_replace('-', ' ', $basekat["type_tr"]);
            $ilkharf = ucwords($duzenli);
            $get['desc'] = $ilkharf . ' - ' . $basekat["baslik_tr"] . ' / ' . $item["baslik_tr"] . ' - ' . $item["kod"];
            $get['keyw'] = $item["etiket_tr"];
        else :
            $get['title'] = $item["baslik_en"] . ' - ' . $basekat['baslik_en'];
            $duzenli = str_replace('-', ' ', $basekat["type_en"]);
            $ilkharf = ucwords($duzenli);
            $get['desc'] = $ilkharf . ' - ' . $basekat["baslik_en"] . ' / ' . $item["baslik_en"] . ' - ' . $item["kod"];
            $get['keyw'] = $item["etiket_en"];
        endif;

        return $get;

    }

    public function pageListTitle($data)
    {


        $get = array();
        $katurl = $data['katurl'];
        $urunurl = $data['urunurl'];
        $langurl = 'url_' . $data['lang'];
        $get['site'] = 'murat-plastik.com | ';
        switch ($data['page']):

            default:
            case 'index':
                if ($data['lang'] == "en"):
                    $get['title'] = "murat-plastik.com | Furniture and Household Items ,Plastic Seats ";
                    $get['desc'] = "As Murat plastic firm, we furniture,household,produce plastic seats items products in Turkey and worldwide.";
                    $get['keyw'] = "Plastic garden furniture, plastic chair, Plastic stadium seat,Plastic rattan furniture, Plastic households, Plastic storage containers";
                else:
                    $get['title'] = "murat-plastik.com | Plastik sandalye, Plastik stadyum koltuk, Plastik bahçe mobilyası, Plastik ev eşyaları";
                    $get['desc'] = "Murat Plastik olarak plastik ev gereçleri, plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa)  ve stadyum koltuğu üretmekteyiz";
                    $get['keyw'] = "plastik koltuk, bahçe mobilyaları, plastik mutfak eşyaları, plastik masa ve sandalye,stadyum koltuğu, plastik ev gereçleri,  tribün koltuğu";
                endif;

                break;
            case "kurumsal":
                $get['title'] = $get['site'] . " Kurumsal ";
                $get['desc'] = "Murat Plastik olarak plastik ev gereçleri, plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa)  ve stadyum koltuğu üretmekteyiz";
                $get['keyw'] = "plastik koltuk, bahçe mobilyaları, plastik mutfak eşyaları, plastik masa ve sandalye,stadyum koltuğu, plastik ev gereçleri,  tribün koltuğu";
                break;
            case "about-us":
                $get['title'] = $get['site'] . " About Us ";
                $get['desc'] = "As Murat plastic firm, we furniture,household,produce plastic seats items products in Turkey and worldwide.";
                $get['keyw'] = "Plastic garden furniture, plastic chair, Plastic stadium seat,Plastic rattan furniture, Plastic households, Plastic storage containers";
                break;

            case "urunlerimiz":
                $get['title'] = $get['site'] . " Ürünlerimiz  ";
                $get['desc'] = "Murat Plastik olarak plastik ev gereçleri, plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa)  ve stadyum koltuğu üretmekteyiz";
                $get['keyw'] = "plastik koltuk, bahçe mobilyaları, plastik mutfak eşyaları, plastik masa ve sandalye,stadyum koltuğu, plastik ev gereçleri,  tribün koltuğu";
                break;
            case "products":
                $get['title'] = $get['site'] . " Products  ";
                $get['desc'] = "As Murat plastic firm, we furniture,household,produce plastic seats items products in Turkey and worldwide.";
                $get['keyw'] = "Plastic garden furniture, plastic chair, Plastic stadium seat,Plastic rattan furniture, Plastic households, Plastic storage containers";
                break;
            case "bahce-mobilyalari":
                if ($urunurl) {
                    $get = $this->getProductTitle($data);
                } else {
                    if ($data['katurl']):
                        $kategori = $this->teksorgu("select * from tumkategori where  $langurl  = '{$katurl}'");
                        $id = $kategori['id'];
                        $keywcek = $this->teksorgu("select * from tumurunler where urunkid = {$id}");
                        $get['title'] = $get['site'] . $kategori['baslik_tr'];
                        $get['desc'] = "Bahçe Mobilyaları - " . $kategori["baslik_tr"];
                        $get['keyw'] = $keywcek['etiket_tr'];
                    else:
                        $get['title'] = $get['site'] . "Bahçe Mobilyaları ";
                        $get['desc'] = "As Murat plastic firm, we furniture,household,produce plastic seats items products in Turkey and worldwide.";
                        $get['keyw'] = "Plastic garden furniture, plastic chair, Plastic stadium seat,Plastic rattan furniture, Plastic households, Plastic storage containers";
                    endif;
                }
                break;
            case "garden-furnitures":
                if ($urunurl) {
                    $get = $this->getProductTitle($data);
                } else {
                    if ($data['katurl']):
                        $kategori = $this->teksorgu("select * from tumkategori where $langurl = '{$katurl}'");
                        $id = $kategori['id'];
                        $keywcek = $this->teksorgu("select * from tumurunler where urunkid = {$id}");
                        if ($id == "233") {
                            $get['title'] = $get['site'] . "Plastic Rattan Furnitures  ";
                            $get['desc'] = "You can find sturdy, stylish and practical plastic rattan furnitures in murat plastik.";
                            $get['keyw'] = " rattan furnitures , plastic furnitures,plastic rattan furnitures, furnitures";
                        } else {

                            $get['title'] = $get['site'] . $kategori['baslik_en'];
                            $get['desc'] = "Garden Furnitures - " . $kategori["baslik_en"];
                            $get['keyw'] = $keywcek['etiket_en'];
                        }


                    else:
                        $get['title'] = $get['site'] . "Plastic Garden Furnitures ";
                        $get['desc'] = "You can find top quality, unbreakable Plastic Garden Furnitures in murat plastik.";
                        $get['keyw'] = "plastic garden furniture, furniture, garden furniture, plastic furniture";
                    endif;
                }
                break;
            case "evgerecleri":
                if ($urunurl) {
                    $get = $this->getProductTitle($data);
                } else {
                    if ($katurl):
                        $kategori = $this->teksorgu("select * from tumkategori where $langurl = '{$katurl}'");
                        $id = $kategori['id'];
                        $keywcek = $this->teksorgu("select * from tumurunler where urunkid = {$id}");
                        $get['title'] = $kategori['baslik_tr'] . $get['site'];
                        $get['desc'] = "Ev Gereçleri - " . $kategori["baslik_tr"];
                        $get['keyw'] = $keywcek['etiket_tr'];
                    else:
                        $get['title'] = "Ev Gereçleri " . $get['site'];
                        $get['desc'] = "Murat Plastik olarak  sebzelik,saklama kabı, ayakkabılık, plastik ev gereçleri  kategorisinde plastik komidin,  çöp kovası, sürahi gibi ürünler üretiyoruz";
                        $get['keyw'] = "Plastik komidin,çöp kovası, çiçek saksısı,plastik sebzelik, plastik ayakkabılık,  saklama kabı, temizlik seti, sürahi, piknik sepeti";
                    endif;
                }
                break;
            case "households":
                if ($urunurl) {
                    $get = $this->getProductTitle($data);
                } else {
                    if ($katurl):
                        $kategori = $this->teksorgu("select * from tumkategori where $langurl = '{$katurl}'");
                        $id = $kategori['id'];
                        $keywcek = $this->teksorgu("select * from tumurunler where urunkid = {$id}");
                        if ($id == "129") {
                            $get['title'] = "Plastic Storage Containers  " . $get['site'];
                            $get['desc'] = "You can find multipurpose plastic storage containers in different lengths and colors in murat plastik.";
                            $get['keyw'] = "plastic storage containers ,  plastic containers, containers, storage containers";
                        } else {

                            $get['title'] = $get['site'] . $kategori['baslik_en'];
                            $get['desc'] = "Households - " . $kategori["baslik_en"];
                            $get['keyw'] = $keywcek['etiket_en'];
                        }
                    else:
                        $get['title'] = $get['site'] . "Plastic Households  ";
                        $get['desc'] = "You can find durable, stylish and easy-to-use plastic households in murat plastik.";
                        $get['keyw'] = "plastic picnic sets, plastic dish racks,plastic drawers, plastic shoe racks, plastic buckets, ";
                    endif;
                }
                break;

            /*
             * Stadyum Koltuğu
             */
            case "stadyum-koltuklari":
                if ($urunurl) {
                    $get = $this->getProductTitle($data);
                } else {
                    $get['title'] = $get['site'] . "Stadyum Koltukları ";
                    $get['desc'] = "Murat Plastik olarak farklı modellerde ve renk seçenekleri ile stadyum ve tribün koltuğu üretimi yapıyoruz";
                    $get['keyw'] = " demir gövdeli tribün koltukları, tribün koltuğu, çift renkli stadyum koltuğu, Stadyum koltuğu,  metal destekli, stadyum koltukları";
                }
                break;
            case "stadium-seats":
                if ($urunurl) {
                    $get = $this->getProductTitle($data);
                } else {
                    $get['title'] = $get['site'] . "Plastic Stadium Seat  ";
                    $get['desc'] = "You can find unbreakable, sturdy and comfortable plastic stadium seat in murat plastik.";
                    $get['keyw'] = "Plastic stadium seats ,seats, stadium seats, Plastic seats ";
                }
                break;
                break;
            case "referanslar":
                if ($urunurl):
                    $ref_galeri = $this->teksorgu("SELECT * FROM referanslar where url = '{$urunurl}'");
                    $get['title'] = $get['site'] . $ref_galeri["firma"];
                    $get['desc'] = "Murat Plastik olarak  plastik ev gereçleri, plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa)  ve stadyum koltuğu üretmekteyiz";
                    $get['keyw'] = "bahçe mobilyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri, plastik mutfak eşyaları, tribün koltuğu, stadyum koltuğu";
                    break;
                endif;

                if ($katurl):
                    $bolge = $this->teksorgu("SELECT BK.id as id, BK.ad AS baslik_tr, BL.ad AS baslik_en,BK.url as url_tr,BL.url as url_en FROM bolge BK, bolge_lang BL WHERE BK.id = BL.master_id and (BL.url='{$katurl}' or BK.url='{$katurl}') limit 1");
                    $get['title'] = $get['site'] . $bolge["baslik_tr"];
                    $get['desc'] = "Murat Plastik olarak  plastik ev gereçleri, plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa)  ve stadyum koltuğu üretmekteyiz";
                    $get['keyw'] = "bahçe mobilyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri, plastik mutfak eşyaları, tribün koltuğu, stadyum koltuğu";
                    break;
                endif;
                $get['title'] = $get['site'] . "Referanslar ";
                $get['desc'] = "Murat Plastik olarak  plastik ev gereçleri, plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa)  ve stadyum koltuğu üretmekteyiz";
                $get['keyw'] = "bahçe mobilyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri, plastik mutfak eşyaları, tribün koltuğu, stadyum koltuğu";
                break;
            case "references":

                if ($urunurl):
                    $ref_galeri = $this->teksorgu("SELECT * FROM referanslar where url = '{$urunurl}'");
                    $get['title'] = $get['site'] . $ref_galeri["firma"];
                    $get['desc'] = "Murat plastic produce garden furnitures (plastic chair, plastic armchair and plastic table), plastic ";
                    $get['keyw'] = "Garden furnitures,plastic households, plastic kithcen equipments, plastic chair, plastic armchair and table,  stadium seats";
                    break;
                endif;

                if ($katurl):
                    $bolge = $this->teksorgu("SELECT BK.id as id, BK.ad AS baslik_tr, BL.ad AS baslik_en,BK.url as url_tr,BL.url as url_en FROM bolge BK, bolge_lang BL WHERE BK.id = BL.master_id and (BL.url='{$katurl}' or BK.url='{$katurl}') limit 1");
                    $get['title'] = $get['site'] . $bolge["baslik_en"];
                    $get['desc'] = "Murat Plastik olarak plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa) , plastik ev gereçleri ve stadyum koltuğu üretmekteyiz";
                    $get['keyw'] = "bahçe mobilyaları,plastik mutfak eşyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri,  tribün koltuğu, stadyum koltuğu";
                    break;
                endif;

                $get['title'] = $get['site'] . "References - ";
                $get['desc'] = "Murat plastic produce garden furnitures (plastic chair, plastic armchair and plastic table), plastic ";
                $get['keyw'] = "Garden furnitures,plastic households, plastic kithcen equipments, plastic chair, plastic armchair and table,  stadium seats";
                break;


            case "haberler":
                if ($katurl):
                    $haber_detay = $this->teksorgu("select * from haberler where url = '{$katurl}'");
                    $get['title'] = $get['site'] . $haber_detay["baslik"];
                    $get['desc'] = $haber_detay["ozet"];
                    $get['keyw'] = "bahçe mobilyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri, plastik mutfak eşyaları, tribün koltuğu, stadyum koltuğu";
                else:
                    $get['title'] = $get['site'] . "Haberler - ";
                    $get['desc'] = "Murat Plastik olarak plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa) , plastik ev gereçleri ve stadyum koltuğu üretmekteyiz";
                    $get['keyw'] = "bahçe mobilyaları,plastik mutfak eşyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri,  tribün koltuğu, stadyum koltuğu";
                endif;
                break;
            case "news":

                if ($katurl):
                    $haber_detay = $this->teksorgu("select * from haberler_lang where url = '{$katurl}'");
                    $get['title'] = $haber_detay["baslik"];
                    $get['desc'] = $haber_detay["ozet"];
                    $get['keyw'] = "Garden furnitures,plastic households, plastic kithcen equipments, plastic chair, plastic armchair and table,  stadium seats";
                else:
                    $get['title'] = $get['site'] . "News  ";
                    $get['desc'] = "Murat plastic produce garden furnitures (plastic chair, plastic armchair and plastic table), plastic ";
                    $get['keyw'] = "Garden furnitures, plastic chair, plastic armchair and table, plastic households, plastic kithcen equipments, stadium seats";
                endif;
                break;

            case "belgelerimiz":
                $get['title'] = $get['site'] . "Belgelerimiz";
                $get['desc'] = "Murat Plastik olarak plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa) , plastik ev gereçleri ve stadyum koltuğu üretmekteyiz";
                $get['keyw'] = "bahçe mobilyaları,plastik mutfak eşyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri,  tribün koltuğu, stadyum koltuğu";
                break;
            case "certificates":
                $get['title'] = $get['site'] . "Certificates";
                $get['desc'] = "Murat plastic produce garden furnitures (plastic chair, plastic armchair and plastic table), plastic ";
                $get['keyw'] = "Garden furnitures, plastic chair, plastic armchair and table, plastic households, plastic kithcen equipments, stadium seats";
                break;
            /*
             * İletişim
             */
            case "iletisim":
                $get['title'] = $get['site'] . "İletişim ";
                $get['desc'] = "Murat Plastik olarak plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa) , plastik ev gereçleri ve stadyum koltuğu üretmekteyiz";
                $get['keyw'] = "bahçe mobilyaları,plastik mutfak eşyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri,  tribün koltuğu, stadyum koltuğu";
                break;
            case "contact":
                $get['title'] = $get['site'] . "Contact ";
                $get['desc'] = "Murat plastic produce garden furnitures (plastic chair, plastic armchair and plastic table), plastic ";
                $get['keyw'] = "Garden furnitures, plastic chair, plastic armchair and table, plastic households, plastic kithcen equipments, stadium seats";
                break;

            case "stadyum_koltugu_kalite_test_filmi":
                $get['title'] = $get['site'] . "Stadyum Koltuğu Kalite Test Filmi - ";
                $get['desc'] = "Murat Plastik olarak plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa) , plastik ev gereçleri ve stadyum koltuğu üretmekteyiz";
                $get['keyw'] = "bahçe mobilyaları,plastik mutfak eşyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri,  tribün koltuğu, stadyum koltuğu";
                break;
            case "ekatalog":
                $get['title'] = $get['site'] . "E Katalog";
                $get['desc'] = "Murat Plastik olarak plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa) , plastik ev gereçleri ve stadyum koltuğu üretmekteyiz";
                $get['keyw'] = "bahçe mobilyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri, plastik mutfak eşyaları, tribün koltuğu, stadyum koltuğu";
                break;
            case "ecatalogue":
                $get['title'] = $get['site'] . "E Catalogue - ";
                $get['desc'] = "Murat plastic produce garden furnitures (plastic chair, plastic armchair and plastic table), plastic ";
                $get['keyw'] = "Garden furnitures, plastic chair, plastic armchair and table, plastic households, plastic kithcen equipments, stadium seats";
                break;

            case 'tribun_koltugu_teknik_ozellikleri':
                $get['title'] = $get['site'] . "Tribün Koltuğu Teknik Özellikleri - ";
                $get['desc'] = "Murat Plastik olarak plastik bahçe mobilyaları (plastik koltuk,plastik sandalye ve plastik masa) , plastik ev gereçleri ve stadyum koltuğu üretmekteyiz";
                $get['keyw'] = "bahçe mobilyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri, plastik mutfak eşyaları, tribün koltuğu, stadyum koltuğu";
                break;
            case 'tribune_seat_technical_features':
                $get['title'] = "Tribune Seat Technical Features - " . $get['site'];
                $get['desc'] = "Murat plastic produce garden furnitures (plastic chair, plastic armchair and plastic table), plastic ";
                $get['keyw'] = "Garden furnitures, plastic chair, plastic armchair and table, plastic households, plastic kithcen equipments, stadium seats";
                break;

            case "faydali":
            case "usefulinformation":
                if ($data['lang'] == "tr") {
                    $faydali = $this->teksorgu("select * from faydali where url = '{$katurl}'");
                    $get['title'] = $get['site'] . $faydali["baslik"];
                    $get['desc'] = $faydali["baslik"];
                    $get['keyw'] = "bahçe mobilyaları, plastik koltuk, plastik masa ve sandalye, plastik ev gereçleri, plastik mutfak eşyaları, tribün koltuğu, stadyum koltuğu";
                } else {
                    $faydali = $this->teksorgu("select * from faydali_lang where url = '{$katurl}'");
                    $get['title'] = $get['site'] . $faydali["baslik"];
                    $get['desc'] = $get['site'] . $faydali["baslik"];
                    $get['keyw'] = "Garden furnitures, plastic chair, plastic armchair and table, plastic households, plastic kithcen equipments, stadium seats";
                }
                break;


        endswitch;

        // return $get;

    }


    public function breadcrumb($param = array()){

        $text = '<div class="breadcrumb">
    <div class="container" style="text-align: left">
        <ul>';


        if(is_array($param))
        foreach ($param as $key=>$item):

            $text .='  <li '.((($key+1) == count($param)) ? 'class="active"':'').'> '.((($key+1) == count($param)) ? $item['text']:'<a href="'.$item['url'].'">'.$item['text'].'</a>').'</li>';
            if(($key+1) < count($param))  $text .='<li ><i class="fa fa-caret-right"></i></li>';
            endforeach;


            /*<li><i class="fa fa-caret-right"></i></li>
            <li class="active">About</li>*/
       $text .='</ul>
    </div>
</div> <!-- /breadcrumb -->';




        return $text;

    }


}







?>
