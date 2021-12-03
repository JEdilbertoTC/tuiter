<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['id']) || !isset($_POST['different-name'])) {
	header('location: ../session/login.php');
	die();
}

if (isset($_POST['different-name'])) {
	$differentName = $_POST['name'];

	$id = $_SESSION['id'];
	$query = "UPDATE usuarios SET name='$differentName' WHERE id = '$id' ";
	$conexion->query($query);
	$_SESSION['name'] = $differentName;
	header("location: settings.php");
	die();
}
