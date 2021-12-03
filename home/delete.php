<?php
session_start();
include '../config/database.php';

if(!isset($_POST['delete']) || !isset($_SESSION['id'])) {
	header('location: ../index.php');
	die();
}

if (isset($_POST['delete'])) {
	$idPost = $_POST['id'];

	$query = "SELECT * FROM publicaciones p WHERE p.id = '$idPost';";
	$result = $conexion->query($query);

	if (!isset($_SESSION['id']) || $result->num_rows == 0) {
		header('location: ../session/login.php');
		die();
	}

	$query = "DELETE FROM publicaciones WHERE id = '$idPost';";
	$result = $conexion->query($query);
	header('Location: home.php');
	die();
}