<?php

session_start();
include '../config/database.php';

if (!isset($_SESSION['id']) || !isset($_POST['different-password'])) {
	header('location: ../index.php');
}

if (isset($_POST['different-password'])) {
	$differentPassword = $_POST['password'];
	$differentPassword2 = $_POST['password2'];

	$query = "SELECT password FROM usuarios WHERE id = '{$_SESSION['id']}'";
	$password =$conexion->query($query)->fetch_assoc()['password'];

	if ($password != $differentPassword) {
		header('Location: settings.php?password');
		die();
	}

	$differentPassword = trim($differentPassword);

	$id = $_SESSION['id'];
	$query = "UPDATE usuarios SET password='$differentPassword' WHERE id = '$id' ";
	$conexion->query($query);
	header('Location: settings.php?success');
}

