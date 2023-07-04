<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>PHPMailer ile E-posta Gönderimi (DEMO) - digitalkure.com</title>
	
	<style type="text/css">
	* {
		padding: 0; margin: 0; list-style: none; border: none; font-family: Arial; font-size: 14px
	}
	textarea, input {
		border: 1px solid #ddd;
		border-top-color: #aaa;
		border-left-color: #aaa;
		padding: 7px;
		resize: none
	}
	input:focus, textarea:focus {
		outline: 1px solid #205ec1
	}
	button {
		background: #205ec1;
		color: #fff;
		padding: 7px 13px;
		cursor: pointer
	}
	form {
		width: 400px;
		margin: 20px auto;
		background: #f9f9f9;
		padding: 10px;
		border: 1px solid #ddd;
		border-top-color: #aaa;
		border-left-color: #aaa
	}
	form h3 {
		font-size: 21px;
		font-weight: normal;
		margin-bottom: 10px;
		border-bottom: 1px solid #ddd;
		padding-bottom: 10px
	}
	table tr td {
		padding: 6px
	}
	.success {
		border: 1px solid green;
		color: green;
		padding: 10px;
		margin: 20px auto;
		width: 400px
	}
	.error {
		border: 1px solid red;
		color: red;
		padding: 10px;
		margin: 20px auto;
		width: 400px
	}
	</style>
	
</head>
<body>

<?php

	if ( $_POST ){
	
		$pozisyon = htmlspecialchars(trim($_POST['pozisyon']));
		$ad = htmlspecialchars(trim($_POST['ad']));
		$dogumyeri = htmlspecialchars(trim($_POST['dogumyeri']));
		$dogumtarihi = htmlspecialchars(trim($_POST['dogumtarihi']));
		$cinsiyet = htmlspecialchars(trim($_POST['cinsiyet']));
		$medenihali = htmlspecialchars(trim($_POST['medenihali']));
		$kangrubu = htmlspecialchars(trim($_POST['kangrubu']));
		$boy = htmlspecialchars(trim($_POST['boy']));
		$kilo = htmlspecialchars(trim($_POST['kilo']));
		$seyehatengeli = htmlspecialchars(trim($_POST['seyehatengeli']));
		$saglikproblemi = htmlspecialchars(trim($_POST['saglikproblemi']));
		$sabika = htmlspecialchars(trim($_POST['sabika']));
		$ehliyet = htmlspecialchars(trim($_POST['ehliyet']));
		$ikamet = htmlspecialchars(trim($_POST['ikamet']));
		$ililce = htmlspecialchars(trim($_POST['ililce']));
		$posta = htmlspecialchars(trim($_POST['posta']));
		$evtel = htmlspecialchars(trim($_POST['evtel']));
		$ceptel = htmlspecialchars(trim($_POST['ceptel']));
		$mail = htmlspecialchars(trim($_POST['mail']));
		$beklenti = htmlspecialchars(trim($_POST['beklenti']));
		$askerlik = htmlspecialchars(trim($_POST['askerlik']));
		$mezun = htmlspecialchars(trim($_POST['mezun']));
		$bolum = htmlspecialchars(trim($_POST['bolum']));
		$yil = htmlspecialchars(trim($_POST['yil']));
		$dilbilgi = htmlspecialchars(trim($_POST['dilbilgi']));
		$konusma = htmlspecialchars(trim($_POST['konusma']));
		$yazma = htmlspecialchars(trim($_POST['yazma']));
		$okuma = htmlspecialchars(trim($_POST['okuma']));
		
		
    	$eposta1 =  "anel@anelelektroteknik.com";
		include 'class.phpmailer.php';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.office365.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->Username = 'anel@anelelektroteknik.com';
		$mail->Password = 'Turkticaret16!';
		$mail->SetFrom($mail->Username, 'Anel Elektroteknik');
		$mail->AddAddress($eposta1, $adsoyad);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Anel Elektroteknik Başvuru Formu';
        $content = '
        <div style="background: #eee; padding: 10px; font-size: 14px">
         <p> '.$pozisyon.' </p> <p> '.$ad.' </p> <p> '.$dogumyeri.' </p> <p> '.$dogumtarihi.' </p> <p> '.$cinsiyet.'</p> <p> '.$medenihali.'</p> <p> '.$kangrubu.'</p> <p> '.$boy.'</p> <p> '.$kilo.'</p>
         <p> '.$seyehatengeli.'</p>  <p> '.$saglikproblemi.'</p> <p> '.$sabika.'</p> <p> '.$ehliyet.'</p> <p> '.$ikamet.'</p> <p> '.$ililce.'</p> <p> '.$posta.'</p> <p> '.$evtel.'</p> <p> '.$ceptel.'</p> 
         <p> '.$mail.'</p> <p> '.$beklenti.'</p> <p> '.$askerlik.'</p> <p> '.$mezun.'</p> <p> '.$bolum.'</p> <p> '.$yil.'</p> <p> '.$dilbilgi.'</p> <p> '.$konusma.'</p> <p> '.$yazma.'</p> <p> '.$yazma.'</p>
          </div>';
		$mail->MsgHTML($content);
		if($mail->Send()) {
			// e-posta başarılı ile gönderildi
			echo '<div class="success">E-posta başarıyla gönderildi, lütfen kontrol edin.</div>';
		} else {
			// bir sorun var, sorunu ekrana bastıralım
			echo '<div class="error">'.$mail->ErrorInfo.'</div>';
		}
	
	}
	
?>
  <script type="text/javascript">
            window.location = "http://www.anelelektroteknik.com/iletisim.html"
    </script>

</body>
</html>