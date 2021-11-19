<?php
session_start();
include '../config/database.php';
$id = $_SESSION['id'];
if (isset($_POST['submit'])) {
	$directory = '/upload/';
	$upload = $directory . basename($_FILES['file']['name']);
	move_uploaded_file($_FILES['file']['tmp_name'], ".." . $upload);

	$query = "UPDATE usuarios SET photo = '$upload' WHERE id = '$id'";
	$correct = $conexion->query($query);

	if ($correct) {
		$_SESSION['photo'] = $upload;
		header('location: settings.php');
	}
}