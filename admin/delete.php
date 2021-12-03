<?php
session_start();
include '../config/database.php';
if (!isset($_SESSION['id']) && $_SESSION['role'] != '1' || $_SESSION['role'] != '2') {
	header('location: ../session/login.php');
	die();
}
$id = $_POST['id'];
$query = "DELETE FROM usuarios WHERE id = '$id'";
$result = $conexion->query($query);
if ($result)
	header('Location: admin.php');