<?php
session_start();
include '../config/database.php';
if (isset($_SESSION['id'])) {
	header("Location: ../home/home.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link href="../index.css" rel="stylesheet">
    <title>Tuiter</title>
</head>
<body>
<div class="container">
    <a href="../index.php"><i class="fas fa-arrow-left"></i> Volver</a>
    <div class="modal-dialog">

        <div class="modal-content" id="modal-login">
            <div class="modal-header">
                <h4 class="modal-title title ms-5 pt-5">
                    <span class="black">Registrarse</span>
                </h4>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <input autocomplete="off"
                               class="form-control"
                               name="name"
                               placeholder="Nombre"
                               type="text"
                               required>
                    </div>
                    <div class="mb-3">
                        <input autocomplete="off"
                               class="form-control"
                               placeholder="Correo electrónico"
                               name="email"
                               type="email"
                               required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control input-password"
                               placeholder="Contraseña"
                               name="password"
                               type="password"
                               required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control input-password"
                               placeholder="Confirmar contraseña"
                               name="password2"
                               type="password"
                               required>
                    </div>
                    <div class="modal-footer">
                        <div class="pb-5">
                            <button class="float-end start pt-2 pb-2 ps-4 pe-4 text-decoration-none"
                                    name="register"
                                    type="submit">Registrarse
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
	<?php if (isset($_POST['register'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$checkEmail = $conexion->query("SELECT * FROM usuarios WHERE email = '$email'");

		if ($checkEmail->num_rows >= 1) { ?>
            <div class="alert alert-danger alert-dismissible">
                El email ya está en uso por favor escoja otro o verifique si tiene una cuenta
            </div>
			<?php
			die();
		}
		if ($password != $password2) { ?>
            <div class="alert alert-danger alert-dismissible">
                Las contraseñas no coinciden
            </div>
			<?php
			die();
		}

		if ($checkEmail->num_rows == 0) {
			$id = uniqid();
			$image = 'https://i.stack.imgur.com/l60Hf.png';
			$query = "INSERT INTO usuarios VALUES ('$id','$name', now(), '$email', '$password', '0', '$image', NULL)";
			$result = $conexion->query($query);
			if ($result) {
				$_SESSION['id'] = $id;
				$_SESSION['name'] = $name;
				$_SESSION['photo'] = $image;
				$_SESSION['role'] = 0;
				header('Location: ../home/home.php');
			}
		} else { ?>
            <div class="alert alert-danger alert-dismissible">
                Faltan campos
            </div>
			<?php
			die();
		}
	} ?>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/bc96b95e59.js" crossorigin="anonymous"></script>
<script src="../index.js"></script>
</html>