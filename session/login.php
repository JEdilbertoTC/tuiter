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
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                    <span class="black">Iniciar sesión</span>
                </h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <input class="form-control"
                               placeholder="Correo electrónico"
                               name="email"
                               type="text"
                               required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control input-password"
                               placeholder="Contraseña"
                               name="password"
                               type="password"
                               required>
                    </div>
                    <div class="modal-footer">
                        <div class="pb-5">
                            <button class="float-end start pt-2 pb-2 ps-4 pe-4 text-decoration-none"
                                    name="start"
                                    type="submit">Iniciar sesion
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php if (isset($_POST['start'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		$query = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
		$result = $conexion->query($query);

		if ($result->num_rows) {
			$result = $result->fetch_assoc();
			if ($result['email']) {
				$_SESSION['id'] = $result['id'];
				$_SESSION['name'] = $result['name'];
				$_SESSION['photo'] = $result['photo'];
				$_SESSION['role'] = $result['role'];
				header('Location: ../home/home.php');
			}
		} else { ?>
            <div class="alert alert-danger alert-dismissible">
                El correo o la contraseña no coinciden
            </div>
			<?php
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
