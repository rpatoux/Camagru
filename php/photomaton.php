<?php
	session_start(); 

	$url = $_SERVER[REQUEST_URI];
	$url_2 = explode('/', $_SERVER[REQUEST_URI]);
	$_SESSION['url'] = 'http://localhost:8080'.'/'.$url_2[1].'/'.$url_2[2];
	if ($_GET['erreur'] == "404")
	{
		echo ("Une erreur est survenue, vous avez ete rediriger vers la page d'acceuil"); 
	}

	if ($url_2[2] == 'photomaton.php' && $url_2[3])
		header('location:'.$_SESSION['url']);
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Camagru</title>
		<link rel="shortcut icon" type="image/jpg" href="../img/camagru.png">
		<link type="text/css" href="../css/accueil.css" media="all" rel="stylesheet"/>
	</head>
	<body>
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
			<div class="menu2" draggable="false">
				<ul>
					<li><a draggable="false" href="accueil.php">Accueil</a></li>
					<?php
						if ($_SESSION["logged_on_user"])
						{
							echo '<li><a  draggable="false" href="disconnect.php">Deconnexion</a></li>';
							echo '<li><a  id="on" draggable="false" href="">Photomaton</a></li>';
						}
						else
						{
							echo '<li><a  draggable="false" href="#login">Connexion</a></li>';
							echo '<li><a  draggable="false" href="#register">Inscription</a></li>';
						}
					?>
					<li><a  draggable="false" href="galerie.php">Galerie</a></li>
				</ul>
			</div>
			<div>
				<div class="image_montage">

				<?php 
					$all_file = scandir('../img');
					$i = 3;
					while ($all_file[$i])
					{
						echo '<div class="photo_bouton">
						<img src="../img/'.$all_file[$i].'" draggable="false" id="../img/'.$all_file[$i].'" onclick="define_source(\'../img/'.$all_file[$i].'\')">
					</div>';
					$i += 2;
					}
				?>
				</div>
				<br><br><br><br>
				<div class="shadow3" id="radio">
					<br><input type="radio" name="tail" value="100" onclick="get_size('100')">  SMALL
					<input type="radio" name="tail" value="150" onclick="get_size('150')">  LARGE
				</div>
				<div class="div_montage">
					<div class="montage" id="placehere">
					<?php 
						include 'image.php';
						include 'user.php';

						$id = $_SESSION['logged_on_user'];
						$user = get_user_by_id($id);
						$res = get_img_by_user($user);
						$i = 0;
						while ($res[$i]['img'])
						{
							$i++;
						}
						while ($res[--$i]['img'])
						{
							echo '<div class="button_supimg"><button type="submit" onclick="sub_img(this)">X</button>';
							echo '<img  draggable="false" src="'.$res[$i]['img'].'"></div><br>';
						}
					?>
					</div>
					<!-- s'il y a une camera -->
					<div id="container" class="container" style="display:none;">
						<div id="wrong">
						</div>
						<br><br>
						<?php
							if (strpos($_SERVER['HTTP_USER_AGENT'], "Android") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod") || strpos($_SERVER['HTTP_USER_AGENT'], "iPhone") )
								echo '<div class="cheat" id="cheat" onmousedown="drop(event)">';
							else
								echo '<div class="cheat" id="cheat" ondrop="drop(event)" ondragover="allowDrop(event)">';
						?>
							<div id="superpose">
								<img id="sup_img" class="sup_img_cur" draggable="true">
							</div>
							<video  autoplay ></video>
						</div>
						<div class="valide_photo">
							<canvas id="canvas"></canvas>
							<br/><button class="prendre" id="startbutton" name="photo" value="ok">Prendre une photo</button>
							<br><img id="photo">
							<br><button class="prendre" id="valide" >Publier</button>
						</div>
					</div>
					<!-- s'il n'y a pas de camera -->
					<div id="pas_de_cam">
						<div id="wrong2"></div>
						<?php
							if (strpos($_SERVER['HTTP_USER_AGENT'], "Android") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod") || strpos($_SERVER['HTTP_USER_AGENT'], "iPhone") )
								echo '<div class="cheat2" id="cheat2" onmousedown="drop2(event)">';
							else
								echo '<div class="cheat2" id="cheat2" ondrop="drop2(event)" ondragover="allowDrop2(event)">';
						?>
							<div id="superpose">
								<img class="sup_img_cur" id="sup_img_2">
							</div>
							<?php
								if ($_SESSION['photo'])
								{
									$file = $_SESSION['photo'];
									$img = getimagesize($file);
									if (file_exists('../upload/'.$file) && !empty($img[2]))
									{
										echo '<img id="photo_up" src="../upload/'.$file.'">';
										chmod('../upload/'.$file, 0755);
									}
									else 
									echo '<img id="photo_up" alt="votre photo">';
								}
								else
								{
									echo '<img id="photo_up" alt="votre photo">';
								}
							?>
						</div>
						<div class="valide_photo2">
							<canvas id="canvas2"></canvas>
							<br/><button id="startbutton2" name="photo" value="ok">Prendre une photo</button>
							<button id="upload_photo">Telecharger une image</button>
							<br><img id="photo2">
							<br><button id="valide2" >Publier</button>
						</div>
						<div id="up_form" class="shadow">
							<div class="form">
								<form method="POST" action="upload.php" enctype="multipart/form-data" class="up_form" name="form_nocam">	
									<h3> TELECHARGER UNE IMAGE </h3>
									<input type="file" name="up_photo">
									<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
									   <br><br>
									<button type="submit" id="send_photo" name="envoyer">Envoyer l'image</button>
									<br><br>
									<a href="" class="quit" type="button" id="cancelbtn">Fermer</a>
								</form> 
							</div>
						</div>
					</div>
				</div>
				<script src="../js/no_cam.js"></script>
				<script src="../js/cam.js"></script>
			</div>
			<br><br><br><br><br>
		<div>
			<footer>
				<p id="phrase" align="right">Site crée par Robin Patoux - 2018</p>
			</footer>
		</div>
		</center>
	</body>
</html>
