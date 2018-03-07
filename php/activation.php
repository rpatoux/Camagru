<?php
	session_start();
	include 'user.php';
	$user = $_GET['user'];
	$code = $_GET['code'];
	$mail = $_GET['mail'];
	$res = get_id_byuser_and_code($user, $code);
	if ($res && $code != NULL)
	{
		update_ok_user($user);
		update_code_user($user);
		$_SESSION['valid'] = 9;
	}
	header('Location:../accueil.php');
?>
