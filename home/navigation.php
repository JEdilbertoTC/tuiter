<?php if (!isset($_SESSION['id'])) {
	header('location: ../index.php');
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light order-first sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../home/home.php"> <i class="fab fa-twitter icon-bird"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
				<?php if ($_SESSION['role'] >= '1') { ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../admin/admin.php">Admin</a>
                    </li>
					<?php
				}
				?>
                <li class="nav-item" >
                    <a class="nav-link" aria-current="page" href="../home/home.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../home/profile.php?id=<?php echo $_SESSION['id'] ?>">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../home/messages.php">Mensajes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../home/settings.php">Configuración</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../session/logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>