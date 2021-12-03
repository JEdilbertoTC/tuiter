<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_POST['delete-message-for-me'])) {
	header('Location: ../index.php');
	die();
}
include '../config/database.php';
if (isset($_POST['delete-message-for-me'])) {
	$idChat = $_POST['id_chat'];
	$user = $_POST['user'];
	$chat = $_POST['redirect'];
	$idMessage = $_POST['id_message'];

	$query = "DELETE FROM mensajes WHERE id_chat = '$idChat' AND id_user = '$user' AND id = '$idMessage'";
	$conexion->query($query);
	header("Location: chat.php?id=$chat");
	die();
}
