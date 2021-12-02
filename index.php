<?php
session_start();
include 'config/database.php';
if (isset($_SESSION['id']))
	header('Location: home/home.php');
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
    <link rel="icon" href="public/twitter_bird.ico" type="image/x-icon">
    <link href="index.css" rel="stylesheet">
    <title>Tuiter</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="fondo-left col-12 d-flex align-items-center justify-content-center small order-last col col-xl-6 order-xl-first">
            <i class="fab fa-twitter twitter"></i>
        </div>
        <div
                class="fondo-right col-12 d-flex align-items-center ps-5 pt-5 order-first col col-xl-6 order-xl-last">
            <div class="row">
                <div class="col-12">
                    <i class="fab fa-twitter logo-right"></i>
                </div>
                <div class="col-7 col-xl-10">
                    <p class="phrase">Lo que está pasando ahora</p>
                    <p class="join">Únete a Tuiter hoy mismo.</p>
                </div>

                <div class="col-12">
                    <a class="register pt-2 pb-2 ps-5 pe-5" href="session/register.php">
                        Registrarse
                    </a>
                </div>

                <div class="pt-3 col-7 .d-none">
                    <p>
                        Al registrarte, aceptas los
                        <a class="terms">Términos de servicio</a> y la
                        <a class="terms" href="">Política de privacidad</a>, incluida la política de
                        <a class="terms" href="">Uso de Cookies</a>.
                    </p>
                </div>

                <div>
                    <p>¿Ya tienes una cuenta? <a class="session" href="session/login.php">
                            Inicia sesión</a></p>
                </div>

            </div>

        </div>
    </div>
</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/bc96b95e59.js" crossorigin="anonymous"></script>
<script src="index.js"></script>
</html>