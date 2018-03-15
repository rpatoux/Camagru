<?php
	session_start();
	include 'user.php';

	$mail = $_GET['mail'];
	$code = $_GET['code'];
	$res = select_id_user_from_mailandcode($mail, $code);
	if (code != NULL)
	{
		$_SESSION['code'] = $_GET['code'];
		header('location:reset_password.php');
	}
	 else
	 	header('location:accueil.php');
?>
