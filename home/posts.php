<?php
if (!isset($_SESSION['id'])) {
	header('Location: ../session/login.php');
}

if (isset($_GET['q'])) {
	$q = $_GET['q'];
	$query = "SELECT * FROM usuarios WHERE name LIKE '%$q%'";
	$relatedUsers = $conexion->query($query);

	$query = "SELECT u.name, u.email, u.photo AS photo, p.date, p.info, p.id AS id_publicacion, p.id_user, p.likes, p.comments
                FROM publicaciones p
                INNER JOIN usuarios u ON u.id = p.id_user AND p.info LIKE '%$q%' ORDER BY date DESC";
	$relatedPosts = $conexion->query($query);
	?>

    <div class="col">
        <div class="border">
            <a href="home.php" class="back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <p class="pb-3 ps-2" style="font-weight: 600; font-size: 18px">Personas</p>
			<?php while ($user = $relatedUsers->fetch_assoc()) { ?>
                <div class="d-flex flex-row pb-3 ps-2">
                    <div>
                        <img src="<?php echo $user['photo'] ?>" alt="" height="32" width="32" class="rounded-circle">
                    </div>
                    <a href="profile.php?id=<?php echo $user['id'] ?>">
                        <div class="d-flex flex-column ps-2">
                            <p class="visit"
                               style="font-weight: bold; text-transform: uppercase; font-size: 14px"><?php echo $user['name']; ?></p>
                            <p style="font-size: 12px"><?php echo $user['email']; ?></p>
                        </div>
                    </a>
                </div>
				<?php
			} ?>
            <div class="mt-4">
                <p class="pb-3 ps-2" style="font-weight: 600; font-size: 18px">Publicaciones</p>
				<?php while ($post = $relatedPosts->fetch_assoc()) { ?>
                    <div class="d-flex flex-column pb-2 ps-2">
                        <div class="d-flex">
                            <div>
                                <img src="<?php echo $post['photo'] ?>" alt="" width="32" height="32"
                                     class="rounded-circle">
                            </div>

                            <a class="d-flex align-items-center"
                               href="profile.php?id=<?php echo $post['id_user'] ?>">
                                <div class="d-flex ps-2">
                                    <p style="font-weight: bold; text-transform: uppercase; font-size: 14px"
                                       class="visit">
										<?php echo $post['name'] ?>
                                    </p>
                                    <p style="font-size: 12px">
										<?php echo $post['email'] ?>
                                    </p>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="pb-4 pe-3 ps-3 visitPost">
                        <a href="post.php?id=<?php echo $post['id_publicacion'] ?>">
                            <div class="d-flex flex-column">
                                <p><?php echo $post['info']; ?></p>
                            </div>
                        </a>
                    </div>

					<?php
				} ?>
            </div>
        </div>
    </div>

	<?php

} else { ?>
    <div class="col">
        <div class="cajaPublica">
            <div class="border pt-2 ps-3 pb-2">
                <p style="font-size: 24px; font-weight: bold">Inicio</p>
            </div>
            <div class="">
                <form class="cajaPublica" method="post">
                    <div class="border">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="<?php echo $_SESSION['photo'] ?>" alt="" width="32" height="32"
                                 class="rounded-circle mb-4 ms-2">
                            <textarea class="texto cajaPublica form-control"
                                      rows="3"
                                      name="tweet"
                                      maxlength="250"
                                      placeholder="¿Qué estas pensando?"></textarea>
                        </div>
                        <div class="d-flex justify-content-between pe-3 pt-3">
                            <div class="d-flex align-items-center ms-3">
                                <div>
                                    <i class="fas fa-photo-video"></i>
                                </div>
                                <div class="ms-3">
                                    <i class="fas fa-icons"></i>
                                </div>
                            </div>
                            <input class="button mb-3"
                                   type="submit"
                                   name="post"
                                   value="Publicar">
                        </div>
                    </div>
                </form>
				<?php
				if (isset($_POST['post'])) {
					$post = $_POST['tweet'];
					$userId = $_SESSION['id'];
					$id = uniqid();
					if (strlen($post) > 0) {
						$query = "INSERT INTO publicaciones VALUES('$id','$post', now(),'$userId', 0, 0)";
						$result = $conexion->query($query);
					}
				} ?>
            </div>
            <div id="div-posts">
				<?php
				$query = "SELECT u.name, u.email, u.photo AS photo, p.date, p.info, p.id AS id_publicacion, p.id_user, p.likes, p.comments
                FROM publicaciones p
                INNER JOIN usuarios u ON u.id = p.id_user ORDER BY date DESC";
				$posts = $conexion->query($query);
				if ($posts) {
					while ($post = $posts->fetch_assoc()) { ?>
                        <div class="pt-3 pb-3 ps-3 border <?php echo $post['id_publicacion'] ?> post pe-3 post-container">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <img src="<?php echo $post['photo'] ?>" alt="" width="32" height="32"
                                         class="rounded-circle">
                                    <a class="profile"
                                       href="profile.php?id=<?php echo $post['id_user'] ?>"><?php echo $post['name'] ?></a>
									<?php echo $post['email'] ?>
                                </div>
								<?php if ($_SESSION['id'] == $post['id_user'] || $_SESSION['role'] == '1') { ?>
                                    <div class="dropdown">
                                        <a class="d-flex align-items-center text-black-50 text-decoration-none dropdown-toggle posts-settings p-2 fas fa-cog"
                                           id="optionsPosts"
                                           data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="optionsPosts">
											<?php if ($post['id_user'] == $_SESSION['id']) { ?>
                                                <li>
                                                    <a href="post.php?id=<?php echo $post['id_publicacion'] ?>&edit"
                                                       class="dropdown-item" style="color: black">
                                                        Editar
                                                    </a>
                                                </li>
											<?php } ?>
                                            <li>
                                                <form action="delete.php" method="post">
                                                    <input type="text" hidden name="id"
                                                           value="<?php echo $post['id_publicacion'] ?>">
                                                    <input type="submit" class="dropdown-item" style="color: black"
                                                           value="Eliminar" name="delete">
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
								<?php } ?>
                            </div>
                            <div class="">
                                <div class="body">
                                    <div class="wrap info ps-4">
                                        <a href="post.php?id=<?php echo $post['id_publicacion']; ?>">
                                            <p id="pp-<?php echo $post['id_publicacion'] ?>"><?php echo $post['info']; ?></p>
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex ps-3 pt-3 flex-row justify-content-between align-items-center">
                                    <div class="d-flex flex-row">
                                        <div class="">
                                            <form action="like.php" method="post">
                                                <input name="url" value="<?php
												$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
												echo $actual_link; ?>" hidden>
												<?php
												$query = "SELECT * FROM likes WHERE id_publicacion ='{$post['id_publicacion']}'
                                AND id_user = '{$_SESSION['id']}'";
												$result = $conexion->query($query);
												?>
                                                <button type="submit" class="border-0 like-button"
                                                        style="background: #fff"
                                                        name="like"
                                                        value="<?php echo $post['id_publicacion'] ?>">
													<?php
													if ($result->num_rows) { ?>
                                                        <i class="fas fa-heart icon-like"></i>
													<?php } else { ?>
                                                        <i class="far fa-heart"></i>
													<?php }
													echo $post['likes'];
													?>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="comments ps-2">
                                            <div>
                                                <a href="post.php?id=<?php echo $post['id_publicacion'] ?>"
                                                   class="far fa-comment"
                                                   style="text-decoration: none; color: #000">
                                                </a>
                                            </div>
                                            <div class="ps-2">
												<?php echo $post['comments']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="date">
                                        <?php echo $post['date'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
					<?php }
				} ?>
            </div>

        </div>
    </div>
	<?php
} ?>