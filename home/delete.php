<?php
include '../config/database.php';

if(!$_POST['delete'] || !isset($_SESSION['id']) !== null) {
	header('location: ../index.php');
}


if (isset($_POST['delete'])) {
	$idPost = $_POST['id'];

	$query = "SELECT * FROM publicaciones p INNER JOIN usuarios u ON p.id_user = u.id AND p.id = '$idPost';";
	$result = $conexion->query($query);

	if (!isset($_SESSION['id']) || $result->num_rows == 0)
		header('location: ../session/login.php');

	$query = "DELETE FROM publicaciones WHERE id = '$idPost';";
	$result = $conexion->query($query);
	header('Location: home.php');
}