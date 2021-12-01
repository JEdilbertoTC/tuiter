<?php
session_start();
include '../config/database.php';
if ($_SESSION['role'] != 1 || !isset($_SESSION['id'])) {
	header('Location: ../session/login.php');
	die();
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="admin.css" rel="stylesheet">
    <link href="../home/home.css" rel="stylesheet">
    <link rel="icon" href="../public/twitter_bird.ico" type="image/x-icon">
    <title>Administrador</title>
</head>
<body>
<div class="container">
    <div class="row">
		<?php include "../home/navigation.php"; ?>
        <div class="col">
            <h1 class="ps-2">Administrador</h1>
            <a href="register.php" class="add">Agregar nuevos usuarios</a>
            <div class="table table-responsive">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo Electrónico</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">ID</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Configuración</th>
                    </tr>
                    </thead>
                    <tbody id="body-table">
					<?php
					$query = "SELECT * FROM usuarios ORDER BY date DESC";
					$users = $conexion->query($query);
					if ($users) {
						$index = 1;
						while ($user = $users->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $index ?></td>
                                <td><?php echo $user['name'] ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td><?php echo $user['date'] ?></td>
                                <td><?php echo $user['id'] ?></td>
                                <td><?php echo $user['role'] == 1 ? 'Administrador' : 'Usuario' ?></td>
                                <td>
                                    <div class="dropdown d-flex justify-content-center align-items-center ">
                                        <a class="d-flex align-items-center text-black-50 text-decoration-none dropdown-toggle"
                                           id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownUser1">
											<?php if ($_SESSION['id'] != $user['id'] && $user['role'] != '1') { ?>
                                                <div class="dropdown-item">
                                                    <li>
                                                        <form action="do-admin.php" method="post">
                                                            <input type="text" hidden name="id"
                                                                   value="<?php echo $user['id'] ?>">
                                                            <button type="submit"
                                                                    class="dropdown-item"
                                                                    name="delete">
                                                                Ascender a Administrador
                                                            </button>
                                                        </form>
                                                    </li>
                                                </div>
                                                <div class="dropdown-item">
                                                    <li>
                                                        <form action="delete.php" method="post">
                                                            <input type="text" hidden name="id"
                                                                   value="<?php echo $user['id'] ?>">
                                                            <button type="submit"
                                                                    class="dropdown-item"
                                                                    style="color: red"
                                                                    name="delete">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </li>
                                                </div>
												<?php
											}
											?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
							<?php
							$index++;
						}
					}
					?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://kit.fontawesome.com/bc96b95e59.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="../index.js"></script>
</html>