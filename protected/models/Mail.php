<?php

class Mail 
{
	public function __constructor()
	{
		
	}
	
	public static function sendEmail($data)
	{
		$mail = new YiiMailer();
		//use 'requestViewing' view from views/mail
		$mail->setView($data['view']);
		$mail->setData($data['mailData']);
		//render HTML mail, layout is set from config file or with $mail->setLayout('layoutName')
		$mail->render();
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing) // 1 = errors and messages // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = 'tls'; 				   // secure transfer enabled REQUIRED for GMail
		$mail->Host       = "smtp.gmail.com"; // sets the SMTP server
		$mail->Mailer 	  = "smtp";
		$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "your-email@gmail.com"; // SMTP account username
		$mail->Password   = "your-password";        // SMTP account password
		
		//set properties as usually with PHPMailer
		$mail->From = $data['fromEmail'];
		$mail->FromName = $data['fromName'];
		$mail->Subject = $data['subject'];
		foreach($data['toEmail'] as $toEmail)
			$mail->AddAddress($toEmail);
		$mail->AddBCC('parminder@tblmarketing.com');
		//send
		if ($mail->Send()) {
			$mail->ClearAddresses();
			return true;
		} else
			return false;
	}
}