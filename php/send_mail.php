<?php
function send_mail($mail, $message, $subject)
{
	$to = $mail;
	$headers = 'From: admin@camagru.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $message, $headers);
}
?>
