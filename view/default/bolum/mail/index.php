<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>E-posta Gönderimi</title>
	
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
<?php error_reporting(E_ALL); ?>
<?php
	if ( $_POST ){
		$adsoyad = htmlspecialchars(trim($_POST['mail']));
		$firma = htmlspecialchars(trim($_POST['firma']));
		$ad = htmlspecialchars(trim($_POST['ad']));
		$email = htmlspecialchars(trim($_POST['mail']));
		$adres = htmlspecialchars(trim($_POST['adres']));
		$telefon = htmlspecialchars(trim($_POST['telefon']));
		$mesaj = htmlspecialchars(trim($_POST['mesaj']));

    $eposta1 =  "mustafa@digitalkure.com";
		include 'class.phpmailer.php';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = 'mail.izray.com.tr';
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = 'web@izray.com.tr';
		$mail->Password = 'izraycomtrdk';
		$mail->SetFrom($mail->Username, 'İzray');
		$mail->AddAddress($eposta1, $adsoyad);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'İzray';
		$content = '<div style="background: #eee; padding: 10px; font-size: 14px"> <p> '.$firma.' </p> <p> '.$ad.' </p> <p> '.$email.' </p> <p> '.$adres.' </p> <p> '.$telefon.' </p> <p> '.$mesaj.'</p> </div>';
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
 
</html>