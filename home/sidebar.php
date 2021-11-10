<div class="col-xl-6 col order-first order-xl-last order-md-last">
    <form action="" method="get" class="">
        <input type="text"
               name="q"
               id="search"
               class="rounded-pill ps-4 barraNavegacion"
               autocomplete="off"
               placeholder="Buscar">
    </form>

    <div class="suggestions">
        <div class="border p-3">
            <p class="mb-3 bold">Quizá te interesé</p>
			<?php
			$query = "SELECT u.name, p.id, p.info, p.date, u.photo, u.email, u.id AS id_user FROM publicaciones p INNER JOIN usuarios u 
    ON u.id = p.id_user ORDER BY RAND() LIMIT 3";
			$result = $conexion->query($query);
			while ($randomPost = $result->fetch_assoc()) { ?>
                <div class="d-flex flex-column suggestion text-decoration-none">
                    <div class="d-flex">
                        <img src="<?php echo $randomPost['photo'] ?>" alt="" width="32" height="32"
                             class="rounded-circle pe-1">
                        <a class="profile pe-2"
                           href="profile.php?id=<?php echo $randomPost['id_user'] ?>">
							<?php echo $randomPost['name'] ?>
                        </a>
						<?php echo $randomPost['email'] ?>
                    </div>
                    <a href="post.php?id=
						<?php echo $randomPost['id']; ?>">
                        <p class="sidebar-info ps-3 pe-2">
							<?php echo $randomPost['info'] ?>
                        </p>
                    </a>
                    <p class="date-random pt-1">
						<?php echo $randomPost['date'] ?>
                    </p>
                </div>
				<?php
			} ?>
        </div>
        <div class="border p-3">
            <p class="bold">Quizá conozcas</p>
			<?php
			$query = "SELECT * FROM usuarios ORDER BY RAND() LIMIT 3;";
			$result = $conexion->query($query);
			while ($randomPost = $result->fetch_assoc()) {
				if ($randomPost['id'] != $_SESSION['id']) { ?>
                    <div class="pe-2 d-flex mt- w-100 suggestion mt-2">
                        <div class="pe-3">
                            <img src="<?php echo $randomPost['photo'] ?>" alt="" height="32" width="32"
                                 class="rounded-circle">
                        </div>
                        <div class="d-flex flex-column w-100">
                            <a class="me-3 mb-2" href="profile.php?id=<?php echo $randomPost['id'] ?>">
                                <p style="margin: 0; text-transform: uppercase" class="bold"><?php echo $randomPost['name']; ?></p>
                                <p class="email"
                                   style="margin: 0;"><?php echo $randomPost['email']; ?></p>
                            </a>
                        </div>
                    </div>
				<?php }
			} ?>
        </div>
    </div>
</div>