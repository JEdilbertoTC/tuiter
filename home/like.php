<?php
session_start();
include '../config/database.php';
if (isset($_POST['like']) && isset($_SESSION['id'])) {
	$idUser = $_SESSION['id'];
	$idPost = $_POST['like'];
	$id = uniqid();
	$url = $_POST['url'];

	$query = "SELECT id_publicacion FROM likes WHERE id_publicacion = '$idPost' AND id_user = '$idUser'";
	$result = $conexion->query($query);
	if ($result->num_rows == 0) {
		$query = "INSERT INTO likes VALUES('$id','$idPost', now(),'$idUser')";
		$conexion->query($query);
		$query = "UPDATE publicaciones SET likes = likes + 1 WHERE id = '$idPost'";

	} else {
		$query = "DELETE FROM likes WHERE id_publicacion = '$idPost'";
		$conexion->query($query);
		$query = "UPDATE publicaciones SET likes = likes - 1 WHERE id = '$idPost'";
	}
	$conexion->query($query);
	header("Location: {$url}");
}