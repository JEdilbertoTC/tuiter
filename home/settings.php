<?php
session_start();
include '../config/database.php';
if (!isset($_SESSION['id'])) {
	header('Location: login.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="settings.css" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <link rel="icon" href="../public/twitter_bird.ico" type="image/x-icon">
    <title>Configuracion</title>
</head>
<body>
<div class="container">
    <div class="row">
		<?php include "navigation.php"; ?>
        <div class="col">
            <h1>
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <p class="text-info">Información básica</p>
                    <p class="description pb-3">
                        Configura tus preferencias de inicio de sesión, ayudanos a personalizar tu experiencia y
                        a hacer grandes cambios en tu cuenta aquí
                    </p>
                </div>
                <div class="cajaTextoUsuario">
                    Nombre:
					<?php
					$id = $_SESSION['id'];
					$query = "SELECT name FROM usuarios WHERE id = '$id'";
					$email = $conexion->query($query)->fetch_assoc();
					echo $email['name'];
					?>
                </div>
            </h1>
            <div class="cajaTextoCorreoBiografia">
				<?php
				$id = $_SESSION['id'];
				$query = "SELECT biography FROM usuarios WHERE id = '$id'";
				$biography = $conexion->query($query)->fetch_assoc();
				?>
                <div class="row d-flex justify-content-center align-items-center">
                    Biografia:
					<?php echo $biography['biography'] ?>
                </div>


				<?php
				$id = $_SESSION['id'];
				$query = "SELECT email FROM usuarios WHERE id = '$id'";
				$email = $conexion->query($query)->fetch_assoc();
				?>
                <div class="d-flex flex-row justify-content-center align-items-center">
                    Correo Electronico:
					<?php echo $email['email'] ?>
                </div>

            </div>
            <form method="post" action="" class="change-data-container" style="margin-top: 20px">
                <p class="change-data">Nombre</p>
                <div class="d-flex flex-row">
                    <input type="text" name="name" autocomplete="no" required class="boxText" placeholder="Nombre">
                    <input type="submit" name="different-name" class="button" value="Cambiar">
                </div>
            </form>
            <form method="post" action="" class="change-data-container">
                <p class="change-data">Correo Electronico</p>
                <div class="d-flex flex-row">
                    <input type="email" name="email" required class="boxText"
                           placeholder="Correo electronico">
                    <input type="submit" name="different-email" class="button" value="Cambiar">
                </div>
            </form>
            <form method="post" action="" class="change-data-container">
                <p class="change-data">Contraseña</p>
                <div class="d-flex flex-row">
                    <input type="password" name="password" required autocomplete="off" class="boxText"
                           placeholder="Contraseña">
                    <input type="submit" name="different-password" class="button" value="Cambiar">
                </div>
            </form>
            <form method="post" action="" class="change-data-container">
                <p class="change-data">Cambiar Biografia</p>
                <div class="d-flex flex-row">
                    <input type="text" name="biography" required autocomplete="off" class="boxText"
                           placeholder="Biografia">
                    <input type="submit" name="different-biography" class="button" value="Cambiar">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['different-name'])) {
	$differentName = $_POST['name'];
	$differentName = trim($differentName);

	if (!$differentName) { ?>
        <div class="alert alert-danger alert-dismissible">
            No es cambio el nombre
        </div>
		<?php
		die();
	}
	$id = $_SESSION['id'];
	$query = "UPDATE usuarios SET name='$differentName' WHERE id = '$id' ";
	$correct = $conexion->query($query);

	if ($correct)
		header('Location: settings.php');

}

if (isset($_POST['different-password'])) {
	$differentPassword = $_POST['password'];
	$differentPassword = trim($differentPassword);

	if (!$differentPassword) { ?>
        <div class="alert alert-danger alert-dismissible">
            No es cambio la contraseña
        </div>
		<?php
		die();
	}
	$id = $_SESSION['id'];
	$query = "UPDATE usuarios SET password='$differentPassword' WHERE id = '$id' ";
	$correct = $conexion->query($query);

	if ($correct)
		header('Location: settings.php');
}

if (isset($_POST['different-biography'])) {
	$biography = $_POST['biography'];
	$id = $_SESSION['id'];
	$query = "UPDATE usuarios SET biography='$biography' WHERE id = '$id' ";
	$correct = $conexion->query($query);
	if ($correct)
		header('Location: settings.php');
}

if (isset($_POST['different-email'])) {
	$differentEmail = $_POST['email'];
	$id = $_SESSION['id'];
	$differentEmail = trim($differentEmail);

	if (!$differentEmail) { ?>
        <div class="alert alert-danger alert-dismissible">
            No es cambio el email
        </div>
		<?php
	}

	$query = "SELECT email FROM usuarios WHERE id = '$id' ";
	$correct = $conexion->query($query)->fetch_assoc();
	if ($differentEmail == $correct['email']) { ?>
        <div class="alert alert-danger alert-dismissible">
            No puedes ingresar el mismo correo electronico ya registrado
        </div>
		<?php
		die();
	}
	$query = "SELECT email FROM usuarios WHERE email = '$differentEmail'";
	if ($conexion->query($query)->num_rows > 0) { ?>
        <div class="alert alert-danger alert-dismissible">
            Este correo ya ha sido registrado anteriomente por otra persona
        </div>
		<?php
		die();
	}
	$query = "UPDATE usuarios SET email='$differentEmail' WHERE id = '$id' ";
	$correct = $conexion->query($query);
	if ($correct)
		header('Location: settings.php');
}

?>

</body>
<script src="../index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/bc96b95e59.js" crossorigin="anonymous"></script>
</html>