<?php
session_start();
//  if (!$_SESSION['code'])
// 	 header('location:../accueil.php');
 var_dump($_SESSION['code']);
$url_2 = explode('/', $_SERVER[REQUEST_URI]);
$t_url = $url_2[3].$url_2[4];
if (!file_exists($t_url))
{
	header('location:'.$_SESSION['url']);
}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Camagru</title>
		<link rel="shortcut icon" type="image/jpg" href="../img/camagru.png">
		<link type="text/css" href="../accueil.css" media="all" rel="stylesheet"/>
	</head>
	<body>
	<?php
		if ($_SESSION["logged_on_user"])
			echo "Connected";
	?>
	<p><i><?php 
			$user = $_SESSION['user'];
			if ($user)
				echo '<a href="mon_compte.php">user : '.$user.'</a>';
		?></i></p>
		<center>
		<img width="150px" id= "logofond" src="../img/camagru.png">
		<center>
			<div class="menu2">
				<ul>
					<li><a href="../accueil.php">Accueil</a></li>
					<?php
						if ($_SESSION["logged_on_user"])
						{
							echo '<li><a href="disconnect.php">Deconnexion</a></li>';
							echo '<li><a href="camera.php">Photomaton</a></li>';
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
			<div>
			<?php
				if ($_SESSION['error_new_p'] == 1)
					echo '<br><div id="need_connect">Les deux mots de passes ne sont pas identiques</div>';
				if ($_SESSION['error_new_p'] == 2)
					echo '<br><div id="need_connect">Le mot de passe est trop court, minimum 6 caracteres</div>';
				if ($_SESSION['error_new_p'] == 3)
					echo '<br><div id="need_connect">Le mot de passe doit contenir que des chiffres et des lettres</div>';
				$_SESSION['error_new_p'] = 0;
			?>
			<br><br><br><br>
				<div>
					<form class="reset_pass" action="reset_pass.php" method="post" target="_self">
						<h2 >Réinitialiser mon mot de passe</h2>
						<div>
							<label>Mot de passe : </label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<br><br><label>Répetez mot de passe : </label>
							<input type="password" placeholder="Entrez mot de passe" name="password2" required>
							<?php 
								$code = $_GET['code'];
								echo '<input style="display:none;" name="code" value="'.$code.'">';
							?>
							<br><br><button class="btn" type="submit" value="OK">Changer le mot de passe</button>
						</div>
					</form>
				</div>
			</div>
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="login.php" method="post" target="_self">
						<h3>Connexion</h3>
						<div>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="login" required>
							<label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<button class="btn" type="submit" value="OK">Go</button>
							<a href="#code">Mot de passe oublie ?</a>
              				<a href="#" class="quit">Fermer</a>
						</div>
					</form>
				</div>
			</div>
			<div id="register" class="shadow">
				<div class="form">
					<form class="Inscription" action="register.php" method="post" target="_self">
						<h3>Inscription</h3>
						<div>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="login" required>
							<label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<button class="btn" type="submit" value="OK">Go</button>
              				<a href="#" class="quit">Fermer</a>
						</div>
					</form>
				</div>
			</div>
			<div id="code" class="shadow">
				<div class="form">
					<form class="code" action="forget_password.php" method="post" target="_self">
						<h3>Mot de passe oublie ?</h3>
						<div>
							<label>Adresse Mail</label>
							<input type="text" placeholder="Entrez votre mail" name="mail" required>
							<button class="btn" type="submit" value="OK">Envoyer un mail</button>
              				<a href="#" class="quit">Fermer</a>
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
