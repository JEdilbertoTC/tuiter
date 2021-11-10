<?php
include '../config/database.php';

if(!isset($_SESSION['id']))
	header('location: ../session/login.php');

if (isset($_POST['delete'])) {
    $idPost = $_POST['id'];
    $query = "DELETE FROM publicaciones WHERE id = '$idPost';";
    $result = $conexion->query($query);
    header('Location: home.php');
}