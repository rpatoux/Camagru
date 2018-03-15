<?php
	session_start(); 
	if (file_exists('../database/first_connection'))
	 {
	 	include("../database/setup.php");
		unlink('../database/first_connection');
	 	header('location:accueil.php');
	}
	$url = $_SERVER[REQUEST_URI];
	$url_2 = explode('/', $_SERVER[REQUEST_URI]);
	$_SESSION['url'] = 'http://localhost:8080'.'/'.$url_2[1].'/'.$url_2[2];
	if ($_GET['erreur'] == "404")
	{
		echo ("Une erreur est survenue, vous avez ete rediriger vers la page d'acceuil"); 
	}
	if ($url_2[2] == 'accueil.php' && $url_2[3])
		header('location:'.$_SESSION['url']);
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Camagru</title>
		<link rel="shortcut icon" type="image/jpg" href="../img/camagru.png">
		<link type="text/css" href="../css/accueil.css" media="all" rel="stylesheet"/>
	</head>
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
					<li><a id="on" href="">Accueil</a></li>
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
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="login.php" method="post" target="_self">
						<h3>CONNEXION</h3>
						<div>
							<?php
								if ($_SESSION['error'] == 5)
									echo '<label id="wrong_login">  Mauvais mot de passe ou identifiant  </label><br><br>';
							?>
							<label>Identifiant : &nbsp;</label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<br><label>Mot de passe :&nbsp; </label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<br><button class="signupbtn" type="submit" value="OK">Me connecter</button>
							<br><br><a href="#code" type="button" id="mdpoub">Mot de passe oublié ?</a><br><br><br>
							<br><a href="" class="quit" type="button" id="cancelbtn">Fermer</a>
							<?php
							echo '<input style="display:none;" name="url" value="'.$url.'"/>';
							?>
						</div>
					</form>
				</div>
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
			<div id="contenu">
				<p>Camagru est une application web qui permet de faire des montages photos directement depuis votre webcam</p><br>
				<p>Si vous n'avez pas de webcam, vous pouvez uploader les photos que vous souhaitez modifier</p><br>
				<b>Pour avoir accès au photomaton, commenter et liker les photos , vous devez être connecter</b><br><br>
				<p>L'inscription à l'application est finalisée par un mail de validation</p><br>
				<b>ENJOY</b>
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
								<br><a href="" class="quit" type="button" id="cancelbtn">Fermer</a>
							<?php
							echo '<input style="display:none;" name="url" value="'.$url.'"/>';
							?>
						</div>
					</form>
				</div>
			</div>
			<div>
				<footer>
					<p id="phrase" align="right">Site crée par Robin Patoux - 2018</p>
				</footer>
			</div>
		</center>
	</body>
</html>
