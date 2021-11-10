<?php
session_start();
include '../config/database.php';

$idUser = $_SESSION['id'];
$idPost = $_POST['id_post'];

$id = uniqid();
$query = "SELECT * FROM likes WHERE id_publicacion = '$idPost' AND id_user = '$idUser'";

if ($conexion->query($query)->num_rows == 0) {
    $query = "INSERT INTO likes VALUES('$id','$idPost', now(),'$idUser')";
    $result = $conexion->query($query);
    $query = "UPDATE publicaciones SET likes = likes + 1 WHERE id = '$idPost'";
} else {
    $query = "DELETE FROM likes WHERE id_publicacion = '$idPost'";
    $conexion->query($query);
    $query = "UPDATE publicaciones SET likes = likes - 1 WHERE id = '$idPost'";
}
$conexion->query($query);
