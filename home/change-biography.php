<?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['id']) || !isset($_POST['different-biography'])) {
	header('location: ../session/login.php');
	die();
}

if (isset($_POST['different-biography'])) {
	$biography = $_POST['biography'];
	$id = $_SESSION['id'];
	$query = "UPDATE usuarios SET biography='$biography' WHERE id = '$id' ";
	$conexion->query($query);
	header('Location: settings.php');
	die();
}