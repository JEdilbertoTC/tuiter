<?php
session_start();
include '../config/database.php';
if (!isset($_SESSION['id']) && $_SESSION['role'] != '1')
	header('Location: login.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link href="../index.css" rel="stylesheet">
    <link rel="icon" href="../public/twitter_bird.ico" type="image/x-icon">
    <title>Registro como Administrador</title>
</head>
<body>
<div class="container-fluid">
    <div>
        <a href="admin.php"><i class="fas fa-arrow-left"></i> Volver</a>
    </div>
    <div class="modal-dialog">
        <div class="modal-content" id="modal-login">
            <div class="modal-header">
                <h4 class="modal-title title ms-5 pt-5">
                    <span class="black">Registrar</span>
                </h4>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <input autocomplete="no"
                               class="form-control"
                               name="name"
                               placeholder="Nombre"
                               type="text"
                               required>
                    </div>
                    <div class="mb-3">
                        <input autocomplete="off"
                               class="form-control"
                               placeholder="Correo electronico"
                               name="email"
                               type="email"
                               required>
                    </div>
                    <div class="mb-3">
                        <select id="cars" name="role" class="form-control">
                            <option value="0">Usuario</option>
                            <option value="1">Administrador</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <div class="pb-5">
                            <button class="float-end start pt-2 pb-2 ps-4 pe-4 text-decoration-none"
                                    href="#"
                                    name="register"
                                    type="submit">Registrarse
                            </button>
                        </div>
                    </div>
                </form>
				<?php
				if (isset($_POST['register'])) {
					$password = '123456';
					$email = $_POST['email'];
					$role = $_POST['role'];
					$name = $_POST['name'];
					$id = uniqid();
					$photo = 'https://i.stack.imgur.com/l60Hf.png';
					$checkEmail = $conexion->query("SELECT * FROM usuarios WHERE email = '$email'");
					if ($checkEmail->num_rows >= 1) { ?>
                        <div class="alert alert-danger alert-dismissible">
                            El email ya está en uso por favor escoja otro o verifique si tiene una cuenta
                        </div>
						<?php
						die();
					} else if ($checkEmail->num_rows == 0) {
						$query = "INSERT INTO usuarios VALUES ('$id', '$name', now(),'$email', '$password', '$role', '$photo', NULL)";
						$result = $conexion->query($query);
						?>
                        <div class="alert alert-success alert-dismissible">
                            Creado Correctamente
                        </div>
						<?php
					} else { ?>
                        <div class="alert alert-danger alert-dismissible">
                            Faltan campos
                        </div>
						<?php
					}
				} ?>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://kit.fontawesome.com/bc96b95e59.js" crossorigin="anonymous"></script>
<script src="../index.js"></script>
</html>