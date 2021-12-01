<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
	header('Location: ../error/404.php');
	die();
}

include '../config/database.php';
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "SELECT * FROM publicaciones p INNER JOIN usuarios u ON p.id_user = u.id AND p.id = '$id'";
	$result = $conexion->query($query);
	if ($result->num_rows == 0)
		header('Location: ../error/404.php');
	$result = $result->fetch_assoc();

}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link rel="stylesheet" href="home.css">
    <title>Post</title>
</head>
<body onload="ajax();">
<div class="container pt-3">
    <div class="row">
		<?php include 'navigation.php'; ?>
        <div class="col">
            <div class="row p-3">
                <div>
                    <div class="d-flex pt-1 mb-3">
                        <a href="../index.php" class="pe-2 back d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-left"></i>
                            <p style="font-size: 18px; font-weight: bold" class="ps-1">Publicación</p>
                        </a>
                    </div>

                    <div class="d-flex ms-2 align-items-center">
                        <div class="me-2">
                            <img src="<?php echo $result['photo'] ?>" alt="" width="32"
                                 height="32" class="rounded-pill">
                        </div>

                        <a href="profile.php?id=<?php echo $result['id_user'] ?>">
                            <div>
                                <a href="profile.php?id=<?php echo $result['id_user'] ?>">
                                    <p class="visit profile">
										<?php echo $result['name'] ?>
                                    </p>
                                    <p style="font-size: 12px">
										<?php echo $result['email'] ?>
                                    </p>
                                </a>
                            </div>
                        </a>

                    </div>
                </div>

				<?php
				$query = "SELECT * FROM publicaciones p INNER JOIN usuarios u ON p.id_user = u.id AND p.id = '$id' 
                                                           AND u.id = '{$_SESSION['id']}'";
				if (isset($_GET['edit']) && $conexion->query($query)->num_rows) { ?>
                    <form action="edit.php" class="mt-3 ps-4" method="post">
                        <div class="d-flex flex-row">
                            <input type="text" hidden value="<?php echo $_GET['id'] ?>" name="id_publicacion">
                            <textarea class="form-control texto"
                                      maxlength="250"
                                      name="tweet"
                                      type="text"
                                      placeholder="¿Qué estas pensando?"><?php echo $result['info']; ?></textarea>
                            <input class="button mb-3 ms-2"
                                   type="submit"
                                   name="post"
                                   value="Editar">
                        </div>
                    </form>
					<?php
				} else { ?>
                    <div class="mt-3 ps-4">
                        <p><?php echo $result['info']; ?></p>
                        <p class="pt-3 datePost">
							<?php echo $result['date']; ?>
                        </p>
                    </div>
					<?php
				}
				?>
                <div class="pt-4 pb-4 d-flex ps-4 flex-column">
                    <div class="d-flex align-items-center">
                        <p class="pe-2"><?php echo $result['likes'] ?></p>
                        <p><?php echo $result['likes'] > 1 ? 'Me gustas' : 'Me gusta' ?></p>
                    </div>

                    <div class="d-flex flex-row pt-3 justify-content-between pe-3 ps-3 align-items-center">
                        <div class="icon-comment">
                            <a href=""><i class="far fa-comment icon-comment"></i></a>
                        </div>
                        <div class="icon-retuit">
                            <a href=""><i class="fas fa-retweet icon-retuit"></i></a>
                        </div>
                        <div>
                            <form action="like.php" method="post">
                                <input name="url" value="<?php
								$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
								echo $actual_link; ?>" hidden>
								<?php
								$query = "SELECT * FROM likes WHERE id_publicacion ='{$_GET['id']}'
									                                AND id_user = '{$_SESSION['id']}'";
								$likes = $conexion->query($query);
								?>
                                <button type="submit" class="like-button"
                                        style="background: #fff; border: none"
                                        name="like"
                                        value="<?php echo $_GET['id'] ?>">
									<?php if ($likes->num_rows) { ?>
                                        <div class="icon-heart">
                                            <i class="fas fa-heart icon-like"></i>
                                        </div>
									<?php } else { ?>
                                        <div class="icon-heart">
                                            <i class="far fa-heart"></i>
                                        </div>
									<?php } ?>
                                </button>
                            </form>
                        </div>
                        <div class="icon-comment">
                            <a href=""> <i class="fas fa-external-link-alt icon-comment"></i></a>
                        </div>
                    </div>
                </div>
				<?php if (!isset($_GET['edit'])) { ?>
                    <div class="">
                        <form method="post" action="">
                            <div class="d-flex">
                                <textarea class="form-control" name="response" placeholder="Tuitea tu respuesta"></textarea>
                                <button type="submit" name="comment" class="button ms-2">
                                    Comentar
                                </button>
                            </div>
                        </form>
                    </div>
					<?php
				}
				?>

				<?php
				if (isset($_POST['comment'])) {

					$id = uniqid();
					$idPost = $_GET['id'];
					$idUser = $_SESSION['id'];
					$message = $_POST['response'];

					$query = "INSERT INTO comentarios VALUES ('$id','$idPost','$idUser',now(),'$message')";
					$conexion->query($query);

					$query = "UPDATE publicaciones SET comments = comments + 1 WHERE id = '$idPost'";
					$conexion->query($query);
				} ?>
                <script>
                    const idPost = "<?php echo $_GET['id']?>";

                    function ajax() {
                        const request = new XMLHttpRequest();
                        request.onreadystatechange = function () {
                            if (request.status === 200 && request.readyState === 4) {
                                document.querySelector('.div-comments').innerHTML = request.responseText;
                            }
                        }
                        request.open("GET", `getComments.php?id=${idPost}`, true);
                        request.send();
                    }

                    setInterval(() => {
                        ajax();
                    }, 2000)
                </script>
                <div class="div-comments mt-4"></div>
            </div>
        </div>
		<?php include "sidebar.php"; ?>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/bc96b95e59.js" crossorigin="anonymous"></script>
<script src="../index.js"></script>
</html>