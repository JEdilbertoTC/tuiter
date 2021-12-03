<?php
include '../config/database.php';
session_start();

$userId = $_GET['id'];
$query = "SELECT * FROM usuarios WHERE id = '$userId'";
$user = null;
if ($conexion->query($query)->num_rows == 1) {
	$user = $conexion->query($query)->fetch_assoc();
	$query = "SELECT * FROM publicaciones p WHERE p.id_user = '$userId' ORDER BY date DESC";
	$posts = $conexion->query($query);
} else
	header('Location: ../error/404.php');
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
    <link href="profile.css" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <link rel="icon" href="../public/twitter_bird.ico" type="image/x-icon">
    <title> <?php echo $user['name'] ?></title>
</head>
<body>
<div class="container">
    <div class="row">

		<?php
		if (isset($_SESSION['id'])) {
			include "../home/navigation.php";
		}
		?>
        <div class="col">
            <div class="panel profile-cover">
                <div class="profile-cover__img">
                    <img style="height: 110px" src="<?php echo $user['photo']; ?>" alt="">
                    <h3 class="h3"><?php echo $user['name'] ?></h3>
                </div>
                <div class="profile-cover__action bg--img">
					<?php if (!isset($_SESSION['id']) || $_SESSION['id'] != $user['id']) { ?>
                        <button class="btn btn-rounded btn-info">
                            <i class="fa fa-comment"></i>
                            <span><a href="chat.php?id=<?php echo $user['id'] ?>"
                                     style="text-decoration: none; color: #fff">Mensaje</a></span>
                        </button>
						<?php
					} else { ?>
                        <button class="btn btn-rounded" style="cursor: default; border: none; outline: none">
                            <span></span>
                        </button>
						<?php
					}
					?>
                </div>
                <div class="profile-cover__info">
                    <ul class="nav">
						<?php echo $user['biography'] ?>
                    </ul>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading" style="border-bottom: rgb(0, 172, 238) 1px solid;">
                    <h3 class="panel-title mt-5">Publicaciones</h3>
                </div>
                <ul class="panel-activity__list">
					<?php while ($post = $posts->fetch_assoc()) { ?>
                        <li>
                            <div class="activity__list__header d-flex justify-content-between">
                                <div>
                                    <img src="<?php echo $user['photo'] ?>" alt=""
                                         style="height: 36px; margin-left: 1%;"/>
                                    <a href="profile.php?id=<?php echo $userId ?>"
                                       class="text-uppercase user ps-2"><?php echo $user['name'] ?></a>
                                </div>
								<?php
								if (isset($_SESSION['id'])) {
									if ($post['id_user'] == $_SESSION['id']) { ?>
                                        <div class="dropdown circle-settings">
                                            <a class="d-flex align-items-center text-black-50 text-decoration-none dropdown-toggle posts-settings p-2 fas fa-cog"
                                               id="optionsPosts"
                                               data-bs-toggle="dropdown"
                                               aria-expanded="false">
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="optionsPosts">
                                                <li>
                                                    <a href="../home/post.php?id=<?php echo $post['id'] ?>&edit"
                                                       class="dropdown-item" style="font-weight: normal; color: black">
                                                        <i class="far fa-edit"></i>Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="delete.php" method="post">
                                                        <input type="text" hidden name="id"
                                                               value="<?php echo $post['id'] ?>">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <i class="far fa-trash-alt icon-trash"></i>
                                                            <input style="color: red"
                                                                   type="submit"
                                                                   class="dropdown-item"
                                                                   value="Eliminar"
                                                                   name="delete">
                                                        </div>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
										<?php
									}
								}
								?>


                            </div>
                            <div class="activity__list__body entry-content ms-3">
                                <p>
									<?php echo $post['info']; ?>
                                </p>
                            </div>
                            <div class="activity__list__footer">
								<?php
								$query = "SELECT * FROM likes WHERE id_publicacion ='{$post['id']}'";
								if (isset($_SESSION['id'])) {
									$query = "SELECT * FROM likes WHERE id_publicacion ='{$post['id']}'
                                AND id_user = '{$_SESSION['id']}'";
								}
								$result = $conexion->query($query);
								$query = "SELECT * FROM publicaciones WHERE id = '{$post['id']}'";
								$count = $conexion->query($query)->fetch_assoc();
								?>
                                <form action="like.php" method="post">
                                    <input name="url" value="<?php
									$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									echo $actual_link; ?>" hidden>
                                    <a type="submit"></a>
                                    <button type="submit" name="like" value="<?php echo $post['id'] ?>"
                                            class="like circle-heart">
										<?php if ($result->num_rows) { ?>
                                            <i class="fas fa-heart icon-like"></i>
										<?php } else { ?>
                                            <i class="far fa-heart"></i>
										<?php } ?>
										<?php echo $count['likes']; ?>
                                    </button>
                                </form>
                                <a href="post.php?id=<?php echo $post['id'] ?>" class="comment circle-comment">
                                    <i class="fas fa-comment"></i>
									<?php echo $count['comments']; ?>
                                </a>
                                <span><?php echo $post['date'] ?></span>
                            </div>
                        </li>
						<?php
					}
					?>
                </ul>

            </div>
        </div>
    </div>
</div>
</body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/bc96b95e59.js" crossorigin="anonymous"></script>
<script src="../index.js"></script>
</html>