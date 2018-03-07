<?php
require '../database/connect_db.php';

session_start();

function wrong_password($password)
{
	if (strlen($password) < 6)
	{	
		$_SESSION['error_new_p'] = 2;
		return false;
	}
	if (preg_match('/^[a-zA-Z0-9]*$/', $password) == false)
	{
		$_SESSION['error_new_p'] = 3;
		return false;
	}
	return true;
}
$password = $_POST['password'];
$password2 = $_POST['password2'];
$code = $_SESSION['code'];
$url = $_POST['url'];
$_SESSION['error_new_p'] = 0;
$_SESSION['succes_new_p'] = 0;
if ($password && $password2 && $code)
{
	if ($password != $password2)
	{
		$_SESSION['error_new_p'] = 1;
		header('Location:reset_password.php');
	}
	else if (!wrong_password($password))
	{
		header('Location:reset_password.php');
	}
	else
	{
		$password = hash('whirlpool', $password);
		try{
			$query= $db->prepare('UPDATE user set password=:password WHERE code=:code');
			$query->execute(array(':password' => $password, ':code' => $code));
			$res = $query->rowCount();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage());
		}
		if ($res)
		{
			$_SESSION['code'] = 0;
			try{
				$query= $db->prepare('UPDATE user set code=:code WHERE password=:password');
				$query->execute(array(':code' => NULL, ':password' => $password));
			}
			catch(PDOException $e)
			{
				die("Erreur ! : ".$e->getMessage());
			}
			$_SESSION['succes_new_p'] = 1;
			header('Location:../accueil.php');
		}
		header('Location:../accueil.php');
	}
}
else
	header('Location:../accueil.php');
?>
