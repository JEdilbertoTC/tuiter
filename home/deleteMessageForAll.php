<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_POST['delete-message-for-all'])) {
	header('Location: ../index.php');
}
include '../config/database.php';

if (isset($_POST['delete-message-for-all'])) {
	$id = $_POST['id-message'];
	$redirect = $_POST['redirect'];
	$query = "DELETE FROM mensajes WHERE id = '$id'";
	$conexion->query($query);
	header("Location: chat.php?id=$redirect");
}