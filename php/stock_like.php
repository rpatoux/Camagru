<?php
session_start();
require '../database/connect_db.php';
include 'image.php';

if (isset($_POST['img']) && isset($_POST['add']))
{
	$user = $_SESSION['user'];
	$add = $_POST['add'];
	$img = $_POST['img'];
	$user_likes = get_user_likes_by_img($img);
	$likes = get_likes_by_img($img);
	$id = get_id_img_by_img($img);
	// echo ($user);
	// echo "\n";
	// echo ($add);
	// echo "\n";
	// echo ($img);
	// echo "\n";
	// echo ($user_likes);
	// echo "\n";
	// echo ($likes);
	// echo "\n";
	// echo ($id);
	// exit;
	if ($user)
	{
		if (!preg_match('/;'.$user.';/', $user_likes) && $add == '1')
		{
			$user_likes = ';'.$user.';'.$user_likes;
			$likes += 1;
			try{
			$query= $db->prepare('UPDATE image set likes=:likes, user_likes=:user_likes WHERE id=:id');
			$query->execute(array(':likes' => $likes, ':user_likes' => $user_likes, ':id' => $id));
			}
			catch(PDOException $e)
			{
				die("Erreur ! : ".$e->getMessage() );
			}
			echo "$likes";
		}
		else if (preg_match('/;'.$user.';/', $user_likes) && $add == '0')
		{
			$user_likes = str_replace(' ', '', $user_likes);
			$user_likes = str_replace(';'.$user.';', '', $user_likes);
			$likes -= 1;
			try{
			$query= $db->prepare('UPDATE image set likes=:likes, user_likes=:user_likes WHERE id=:id');
			$query->execute(array(':likes' => $likes, ':user_likes' => $user_likes, ':id' => $id));
			}
			catch(PDOException $e)
			{
				die("Erreur ! : ".$e->getMessage() );
			}
			echo "$likes";
		}
	}
	else
		echo "no";
}
?>
