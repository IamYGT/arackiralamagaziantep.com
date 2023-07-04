<?php
Namespace Fonksiyonlar;


class Func extends \Smap
{

	public $image_types = array("jpeg", "jpg", "gif", "png","JPEG", "JPG", "GIF", "PNG");
	public $office_types = array("xls", "xlsx", "doc", "docx","ppt","pps","pptx","ppsx","XLS", "XLSX", "DOC", "DOCX","PPT","PPS","PPTX","PPSX");
	public $document_types = array("txt", "pdf", "mp3", "avi", "mp4", "flv", "rar", "zip","TXT", "PDF", "MP3", "AVI", "MP4", "FLV", "RAR", "ZIP");


	public function __construct($settings)
	{
		parent::__construct($settings);

	}

	public  function koru($value)
	{
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		return $value;
	}

	public function ResimSil($eski_resim,$klasor)
	{
		if(file_exists($klasor.$eski_resim))
		{
			unlink($klasor.$eski_resim);

			$dosyaadisp = explode(".",$eski_resim);   // thumb Resimlerinide silmek için
			$liste = $this->klasorDosyaListesi($klasor.'temp/');

			foreach($liste as $jpg)
			{

				if( strpos($jpg, $dosyaadisp[0])>-1)
				{
					unlink($klasor.'temp/'.$jpg);
				}
			}
		}
	}

	public function ozet($yazi,$sinir) { // Metinin özetini değer göndererek alabilmek için.

		$kelime = explode(" ",$yazi);
		$say = count($kelime);
		$as="";

		if($say <= $sinir)
		{
			$as = $yazi;
		}
		else
		{
			for($i = 0; $i <= $sinir; $i++)
			{
				$as .= $kelime[$i].' ';
			}

			$as.="...";
		}
		return $as;
	}




	public function Per($deger)
	{
		$deger = strtolower($deger);
		$turkce = array("ı","þ", "Þ", "ý", "(", ")", "'", "ü", "Ü", "ö", "Ö", "ç", "Ç", " ", "/", "*", "?", "ð", "Ð", "Ý", "Ã–", "Ã‡", "Åž", "Ä°", "Äž", "Ãœ", "Ä±", "Ã¶", "Ã§", "ÅŸ", "ÄŸ", "Ã¼", "ı", "ğ", 'İ', 'Ü', 'Ğ', 'Ş', '.', 'ş', '"');
		$duzgun = array("i","s", "s", "i", "", "", "", "u", "u", "o", "o", "c", "c", "-", "", "-", "", "g", "g", "i", "o", "c", "s", "i", "g", "u", "i", "o", "c", "s", "g", "u", "i", "g", 'i', 'u', 'g', 's', '', 's', '');
		$deger=str_replace($turkce,$duzgun,$deger);
		$deger = preg_replace("@[^A-Za-z0-9\-_]+@i","",$deger);
		return $deger;
	}

