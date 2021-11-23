<?php
session_start();
include "../config/database.php";

if(!isset($_GET['id']) || !isset($_SESSION['id'])){
    header('location: ../index.php');
}

$query = "SELECT  u.name, c.message, u.photo, u.email, u.id, c.message, c.id_user, c.id_publicacion, c.id AS id_comentario, c.date
FROM usuarios u INNER JOIN comentarios c ON u.id = c.id_user 
    INNER JOIN publicaciones p ON c.id_publicacion = p.id AND p.id = '{$_GET['id']}' ORDER BY c.date DESC";
$comments = $conexion->query($query);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "SELECT * FROM publicaciones WHERE id = '$id'";
    $result = $conexion->query($query);

    if(!$result->num_rows) {
        echo 'error';
	    header('location: ../index.php');
        die();
    }

	$query = "SELECT * FROM publicaciones p INNER JOIN usuarios u ON p.id_user = u.id AND p.id = '$id'";
	$result = $conexion->query($query);
	$result = $result->fetch_assoc();
	if (!$result) {
		header('Location: ../home.php');
        die();
	}
}

while ($comment = $comments->fetch_assoc()) { ?>
    <div class="border p-3 d-flex flex-column justify-content-center">
        <div class="d-flex justify-content-between">
            <div class="d-flex">
                <img src="<?php echo $comment['photo'] ?>"
                     alt=""
                     width="32"
                     height="32"
                     class="rounded-pill">
                <div class="d-flex">
                    <a href="profile.php?id=<?php echo $comment['id_user'] ?>" class="d-flex">
                        <p class="ps-2 pe-2 profile">
							<?php echo $comment['name'] ?>
                        </p>
                        <p style="font-size: 14px">
							<?php echo $comment['email'] ?>
                        </p>
                    </a>
                </div>
            </div>
			<?php if ($result['id'] == $_SESSION['id'] || $_SESSION['id'] == $comment['id_user']) { ?>
                <div class="dropdown wrap">
                    <a class="d-flex align-items-center text-black-50 text-decoration-none dropdown-toggle posts-settings p-2 fas fa-cog"
                       id="optionsPosts"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                    </a>

                    <ul class="dropdown-menu"
                        aria-labelledby="optionsPosts">
                        <li>
                            <form action="delete-comment.php" method="post">
                                <input type="text" hidden name="id-comment"
                                       value="<?php echo $comment['id_comentario'] ?>">
                                <input type="text" hidden name="id-post"
                                       value="<?php echo $comment['id_publicacion'] ?>">
                                <input type="submit"
                                       class="dropdown-item"
                                       style="color: black"
                                       value="Eliminar" name="delete-comment">
                            </form>
                        </li>

                    </ul>
                </div>
			<?php } ?>
        </div>
        <div class="wrap pb-3 pt-3 d-flex justify-content-between">
            <p>
				<?php echo $comment['message'] ?>
            </p>
            <p>
				<?php echo $comment['date']; ?>
            </p>
        </div>
    </div>
	<?php
}
?>