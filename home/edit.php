<?php
session_start();
include '../config/database.php';

if(!isset($_POST['tweet']) || !isset($_SESSION['id'])) {
	header('location: home.php');
}

if (isset($_POST['post'])) {
	$post = $_POST['tweet'];
	$id = $_POST['id_publicacion'];
	$userId = $_SESSION['id'];

	if (strlen($post) > 0) {
		$query = "UPDATE publicaciones SET info = '$post' WHERE id = '$id' AND id_user = '$userId'";
		$result = $conexion->query($query);
		header('Location: home.php');
	}
}