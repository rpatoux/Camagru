<?php
require '../database/connect_db.php';
include 'photo.php';
include 'image.php';
include 'user.php';

session_start();
$id = $_SESSION['logged_on_user'];
// var_dump($_POST['data']);
// var_dump($_POST['source']);
// var_dump($_POST['value']);
// var_dump($_POST['name']);
if(isset($_POST['data']) && isset($_POST['source']) && isset($_POST['value']) && isset($_POST['name']))
{
	
	$x = $_POST['x'];
	$y = $_POST['y'];
	$data= $_POST["data"];
	$source = $_POST['source'];
	$valide = $_POST['value'];
	var_dump($valide);
	$url_img = $_POST['name'];

	if ($valide == '0')
	{
		echo " coucou1";
		$url_img = create_url('.png');
		$img = decode_data($data);
		new_dir('../montage');
		write_to_file($url_img, $img);
	}
	if ($valide == '1')
	{
		echo " coucou2";
		$user = get_user_by_id($id);
		add_image($user, $url_img);
	}
	else
	{
		echo " coucou3";
		write_png_to_photo($source, $url_img, $x, $y);
	}
	if ($valide == '3' && $data == 1)
		unlink($url_img);
	echo $url_img;
}
?>
