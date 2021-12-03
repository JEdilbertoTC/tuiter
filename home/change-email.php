<?php
session_start();
include '../config/database.php';

if (isset($_POST['different-email'])) {
	$differentEmail = $_POST['email'];
	$id = $_SESSION['id'];
	$differentEmail = trim($differentEmail);

	if (!$differentEmail) {
        header('location: settings.php?error');
		die();
	}

	$query = "SELECT email FROM usuarios WHERE id = '$id' ";
	$correct = $conexion->query($query)->fetch_assoc();

	if ($differentEmail == $correct['email']) {
		header('location: settings.php?same');
        die();
	}

	$query = "SELECT email FROM usuarios WHERE email = '$differentEmail'";

	if ($conexion->query($query)->num_rows) {
        header('location: settings.php?other');
		die();
	}

	$query = "UPDATE usuarios SET email='$differentEmail' WHERE id = '$id' ";
	$conexion->query($query);
	$_SESSION['email'] = $differentEmail;
	header('Location: settings.php');
}