<?php
require '../database/connect_db.php';
include 'send_mail.php';
include 'check_new_user.php';
session_start();
$user = $_POST["user"];
$password = $_POST["password"];
$mail = $_POST['mail'];
$_SESSION['error'] = 0;
$_SESSION['valid'] = 0;
$url = $_POST['url'];
if (!$url)
	header('location:../accueil.php');
if ($user && $password && $mail)
{
	if (wrong_mail($mail) && wrong_user($user) && wrong_pass($password))
	{
		$password = hash('whirlpool', $_POST['password']);
		try
		{
			$query= $db->prepare("INSERT INTO user (user, mail, password, code, ok) VALUES (:user, :mail, :password, :code, :ok)");
			$code = rand(0, 5000000);
			$query->execute(array(':user' => $user, ':mail' => $mail, ':password' => $password, ':code' => $code, ':ok' => 0));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		$_SESSION['url'] = 'http://localhost:8080';
		$lien = $_SESSION['url'].'/php/activation.php?code='.$code.'&user='.$user.'&mail='.$mail;
		$message = 'Bonjour, veuillez cliquez sur ce lien ci-dessous pour activer votre compte '.PHP_EOL.$lien.PHP_EOL.'    Cordialement Camagru_staff.';
		$subject = "activation compte camagru";
		send_mail($mail, $message, $subject);
		$_SESSION['valid'] = 1;
		header('location:'.$url);
	}
	else
	{
		header('location:../accueil.php#register');
	}

}
else
{
	header('location:../accueil.php#register');
}
?>