	public function strip_tags_content($text, $tags = '', $invert = FALSE) {

		preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
		$tags = array_unique($tags[1]);

		if(is_array($tags) AND count($tags) > 0) {
			if($invert == FALSE) {
				return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
			}
			else {
				return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
			}
		}
		elseif($invert == FALSE) {
			return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		return $text;
	}


	public function permalink($str, $options = array())
	{
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		$defaults = array(
			'delimiter' => '-',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => true
		);
		$options = array_merge($defaults, $options);
		$char_map = array(
			// Latin
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
			'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
			'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
			'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
			'ß' => 'ss',
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
			'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
			'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
			'ÿ' => 'y',
			// Latin symbols
			'©' => '(c)',
			// Greek
			'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
			'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
			'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
			'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
			'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
			'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
			// Turkish
			'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
			// Russian
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
			'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
			'Я' => 'Ya',
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
			'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
			'я' => 'ya',
			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
			// Czech
			'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
			'Ž' => 'Z',
			'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
			'ž' => 'z',
			// Polish
			'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
			'Ż' => 'Z',
			'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
			'ż' => 'z',
			// Latvian
			'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
			'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
			'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
			'š' => 's', 'ū' => 'u', 'ž' => 'z'
		);
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
		$str = trim($str, $options['delimiter']);
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}



	public function sifre_uret($uzunluk)
	{
		$sifre_ver='';
		$karakterler = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPRSTUVYZ";
		$karakter_sayi = strlen($karakterler);
		for ($ras = 0; $ras < $uzunluk; $ras++) {
			$rakam_ver = rand(0,$karakter_sayi-1);
			$sifre_ver .= $karakterler[$rakam_ver];
		}
		return $sifre_ver;
	}

	public function kar($gelen)
	{
		$b=sifre_uret(7).$gelen.sifre_uret(7);
		return $b;
	}


	public  function temiz($gel)
	{
		$b=substr($gel,7,-7);
		return $b;
	}

	public function uzanti($gelen2)  //  resim resim adýný gizle
	{
		$b2=substr($gelen2,0,-4);
		return $b2;
	}
	///////////////////////////////////////////

	// $sitex= $_SERVER['SERVER_NAME'];
	// $site="http://$sitex/";

	public function kharf( $giris )
	{
		return strtolower(strtr( $giris,'JPGEN','jpgen'));
	}


	public function addegisir($resim,$ad) // resmin adýndaki karakterleri düzenle
	{
		$random = rand(11111,999999);
		$parca = explode(".",$resim);
		$parcaadet = count($parca);
		$uzanti=$parca[$parcaadet-1];
		$resim6=$this->per("$ad")."-".$random.".".$this->kharf($uzanti);
		return $resim6;
	}

	public function sifrele($id)
	{
		$carpim = rand(100,999);
		$ilk = sifre_uret(8);
		$son = sifre_uret(8);
		$son .= "$".(strlen($ilk)*$carpim)."$".strlen("$id")."$".$carpim;
		$deger = $ilk."$id".$son;
		return $deger;
	}

	public function desifrele($sifreliid)
	{

		$sp = explode("$",$sifreliid);
		$idcarpim = $sp[3];
		$iduzunluk = $sp[2];
		$charuzunluk = $sp[1];

		//return $sp[0]." ".$charuzunluk." ".$iduzunluk;
		return substr($sp[0], $charuzunluk/$idcarpim, $iduzunluk);
	}

	public function harf_sifrele($_id, $_array = array(""))
	{
		$tablo_g = array("a", "x", "y", "q");
		$tablo_k = array("w", "c", "f", "u");
		$tablo_u = array("s", "i", "v", "b");
		$tablo_m = array("m", "g", "k", "t");
		global $tablo_g, $tablo_k, $tablo_u, $tablo_m;
		if(count($_array) == 1){ $_array = $g; }
		$rnd = rand(0,count($_array) - 1);
		return $_array[$rnd].$_id;
	}

	public function harf_coz($_str)
	{
		global $tablo_g,$tablo_k,$tablo_u,$tablo_m;
		for($i = 0; $i < count($tablo_g); $i++){
			if($tablo_g[$i] == $_str) { return "G"; break; }
			if($tablo_k[$i] == $_str) { return "K"; break; }
			if($tablo_m[$i] == $_str) { return "M"; break; }
			if($tablo_u[$i] == $_str) { return "U"; break; }
		}
	}

	///////////////////////////////////////////Adres satýrýndan sadece sayfa adýný almak için iletisim.php gibi
	public  function sayfaBul($pos = 1)
	{
		$url = $_SERVER["SCRIPT_NAME"];
		$spl = explode("/",$url);
		$pge = $spl[count($spl)-$pos];
		return $pge;
	}
	///////////////////////////////////////////Adres satýrýndan sadece sayfa adýný almak için iletisim.php?54646&345435 gibi
	public  function linkBul()
	{
		return $_SERVER['REQUEST_URI'];
	}



	/////////////////////////////////7linkbulu kullanarak linki alýr ve  ? den sonrasýný almaya yarar. örnek grup-marka-fgh3454gdfgd?5 gibi 5 i almak için kullanýlýr
	public  function linksonu()
	{
		$a=linkBul();
		$spy = explode("?",$a);
		$sayfa = $spy[1];
		return $sayfa;
	}


/////////////////////////////////kalsör listesi ve dosyala listelemeye yarar veritabaný olmadan resimleri silmek için



	public 	function dosyaturukontrol($xfilename, $filetypearray){
		$ftjpegs = array("JPG");
		$ftimage = array("JPG", "JPEG", "GIF", "PNG");
		$ftalltype = array("*");

		$filetype = $this->dosyaturual($xfilename);
		if(count($filetypearray)>0){
			foreach($filetypearray as $in){
				if($in == "*"){
					return true;
					break;
				}else{
					if($in == $filetype){
						return true;
						break;
					}
				}
			}
		}
		return false;
	}

	public function dosyaturual($xfilename){$sp = explode(".", $xfilename);return strtoupper($sp[count($sp)-1]);}

	public function klasorDosyaListesi($_folder, $foldersOrFiles = "file", $reqtype = array("JPG")){
		$_folderlist = array();
		if(file_exists($_folder)){
			if ($handle = opendir($_folder)) {
				while ($obj = readdir($handle)) {
					if ($obj!= '.' && $obj!= '..' && $obj!= '_notes') {
						if($foldersOrFiles=="folder"){if (is_dir($_folder.$obj)) {$_folderlist[] = $obj;}}else{if(is_file($_folder.$obj)){if($this->dosyaturukontrol($obj, $reqtype)){$_folderlist[] =  $obj;}}}
					}
				}
				closedir($handle);
			}
		}
		return $_folderlist;
	}


	public function CheckArray($str, $array){
		$found = false;
		for($i = 0; $i < count($array); $i++){
			if($array[$i] == $str){
				$found = true;
				break;
			}
		}
		return $found;
	}



	public function tarihFormat($tarih = "")
	{
		if ($tarih=="")
			$tarih = date("Y-m-d H:i:s");

		$tarihDizi["gunler"] = array("Pazar","Pazartesi","Salý","Çarþamba","Perþembe","Cuma","Cumartesi");
		$tarihDizi["aylar"] = array ("01" => "Ocak", "02" => "Þubat", "03" => "Mart", "04" => "Nisan", "05" => "Mayýs", "06" => "Haziran",
			"07" => "Temmuz", "08" => "Aðustos", "09" => "Eylül", "10" => "Ekim", "11" => "Kasým", "12" => "Aralýk");

		$zamanExp = explode (" ",$tarih);
		$tarihExp = explode ("-",$zamanExp[0]);

		$haftaninGunu=strftime("%w",strtotime($tarih));
		$tarihFormat["ay"] = $tarihDizi["aylar"][$tarihExp[1]];
		$tarihFormat["haftanin_gunu"] = $tarihDizi["gunler"][$haftaninGunu];
		$tarihFormat["saat"] = $zamanExp[1];
		$tarihFormat["format1"] = $tarihExp[2]."-".$tarihExp[1]."-".$tarihExp[0];
		$tarihFormat["format2"] = $tarihFormat["format1"]." ".$tarihFormat["saat"];
		$tarihFormat["format3"] = $tarihExp[2]." ".$tarihFormat["ay"]." ".$tarihExp[0];
		$tarihFormat["format4"] = $tarihFormat["format3"]." ".$tarihFormat["haftanin_gunu"];
		$tarihFormat["format5"] = $tarihFormat["format3"]." ".$tarihFormat["haftanin_gunu"]." ".$zamanExp[1];

		$tarihFormat["format6"] = $tarihExp[0]."-".$tarihExp[1]."-".$tarihExp[2];

		return $tarihFormat;
	}
	/*
    //Kullanýmý:
    $formatliTarih = tarihFormat("2007-07-16 18:32:00");
    //$formatliTarih = tarihFormat($bilgi->baslama_tarihi);        Veritabanýndan gelen bir deðeri kullanabilirsiniz.
    //$formatliTarih = tarihFormat();                            O ana ait tarih bilgileri için bu þekilde kulkanabilirsiniz.

    echo $formatliTarih["format4"]."<br>";
    //16 Temmuz 2007 Pazartesi
    echo $formatliTarih["format3"]."<br>";
    //16 Temmuz 2007
    echo $formatliTarih["format2"]."<br>";
    //16-07-2007 18:32:00
    echo $formatliTarih["format1"]."<br>";
    //16-07-2007
    echo $formatliTarih["saat"]."<br>";
    //18:32:00
    echo $formatliTarih["haftanin_gunu"]."<br>";
    //Pazartesi
    echo $formatliTarih["ay"]."<br>";
    //Temmuz

    */

	public function mailkontrol($mail) {
		if(eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\.[a-z]{2,4}$",$mail)) {
			return true;  } else {
			return false;
		} }




	public function SayfaYonlendir($url="",$sure=1)
	{
		echo "<meta content='$sure; URL=$url' http-equiv='refresh'>";
	}




	public function kirlet($str){
		$find = array("'",    ">",    "<",    "%",    "\r\n", "\"");
		$repl = array("&39;", "&gt;", "&lt;", "&49;", " ",    "&quot;");
		$str = str_replace($find, $repl, $str);
		return $str;
	}

	public function temizle($str){
		$find = array("&39;","&gt;","&lt;","&49;","&Uuml;","&uuml;","&Ccedil;","&ccedil;","&Ouml;","&ouml;", "&quot;");
		$repl = array("'",">","<","%","Ü","ü","Ç","ç","Ö","ö", "\"");
		$str = str_replace($find, $repl, $str);
		return $str;
	}






	public function resimal($w="",$h="",$resim,$folder="", $center = true)
	{

		if(!file_exists($folder.'temp/')) {mkdir($folder.'temp/', 0755);}

		$dosyaAdi 	= substr($resim, 0, strrpos($resim, '.'));
		$uzanti 	= substr($resim, strrpos($resim, '.'));
		$thumbFileName = $dosyaAdi."_";
		$thumbFileName .= $w>0 ? 'w'.$w.'_' : '';
		$thumbFileName .= $h>0 ? 'h'.$h : '';
		$thumbFileName .= $uzanti;

		if(! file_exists($folder.'temp/'.$thumbFileName)) {

			$thumb = new \PHPThumb\GD($folder.$resim,['jpegQuality'=>90]); //yüklenen fotoyu alýyor

			// $image = Image::make($folder.$resim)->fit($w,$h);
			/*
              if($w>$h)

              if($h>$w)
             $image = Image::make($folder.$resim)->resize(null,$h)->fit($w,$h);
            */
			// $image->save($folder.'temp/'.$thumbFileName, 72);

			$thumb->adaptiveResize($w, $h, $center);// ebat deðiþtiriyor - kesin oranti ($maxWidth, $maxHeight)

			$thumb->save($folder.'temp/'.$thumbFileName);//ayný adrese yeni formatýyla yazýyor

		}

		return $folder.'temp/'.$thumbFileName;

	}



	public function resimal2($w="",$h="",$resim,$folder="")
	{
		if(!file_exists($folder.'temp/')) {mkdir($folder.'temp/', 0755);}
		$dosyaAdi 	= substr($resim, 0, strrpos($resim, '.'));
		$uzanti 	= substr($resim, strrpos($resim, '.'));
		$thumbFileName = $dosyaAdi."_";
		$thumbFileName .= $w>0 ? 'w'.$w.'_' : '';
		$thumbFileName .= $h>0 ? 'h'.$h : '';
		$thumbFileName .= $uzanti;

		if(! file_exists($folder.'temp/'.$thumbFileName)) {
			//    $image = Image::make($folder.$resim)->resize($w,$h)->crop($w,$h,0,0);
			//	$image->save($folder.'temp/'.$thumbFileName,72);//ayný adrese yeni formatýyla yazýyor



			$thumb = new \PHPThumb\GD($folder.$resim,['jpegQuality'=>90]); //yüklenen fotoyu alýyor
			$thumb->resize($w, $h);// ebat deðiþtiriyor - resize ($maxWidth, $maxHeight)

			$thumb->save($folder.'temp/'.$thumbFileName);//ayný adrese yeni formatýyla yazýyor
		}

		return $folder.'temp/'.$thumbFileName;

	}






	public function kucult($folder,$resim,$w,$h) //Resmi istenilen ebata getir.
	{

//	if((0 < $h and $h < $height) or (0 < $w and $w < $width))
		//{
		$thumb = new \PHPThumb\GD($folder.$resim); //yüklenen fotoyu alýyor
		$thumb->resize($w, $h);// açýklama aþaðýda - resize ($maxWidth, $maxHeight)
		$thumb->save($folder.$resim);//ayný adrese yeni formatýyla yazýyor
		/*
       resize : iki tarafýný orantýlý göre küçültüyor.
       adaptiveResize : iki tarafýnýda kesin istenen ebata getiriyor
        */
//	}
	}



	public	function kucult2($folder,$resim,$w,$h) //Resmi istenilen ebata getir, Watermark Uygula
	{
		$thumb = new \PHPThumb\GD($folder.$resim); //yüklenen fotoyu alýyor
		$thumb->resize($w, $h);// açýklama aþaðýda - resize ($maxWidth, $maxHeight)
		$thumb->save($folder.$resim);//ayný adrese yeni formatýyla yazýyor

///watermark	//////////////////////////////////////
		$imgfilex=$folder.$resim;
		$origimg = imagecreatefromjpeg($imgfilex);
		$reklam = ImageCreateFromPNG($folder."watermark.png");
		list($widthx, $heightx) = getimagesize($imgfilex);
		$cropimg = imagecreatetruecolor($widthx,$heightx);
		ImageCopy ($origimg, $reklam, imagesx($origimg)/2-imagesx($reklam)/2, imagesy($origimg)/2, 0, 0, imagesx($reklam), imagesy($reklam));
		imagecopyresampled($cropimg, $origimg, 0, 0, 0, 0, $widthx, $heightx, $widthx, $heightx);
		imagejpeg($cropimg,$imgfilex, 100);
//////////////////////////////////////



		/*
        resize : iki tarafýný orantýlý göre küçültüyor.
        adaptiveResize : iki tarafýnýda kesin istenen ebata getiriyor

        */


	}




}



?>