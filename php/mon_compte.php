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
if ($url_2[2] == 'mon_compte.php' && $url_2[3])
	header('location:'.$_SESSION['url']);
?>
<html>
	<head>
		<meta charset="UTF-8" http-equiv="refresh" content="600" />
		<title>Camagru</title>
		<link rel="shortcut icon" type="image/jpg" href="../img/camagru.png">
		<link type="text/css" href="../css/accueil.css" media="all" rel="stylesheet"/>
	</head>
	<body>
	<?php
		if ($_SESSION["logged_on_user"])
			echo "Connected";
	?>
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
					<li><a href="galerie.php">Galerie</a></li>
				</ul>
			</div>
			<br><br>
			<div class="moncompte" id="moncompte">
			<?
				$user = $_SESSION['user'];
				echo '<h1>Bienvenue '.$user.'</h1><br>';
			?>
			<br><br>
				<h2>CHANGER MON MOT DE PASSE</h2>
				<form  action="new_mdp.php" method="post" target="_self" onsubmit="return confirm('Etes-vous sur de vouloir changer votre mot de passe ?');">
					<div class="nouveau_pass">
						<?php
							if ($_SESSION['error_np'] == 1)
								echo '<div class="error_mc" >Ancien mot de passe Mauvais</div><br>';
							if ($_SESSION['error_np'] == 2)
								echo '<div class="error_mc" >Les nouveaux mots de passes sont differents</div><br>';
							if ($_SESSION['error_np'] == 3)
								echo '<div class="error_mc" >le nouveau mot de passe doit faire 6 caracteres minimum</div><br>';
							if ($_SESSION['error_np'] == 4)
								echo '<div class="error_mc" >Le nouveau mot de passe doit contenir que des lettres et des chiffres</div><br>';
							if ($_SESSION['error_np'] == 5)
								echo '<div class="error_mc" >Le nouveau mot de passe doit etre different de l ancien</div><br>';
							if ($_SESSION['succes'] == 1)
								echo '<div class="color-font" >Le mot de passe a ete change, félicitation</div><br>';
							$_SESSION['error_np'] = 0;
							$_SESSION['succes'] = 0;
						?>
						<label class="color-font">Ancien mot de passe : </label>
						<input type="password" placeholder="Ancien mot de passe" name="ancien_pass" required/>
						<br><br><label class="color-font">Nouveau Mot de passe : </label>
						<input type="password" placeholder="Nouveau mot de passe" name="new_pass" required/>
						<br><br><label class="color-font">Repetez le nouveau mot de passe : </label>
						<input type="password" placeholder="Répétez mot de passe" name="new_pass_2" required/>
						<br><br><button class="button_sup4" type="submit" value="OK">Changer le mot de passe</button>
					</div>
				</form>
				<br><h2>CHANGER MON IDENTIFIANT</h2>
				<form  action="new_identifiant.php" method="post" target="_self" onsubmit="return confirm('Etes-vous sur de vouloir changer votre identifiant ?');">
					<div class="nouveau_pass">
					<?php
							if ($_SESSION['error_ni'] == 1)
								echo '<div class="error_mc" >Identifiant déjà existant</div><br>';
							if ($_SESSION['error_ni'] == 2)
								echo '<div class="error_mc" >l\'identifiant doit contenir que des lettres</div><br>';
							if ($_SESSION['error_ni'] == 3)
								echo '<div class="error_mc" >L\'identifiant doit faire 10 caractères au maximum</div><br>';
							if ($_SESSION['succes_ni'] == 1)
								echo '<div class="color-font" >L\'identifiant a ete change, félicitation</div><br>';
							if ($_SESSION['error_ni_ad'] == 1)
								echo '<div class="error_mc" >Le compte root ne peut pas être modifier</div><br>';
							$_SESSION['error_ni_ad'] = 0;
							$_SESSION['error_ni'] = 0;
							$_SESSION['succes_ni'] = 0;
						?>
						<label class="color-font" id="change" >Ancien identifiant : </label>
						<?php 
							echo '<input type="identifiant" name="ancien_ident" value="'.$user.'"readonly>';
						?>
						<br><br><label class="color-font">Nouvel identifiant : </label>
						<input type="identifiant" placeholder="Nouvel identifiant" name="new_ident" required>
						<br><br><button class="button_sup4" type="submit" value="OK">Changer mon identifiant</button>
					</div>
				</form>
				<br><h2>CHANGER MON ADRESSE MAIL</h2>
				<form  action="new_mail.php" method="post" target="_self" onsubmit="return confirm('Etes-vous sur de vouloir changer votre mail ?');">
					<div class="nouveau_pass">
					<?php
							if ($_SESSION['error_nm'] == 1)
								echo '<div class="error_mc" >Mail deja existant</div><br>';
							if ($_SESSION['error_nm'] == 2)
								echo '<div class="error_mc" >Format du mail invalide</div><br>';
							if ($_SESSION['succes_nm'] == 1)
								echo '<div class="color-font" >Votre mail a ete change, felicitation</div><br>';
							$_SESSION['error_nm'] = 0;
							$_SESSION['succes_nm'] = 0;
						?>
						<label class="color-font">Ancienne adresse mail : </label>
						<?php 
							echo '<input type="mail" name="ancien_ident" value="'.$mail.'"readonly>';
						?>
						<br><br><label class="color-font">Nouvelle adresse mail : </label>
						<input type="mail" placeholder="Nouvelle adresse mail" name="new_mail" required>
						<br><br><button class="button_sup4" type="submit" value="OK">Changer mon adresse mail</button>
					</div>
				</form>
				<?php
					if ($user != 'root')
					{?>
				<br><h2>SUPPRIMER MON COMPTE</h2>
					<div class="nouveau_pass">
				<?php
							if ($_SESSION['error_su'] == 1)
								echo '<div class="error_mc" >Vous ne pouvez pas supprimer le compte ADMIN</div><br>';
							$_SESSION['error_su'] = 0;
							?>
						<form  action="delete_compte.php" method="post" target="_self" onsubmit="return confirm('Etes-vous sur de vouloir supprimer votre compte ?');">
							<button class="button_sup3" type="submit" value="OK">Supprimer mon compte</button>
						</form>
					</div>
					<?}?>
				<?php
					if ($user == 'root')
					{?>
						<br><h2>SUPPRIMER UN COMPTE</h2>
						<div class="nouveau_pass">
						<?php
						if ($_SESSION['error_ad'] == 1)
							echo '<div class="error_mc" >Vous ne pouvez pas supprimer le compte ADMIN</div><br>';
						if ($_SESSION['error_ad'] == 2)
							echo '<div class="error_mc" >Le compte que vous voulez supprimer n\'existe pas</div><br>';
						if ($_SESSION['succes_ad'] == 1)
							echo '<div class="color-font" >Le compte vient d\'etre supprime, felicitation</div><br>';
						$_SESSION['error_ad'] = 0;
						$_SESSION['succes_ad'] = 0;
						?>
						<form  action="compte_admin.php" method="post" target="_self" onsubmit="return confirm('Etes-vous sur de vouloir supprimer ce compte ?');">
							<input type="identifiant" placeholder="compte a Supprimer" name="compte" required>
							<br>
							<button class="button_sup3" type="submit" value="OK">Supprimer un compte</button>
						</form>
					</div>
					<?}?>
			</div>
			<br><br><br><br>
			<br><br><br><br>
			<div id="main">
			<footer>
				<p id="phrase" align="right">Site crée par Robin Patoux - 2018</p>
			</footer>
           	</div>
		</center>
	</body>
</html>
