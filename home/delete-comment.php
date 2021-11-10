<?php
include '../config/database.php';

if (isset($_POST['delete-comment'])) {
	$idComment = $_POST['id-comment'];
	$idPost = $_POST['id-post'];

	$query = "DELETE FROM comentarios WHERE id = '$idComment';";
	$result = $conexion->query($query);

	$query = "UPDATE publicaciones SET comments = comments - 1 WHERE id = '$idPost'";
	$result = $conexion->query($query);

	header("Location: post.php?id=$idPost");
}
