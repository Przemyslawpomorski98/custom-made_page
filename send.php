<?php 
	/*
	zostaw localhost, podaj maila z serwera w from
	wrzuć na serwer - u ciebie to nie pujdzie bo pewnie nie masz pełnego xamppa (mercury potrzebne)
	w przypadku jakbyś chciał podłączyć tu gmaila zamiast serwera home robisz tak:
	typ:imap zamiast smtp,
	port:taki jak wyczytasz w ustawieniach bądz 995
	user:użytkownik bez albo z @gmail.com
	pass:haslo

	w razie w dla smtp to wrzucasz wypełnione do php.ini
	SMTP = smtp.example.com //zmien
	smtp_port = 25 //zostaw jak nie musisz
	username = info@example.com //zmien
	password = yourmailpassord //zmien
	sendmail_from = info@example.com //zmien

	analogicznie

	[mail function]
	; For Win32 only.
	SMTP = mail.yourserver.com
	smtp_port = 25
	auth_username = smtp-username
	auth_password = smtp-password
	sendmail_from = you@yourserver.com
	*/
	$settings=array(
		"from"=>array(
			"email"=>"dupa123@kinderchujemuje.org",//zastap
			"type"=>"smtp",
			"port"=>"25",
			"host"=>"localhost",
			"use_ini"=>true,
			"user"=>"",
			"pass"=>"",
			"name"=>"Jan Sobieski",
		),
		"to"=>array(
			"email"=>"jansobieski3@krolestwopolskie.pl",//zastap
			"name"=>"Jan Sobieski",
		)
	);
	function validateTypes($type='', $text='') {
		if($type=='email'){
			$v = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
			return preg_match($v, $text)===1;
		}elseif($type=='txt'){
			if(trim($text)){
				return true;
			}else{
				return false;
			}
		}elseif($type=='country'){
			if(($text>1&&$text<=250)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function mail_header_from_maker($name, $email){
		return $name." <".$email.">";
	}
	function mail_header_generator($header_array){
		$return="";
		foreach($header_array as $k=>$v){
			$return.=$k.": ".$v."\r\n";
		}
		return $return;
	}
	function mailsend($txt='', $header='No title'){
		global $settings;
		$tmp=null;
		switch($settings['from']['type']){
			case "smtp":

			break;
			case "imap":
			case "pop3":
				$tmp=imap_open("{".$settings['from']['host'].":".$settings['from']['port']."/".$settings['from']['type']."/ssl/novalidate-cert}", $settings['from']['user'], $settings['from']['pass']);
			break;
		}
		$tmp_header=array(
			"From"=>mail_header_from_maker($settings['from']['name'],$settings['from']['email']),
			"To"=>mail_header_from_maker($settings['to']['name'],$settings['to']['email']),
			"MIME-Version"=>"1.0",
			"Content-type"=>"text/html; charset=utf-8"
		);
		//
		$message='<html><head><title>';
		$message.=$header;//no title
		$message.='</title></head><body>';
		$message.=$txt;//content
		$message.='</body></html>';
		switch($settings['from']['type']){
			case "smtp":
				return mail($settings['to']['email'], $header, $message, mail_header_generator($tmp_header));
			break;
			case "imap":
			case "pop3":
				imap_mail($settings['to']['email'], $header, $message, mail_header_generator($tmp_header));
				$tmp=imap_close($tmp);
			break;
		}
	}

	$errors = array();

	$name = trim($_POST['name']);
	$surname = trim($_POST['surname']);
	$birthdate = trim($_POST['birthdate']);
	$email = trim($_POST['email']);

	$bezubezpieczenia  = filter_var($_POST['bezubezpieczenia'], FILTER_VALIDATE_BOOLEAN);
	$bezubezpieczeniaFirma  = $_POST['bezubezpieczeniaFirma'];
	$bezubezpieczeniaIndywidualne  = $_POST['bezubezpieczeniaIndywidualne'];
	$bezubezpieczeniaKomunikacja  = filter_var($_POST['bezubezpieczeniaKomunikacja'], FILTER_VALIDATE_BOOLEAN);
	$firmowe  = filter_var($_POST['firmowe'], FILTER_VALIDATE_BOOLEAN);
	$firmoweMienie  = $_POST['firmoweMienie'];
	$firmoweOC  = $_POST['firmoweOC'];
	$firmoweZycie = $_POST['firmoweZycie'];
	$indywidualne  = filter_var($_POST['indywidualne'], FILTER_VALIDATE_BOOLEAN);
	$indywidualneZycie  = $_POST['indywidualneZycie'];
	$indywidualneMajatek  = $_POST['indywidualneMajatek'];
	$indywidualneOC  = $_POST['indywidualneOC'];
	$komunikacja  = filter_var($_POST['komunikacja'], FILTER_VALIDATE_BOOLEAN);
	$komunikacjaOC  = $_POST['komunikacjaOC'];
	$komunikacjaAC  = $_POST['komunikacjaAC'];
	$komunikacjaAss  = $_POST['komunikacjaAss'];
	$contactNumber  = trim($_POST['contactNumber']);
	$rodo  = filter_var($_POST['rodo'], FILTER_VALIDATE_BOOLEAN);


	if(!validateTypes('txt', $name)){
		$errors['name'] = 'Prosze podać imię';
	}
	if(!validateTypes('txt', $surname)){
		$errors['surname'] = 'Prosze podać nazwisko';
	}
	if(!validateTypes('txt', $birthdate)){
		$errors['birthdate'] = 'Prosze podać date urodzenia';
	}
	if(!validateTypes('email', $email)){
		$errors['email'] = 'Nieprawidłowy format adresu email';
	}
	if(!validateTypes('txt', $contactNumber)){
		$errors['contactNumber'] = 'Prosze podać numer telefonu';
	}
	if(!$rodo){
		$errors['rodo'] = 'Zgoda wymagana';
	}
	// if(!validateTypes('txt', $text)){
	// 	$errors['text'] = 'Prosze podaÄ‡ treĹ›Ä‡ wiadomoĹ›ci';
	// }
	if(count($errors)>0){
		$result = array( 'type' => 'error', 'code' => $errors);
	}else{
		$result = array( 'type' => 'success', 'code' => 'Dziękujemy za wysłanie wiadomości');

		$txt  = '<b>name:</b> '.$name.'<br>';
		$txt .= '<b>nazwisko:</b> '.$surname.'<br>';
		$txt .= '<b>email:</b> '.$email.'<br>';
		$txt .= '<b>numer telefonu:</b> '.$contactNumber.'<br>';
		$txt .= '<b>data urodzenia:</b> '.$birthdate.'<br>';
		$txt .= '<h3>Rodzaje ubezpieczeĹ„</h3><br>';
		if($bezubezpieczenia){
			$txt .= '<b>Ubezpieczenie firmowe </b>' . $bezubezpieczeniaFirma . 'Ubezpieczenie indywidualne' . $bezubezpieczeniaIndywidualne . 'Ubezpieczenie komunikacyjne' . $bezubezpieczeniaKomunikacja . '<br>';
		}
		if($firmowe){
			$txt .= '<b>Mienie firmy </b>' . $firmoweMienie . 'OC firmy' . $firmoweOC . 'Zyciowe dla pracownikow' . $firmoweZycie . '<br>';
		}
		if($indywidualne){
			$txt .= '<b>Zycie </b>' . $indywidualneZycie . 'Majatek' . $indywidualneMajatek . 'OC zawodowe' . $indywidualneOC . '<br>';
		}
		if($komunikacja){
			$txt .= '<b>OC </b>' . $komunikacjaOC . 'AC' . $komunikacjaAC . 'Assistance' . $komunikacjaAss . '<br>';
		}
		mailsend($txt, "Wiadomość automatyczna formularza z servera '".$_SERVER['SERVER_NAME']."' z dnia ".date("Y-m-d").": ".$name.' '.$surname);
	}
	header("Content-Type: application/json; charset=utf-8");
	$result = json_encode($result);
	echo $result;
	die();
?>
