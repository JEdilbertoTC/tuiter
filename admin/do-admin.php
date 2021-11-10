<?php
session_start();
include '../config/database.php';
if (!isset($_SESSION['id']) && $_SESSION['role'] != '1')
	header('location: ../session/login.php');
$id = $_POST['id'];
$query = "UPDATE usuarios SET role = 1 WHERE id = '$id'";
$result = $conexion->query($query);
if ($result)
	header('Location: admin.php');