<?php
session_start();
include '../config/database.php';
if (!isset($_SESSION['id'])) {
	header('location: ../session/login.php');
	die();
}
$id = $_SESSION['id'];
$query = "SELECT * FROM usuarios WHERE id = '$id'";
$result = $conexion->query($query)->fetch_assoc();
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
            <h1 class="d-flex flex-column align-items-center">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <p class="text-info">Información básica</p>
                    <p class="description pb-3">
                        Configura tus preferencias de inicio de sesión, ayudanos a personalizar tu experiencia y a hacer
                        grandes cambios en tu cuenta aquí
                    </p>
                </div>
                <div class="text-user-div">
					<?php echo $result['name']; ?>
                </div>
                <img src="<?php echo $result['photo']; ?>" class="rounded-circle" height="300" alt="">
            </h1>
            <div class="biography-container">
                <div class="row d-flex justify-content-center align-items-center">
                    Biografía:
					<?php echo $result['biography']; ?>
                </div>
                <div class="d-flex flex-row justify-content-center align-items-center">
                    Correo Electrónico:
					<?php echo $result['email'] ?>
                </div>
            </div>

            <form method="post" action="upload-photo.php" class="change-data-container" enctype="multipart/form-data"
                  style="margin-top: 20px">
                <p class="change-data">Foto de perfil</p>
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <label for="file" class="pe-2" style="cursor:pointer;">Selecciona una foto</label>
                    <input type="file" id="file" name="file" required accept="image/*" style="display: none">
                    <input type="submit" name="submit" class="button" value="Cambiar">
                </div>
            </form>

            <form method="post" action="change-name.php" class="change-data-container" style="margin-top: 20px">
                <p class="change-data">Nombre</p>
                <div class="d-flex flex-row">
                    <input type="text" name="name" autocomplete="off" required class="text-box" placeholder="Nombre"
                           value="<?php echo $_SESSION['name'] ?>">
                    <input type="submit" name="different-name" class="button" value="Cambiar">
                </div>
            </form>
            <form method="post" action="change-email.php" class="change-data-container">
				<?php
				if (isset($_GET['error'])) {
					echo 'No se cambio el email';
				}
                if(isset($_GET['same'])) {
                    echo 'No puedes ingresar el mismo correo electronico ya registrado';
                }
				if(isset($_GET['other'])) {
					echo 'Este correo ya ha sido registrado anteriomente por otra persona';
				}
				?>
                <p class="change-data">Correo Electrónico</p>
                <div class="d-flex flex-row">
                    <input type="email" name="email" required class="text-box"
                           value="<?php echo $_SESSION['email'] ?>"
                    placeholder="Correo Electrónico">
                    <input type="submit" name="different-email" class="button" value="Cambiar">
                </div>
            </form>
            <form method="post" action="change-password.php" class="change-data-container">
                <?php
                if(isset($_GET['success'])) {
                    echo 'Contraseña cambiada correctamente';
                }

                if(isset($_GET['password'])) {
	                echo 'No cambiamos la contraseña';
                }
                ?>
                <p class="change-data">Contraseña</p>
                <div class="d-flex flex-row">
                    <input type="password" name="password" required class="text-box"
                           placeholder="Antigua Contraseña">
                    <input type="password" name="password2" required class="text-box"
                           placeholder="Nueva Contraseña">
                    <input type="submit" name="different-password" class="button" value="Cambiar">
                </div>
            </form>
            <form method="post" action="change-biography.php" class="change-data-container">
                <p class="change-data">Cambiar Biografía</p>
                <div class="d-flex flex-row">
                    <input type="text" name="biography" required autocomplete="off" class="text-box"
                           placeholder="Biografia">
                    <input type="submit" name="different-biography" class="button" value="Cambiar">
                </div>
            </form>
        </div>
    </div>
</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/bc96b95e59.js" crossorigin="anonymous"></script>
<script src="../index.js"></script>
</html>