<?php
session_start();
$url = $_SERVER[REQUEST_URI];
$mail = $_SESSION['mail'];
$url_2 = explode('/', $_SERVER[REQUEST_URI]);
$user = $_SESSION['user'];
if ($_SESSION['user'] != $user)
	header('location:accueil.php');
$t_url = $url_2[3].$url_2[4];
$_SESSION['url'] = 'http://localhost:8080'.'/'.$url_2[1].'/'.$url_2[2];
if ($url_2[2] == 'galerie.php' && $url_2[3])
	header('location:'.$_SESSION['url']);
?>

<html>
	<head>
		<meta charset="UTF-8" http-equiv="refresh" content="600" />
		<title>Camagru</title>
		<link rel="shortcut icon" type="image/jpg" href="../img/camagru.png">
		<link type="text/css" href="../css/accueil.css" media="all" rel="stylesheet"/>
	</head>
	<body onload="setTimeout(cacherDiv,2000);">
	<script>
	function cacherDiv()
	{
		if(document.getElementById("connec_ok"))
    		document.getElementById("connec_ok").style.visibility = "hidden";
	}
	</script>
	<?php
		if ($_SESSION["logged_on_user"])
			echo "Connected";
	?>
	<p><i><?php 
			$user = $_SESSION['user'];
			if ($user)
				echo '<a class="mycompte" href="mon_compte.php">Mon compte  : '.$user.'</a>';
		?></i></p>
		<center>
		<img width="150px" id= "logofond" src="../img/camagru_pdp.png">
			<div class="menu2">
				<ul>
					<li><a href="accueil.php">Accueil</a></li>
					<?php
						if ($_SESSION["logged_on_user"])
						{
							echo '<li><a href="disconnect.php">Deconnexion</a></li>';
							echo '<li><a href="photomaton.php">Photomaton</a></li>';
						}
						else
						{
							echo '<li><a href="#login">Connexion</a></li>';
							echo '<li><a href="#register">Inscription</a></li>';
						}
					?>
					<li><a id="on" href="#">Galerie</a></li>
				</ul>
			</div>
			<?php
				if ($_SESSION['succes_new_p'] == 1)
					echo '<br><div id="connec_ok">Votre mot de passe a ete réinitialiser</div>';
				if ($_SESSION['error_mail'] == 1)
					echo '<br><div id="need_connect">Ce mail n\'existe pas !</div>';
				if ($_SESSION['succes_mail'] == 1)
					echo '<br><div id="connec_ok">Un mail de reinitialisaton de mot de passe viens de vous être envoyé !</div>';
				if ($_SESSION['valid'] == 1)
					echo '<div id="connec_ok">Inscription enregistrée <br> Allez voir vos mails pour confirmer l\'inscription</div>';
				if ($_SESSION['valid'] == 2)
					echo '<div id="connec_ok">Connexion réussie</div>';
				if ($_SESSION['valid'] == 9)
					echo '<div id="connec_ok">Activation du compte Camagru confirmée</div>';
				$_SESSION['valid'] = 0;
				$_SESSION['error_mail'] = 0;
				$_SESSION['succes_mail'] = 0;
				$_SESSION['succes_new_p'] = 0;
			?>
			<div class="galerie" id="galerie">
				<div id="need_connect"></div><br>
				<?php
					include 'image.php';
					include 'user.php';

					$id = $_SESSION['logged_on_user'];
					$user = get_user_by_id($id);
					$res = list_image();
					$pdf = 0;
					$i = 0;
					if ($res)
					{
						while ($res[$i]['img'])
							$i++;
						$nbr = 0;
						$tmp = $i;

						while ($res[--$i]['img'] && ++$nbr && $i >= 0)
						{
							$img = $res[$i]['img'];
							$likes = get_likes_by_img($img);
							$user_likes = get_user_likes_by_img($img);
							$user_img = get_user_by_img($img);
							$id_img = get_id_img_by_img($img);
							if ($nbr > 2)
							{
								$pdf = 1;
								echo '<div class="shadow" id="ensemble_photo">';
							}
							else
								echo '<div class="ensemble_photo" id="ensemble_photo">';
							if ($user == 'root')
							{
								echo '<div class="button_supimg"><button type="submit" onclick="sub_img(this)">X</button></div>';
							}
							$date['img_date'] = get_date_by_img($img);
							echo '<div class=date>Publié par <b>'.$user_img.'</b> le '.$date['img_date'][0].'</div>';
									echo '<img class="pdp_img" src="'.$img.'">
									<br/>
									<div class="commentaire"><br>';
									if (!strpos($user_likes, $user))
									{
										echo '<input id="likee" class="like" type="submit" onclick="add_like(this)" value="J\'aime"/>';
									}
									else
									{
										echo '<input id="dislikee" class="dislike" type="submit" onclick="sub_like(this)" value="je n\'aime plus"/>';
									}
									echo '<br><div id="like">'.$likes.' Likes</div>
										<input class="text_write" type="text" id="texte" name="texte" onKeyPress="if(event.keyCode == 13) add_comment(this)";"/>
										<div id="comment" >';
							$j = 0;
							$nbr_com = 0;
							$comment = get_comment_by_id_img($id_img);
							if ($comment)
							{
								while ($comment[$j])
									$j++;
								while ($comment[--$j] && ++$nbr_com)
								{
									if ($nbr_com > 5)
									{
										echo '<div class="shadow" id="comentaire_photo">';
										if ($user == $comment[$j]['user'] || $user == 'root')
										{
											echo '<button class="button_supimg" id="'.$comment[$j]['id'].'" type="submit"  onclick="sub_commentaire(this)">X</button>';
										}
										echo '<b>'.$comment[$j]['user'].' :</b> '.$comment[$j]['comments'].'</div><br>';
									}
									else
									{
										echo '<div class="comentaire_photo" id="comentaire_photo">';
										if ($user == $comment[$j]['user'] || $user == 'root')
											echo '<button class="button_supimg2" id="'.$comment[$j]['id'].'" type="submit" onclick="sub_commentaire(this)">X</button>';
										echo '<b class="comentaire_photo">'.$comment[$j]['user'].' :</b> '.$comment[$j]['comments'].'</div><br>';
									}
								}
								if ($nbr_com > 3)
								{
									echo '<div class="comentaire_photo_2" ><a id="'.$i.'" onclick="plus_de_com(this)">plus de commentaires</a></div>';
								}
							}
							echo '			</div></div>
									<br></div>';
						}
						if ($pdf == 1)
						{
							echo '<a class="pdp" id="plus_de_photos" onclick="plus_de_photos(this)">  Plus de photos  </a>';
						}
					}
					else
						echo '<div class="no_public" >Aucune photo prise pour le moment, veuillez en prendre avec le Photomaton</div>';
				?>
			</div>
			<script src="../js/commentary.js"></script>

			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="login.php" method="post" target="_self">
					
						<h3>Connexion</h3>
						<div>
						<?php
							if ($_SESSION['error'] == 5)
								echo '<label id="wrong_login">  Mauvais mot de passe ou identifiant  </label><br><br>';
						?>
						<label>Identifiant : &nbsp;</label>
						<input type="text" placeholder="Entrez identifiant" name="user" required>
						<br><label>Mot de passe :&nbsp; </label>
						<input type="password" placeholder="Entrez mot de passe" name="password" required>
						<br><button class="signupbtn" class="btn" type="submit" value="OK">Me connecter</button>
						<br><br><a href="#code" type="button" id="mdpoub">Mot de passe oublié ?</a><br><br><br>
						<br><a href="" class="quit" type="button" id="cancelbtn">Fermer</a>
						<?php
						echo '<input style="display:none;" name="url" value="'.$url.'"/>';
						?>
					</div>
					</form>
				</div>
			</div>
			<div id="register" class="shadow">
			<div class="form">
				<form class="Inscription" action="register.php" method="post" target="_self">
					<h3>INSCRIPTION</h3>
					<?php
						if ($_SESSION['error'] == 1)
							echo '<label id="wrong_login">Mot de passe trop court 6 caracteres minimum</label><br><br>';
						if ($_SESSION['error'] == 2)
							echo '<label id="wrong_login">Identifiant déjà utilise</label><br><br>';
						if ($_SESSION['error'] == 3)
							echo '<label id="wrong_login">Mail déjà existant</label><br><br>';
						if ($_SESSION['error'] == 4)
							echo '<label id="wrong_login">Mail invalide</label><br><br>';
						if ($_SESSION['error'] == 5)
							echo '<label id="wrong_login">Votre identifiant ne doit contenir que des lettres</label><br><br>';
						if ($_SESSION['error'] == 6)
							echo '<label id="wrong_login">Votre identifiant ne doit contenir 10 caracteres maximum</label><br><br>';
						if ($_SESSION['error'] == 7)
							echo '<label id="wrong_login">Votre mot de passe ne doit contenir que des lettres et des chiffres</label><br><br>';
						$_SESSION['error'] = 0;
					?>
					<div>
						<label>Adresse Mail :</label>
						<input type="text" placeholder="Entrez votre mail" name="mail" required>
						<br><label>Identifiant : &nbsp;</label>
						<input type="text" placeholder="Entrez identifiant" name="user" required>
						<br><label>Mot de passe :&nbsp;</label>
						<input type="password" placeholder="Entrez mot de passe" name="password" required>
						<br><button class="signupbtn" type="submit" value="OK">M'inscrire</button>
							<br><a href="" class="quit" type="button" id="cancelbtn">Fermer</a>
						<?php
						echo '<input style="display:none;" name="url" value="'.$url.'"/>';
						?>
					</div>
				</form>
			</div>
		</div>
			<div id="code" class="shadow">
				<div class="form">
					<form class="code" action="forget_password.php" method="post" target="_self">
						<h3>Mot de passe oublie ?</h3>
						<div>
							<label>Adresse Mail : </label>
							<input type="text" placeholder="Entrez votre mail" name="mail" required>
							<button class="btn" type="submit" value="OK">Envoyer un mail</button>
              				<a href="galerie.php" class="quit">Fermer</a>
              				<?php
              				echo '<input style="display:none;" name="url" value="'.$url.'"/>';
              				?>
						</div>
					</form>
				</div>
			</div>
			<div id="main">
			<footer>
			<p id="phrase" align="right">Site crée par Robin Patoux - 2018</p>
			</footer>
           	</div>
		</center>
	</body>
</html>
