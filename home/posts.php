<?php

if (isset($_GET['q'])) {
	$q = $_GET['q'];
	$query = "SELECT * FROM usuarios WHERE name LIKE '%$q%'";
	$relatedUsers = $conexion->query($query);

	$query = "SELECT u.name, u.email, u.photo AS photo, p.date, p.info, p.id AS id_publicacion, p.id_user, p.likes, 
       p.comments FROM publicaciones p INNER JOIN usuarios u ON u.id = p.id_user AND p.info LIKE '%$q%' ORDER BY date DESC";
	$relatedPosts = $conexion->query($query);
	?>

    <div class="col container-inicio">
        <div class="border p-1">
            <a href="home.php" class="back d-flex align-items-center pt-2 ps-2">
                <i class="fas fa-arrow-left"></i>
                <p style="font-weight: 600; font-size: 18px" class="ps-2">Inicio</p>
            </a>
            <p class="ps-2 pt-4 pb-2" style="font-weight: 600; font-size: 18px">Personas</p>
			<?php while ($user = $relatedUsers->fetch_assoc()) { ?>
                <a class="d-flex flex-row pb-3 ps-2 suggestion" href="profile.php?id=<?php echo $user['id'] ?>">
                    <div>
                        <img src="<?php echo $user['photo'] ?>" alt="" height="32" width="32" class="rounded-circle">
                    </div>
                    <div class="d-flex flex-column ps-2">
                        <p class="visit"
                           style="font-weight: bold; text-transform: uppercase; font-size: 14px"><?php echo $user['name']; ?></p>
                        <p style="font-size: 12px"><?php echo $user['email']; ?></p>
                    </div>
                </a>
				<?php
			}
			?>
            <div class="mt-4">
                <p class="pb-2 ps-2" style="font-weight: 600; font-size: 18px">Publicaciones</p>
				<?php while ($post = $relatedPosts->fetch_assoc()) { ?>
                    <div class="d-flex flex-column pb-2 ps-2 suggestion">
                        <div class="d-flex">
                            <div>
                                <img src="<?php echo $post['photo'] ?>" alt="" width="32" height="32"
                                     class="rounded-circle">
                            </div>

                            <a class="d-flex align-items-center"
                               href="profile.php?id=<?php echo $post['id_user'] ?>">
                                <div class="d-flex ps-2">
                                    <p class="visit bold" style="text-transform: uppercase">
										<?php echo $post['name'] ?>
                                    </p>
                                    <p class="ps-1">
										<?php echo $post['email'] ?>
                                    </p>
                                </div>
                            </a>
                        </div>

                        <a href="post.php?id=<?php echo $post['id_publicacion'] ?>">
                            <div class="pb-4 pe-3 ps-5">
                                <p><?php echo $post['info']; ?></p>
                                <p class="date-random" style="text-align: right"><?php echo $post['date'] ?></p>
                            </div>
                        </a>

                    </div>
					<?php
				}
				?>
            </div>
        </div>
    </div>

	<?php

} else { ?>
    <div class="col">
        <div class="posts-container">
            <div class="border ps-3">
                <p style="font-size: 30px; font-weight: bold">Inicio</p>
            </div>
			<?php if (isset($_SESSION['id'])) { ?>
                <div class="">
                    <form method="post">
                        <div class="border">
                            <div class="d-flex justify-content-center align-items-center pt-1 pe-1">
                                <img src="<?php echo $_SESSION['photo'] ?>" alt="" width="32" height="32"
                                     class="rounded-circle mb-4 ms-2">
                                <textarea class="posting form-control"
                                          rows="3"
                                          name="tweet"
                                          maxlength="250"
                                          placeholder="¿Qué estas pensando?" style="padding-top: 5%;"></textarea>
                            </div>
                            <div class="d-flex justify-content-between pe-3 pt-3">
                                <div class="d-flex align-items-center ms-3">
                                    <div>
                                        <i class="fas fa-photo-video icon-index"></i>
                                    </div>
                                    <div class="ms-3">
                                        <i class="fas fa-icons icon-index"></i>
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
					}
					?>
                </div>

				<?php
			}
			?>
            <div id="div-posts">
				<?php
				$query = "SELECT u.name, u.email, u.photo AS photo, p.date, p.info, p.id AS id_publicacion, p.id_user, p.likes, p.comments FROM publicaciones p INNER JOIN usuarios u ON u.id = p.id_user ORDER BY date DESC";
				$posts = $conexion->query($query);
				if ($posts) {
					while ($post = $posts->fetch_assoc()) { ?>
                        <div class="pt-3 pb-3 ps-3 border <?php echo $post['id_publicacion'] ?> post pe-3 post-container">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex justify-content-between align-items-center">
                                    <img src="<?php echo $post['photo'] ?>" alt="" width="32" height="32"
                                         class="rounded-circle">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a class="profile"
                                           href="profile.php?id=<?php echo $post['id_user'] ?>"><?php echo $post['name'] ?>
                                        </a>
										<?php echo $post['email'] ?>
                                    </div>
                                </div>
								<?php
								if (isset($_SESSION['id'])) {
									if ($_SESSION['id'] == $post['id_user'] || $_SESSION['role'] >= '1') { ?>
                                        <div class="dropdown circle-settings">
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
                                                            <i class="far fa-edit"></i> Editar
                                                        </a>
                                                    </li>
												<?php } ?>
                                                <li>
                                                    <form action="delete.php" method="post">
                                                        <input type="text" hidden name="id"
                                                               value="<?php echo $post['id_publicacion'] ?>">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <i class="far fa-trash-alt icon-trash"></i>
                                                            <input type="submit" class="dropdown-item"
                                                                   style="color: red"
                                                                   value="Eliminar" name="delete">
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
                            <div class="">
                                <div class="body">
                                    <div class="wrap info ps-4">
                                        <a href="post.php?id=<?php echo $post['id_publicacion']; ?>">
                                            <p id="pp-<?php echo $post['id_publicacion'] ?>">
												<?php echo $post['info']; ?>
                                            </p>
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
												$query = "SELECT * FROM likes WHERE id_publicacion ='{$post['id_publicacion']}'";
												if (isset($_SESSION['id'])) {
													$query = "SELECT * FROM likes WHERE id_publicacion ='{$post['id_publicacion']}' AND id_user = '{$_SESSION['id']}'";
												}
												$result = $conexion->query($query);
												?>
                                                <button type="submit" class="border-0 like-button circle-heart"
                                                        name="like"
                                                        value="<?php echo $post['id_publicacion'] ?>">
													<?php
													if (isset($_SESSION['id'])) {
														if ($result->num_rows) { ?>
                                                            <i class="fas fa-heart icon-like"></i>
														<?php } else { ?>
                                                            <i class="far fa-heart"></i>
														<?php }
													}
													echo $post['likes'];
													?>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="comments ps-2">
                                            <div>
                                                <a href="post.php?id=<?php echo $post['id_publicacion'] ?>"
                                                   class="far fa-comment comments circle-comment"
                                                   style="text-decoration: none; color: #000;">
													<?php echo $post['comments']; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="date">
                                        <?php echo $post['date'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
						<?php
					}
				}
				?>
            </div>
        </div>
    </div>
	<?php
}
?>