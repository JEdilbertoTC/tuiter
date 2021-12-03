<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
	header('location: ../session/login.php');
	die();
}

if (!$conexion->query("SELECT * FROM usuarios WHERE id = '{$_GET['id']}'")->num_rows) {
	header('location: ../error/404.php');
	die();
}

$idUser1 = $_SESSION['id'];
$idUser2 = $_GET['id'];

if ($idUser2 == $idUser1) {
	header('location: messages.php');
    die();
}

$idChatOrigin = null;
$query = "SELECT * FROM sala_chat WHERE id_user1 = '$idUser1' AND id_user2 = '$idUser2'";
if ($conexion->query($query)->num_rows == 0) {
	$idChatOrigin = uniqid();
	$query = "INSERT INTO sala_chat VALUES ('$idChatOrigin', '$idUser1', '$idUser2')";
	$conexion->query($query);
} else {
	$query = "SELECT id FROM sala_chat WHERE id_user1 = '$idUser1' AND id_user2 = '$idUser2'";
	$idChatOrigin = $conexion->query($query)->fetch_assoc()['id'];
}

$idChatDestiny = null;
$query = "SELECT * FROM sala_chat WHERE id_user1 = '$idUser2' AND id_user2 = '$idUser1'";
if ($conexion->query($query)->num_rows == 0) {
	$idChatDestiny = uniqid();
	$query = "INSERT INTO sala_chat VALUES ('$idChatDestiny', '$idUser2', '$idUser1')";
	$conexion->query($query);
} else {
	$query = "SELECT id FROM sala_chat WHERE id_user1 = '$idUser2' AND id_user2 = '$idUser1'";
	$idChatDestiny = $conexion->query($query)->fetch_assoc()['id'];
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link rel="stylesheet" href="messages.css">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="getMessages.css">
    <link rel="stylesheet" href="chat.css">
    <link rel="icon" href="../public/twitter_bird.ico" type="image/x-icon">
    <title>Mensajes</title>
	<?php
	$query = "SELECT id FROM sala_chat WHERE id_user1 = '$idUser1' AND id_user2 ='$idUser2'";
	$idChat = $conexion->query($query)->fetch_assoc()['id'];
	?>
    <script>
        const idChat = "<?php echo $idChat?>";
        console.log(idChat)

        function ajax() {
            const request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.status === 200 && request.readyState === 4) {
                    document.querySelector('.chat').innerHTML = request.responseText;
                    document.querySelector('.chat').scrollTop =
                        document.querySelector('.chat').scrollHeight -
                        document.querySelector('.chat').clientHeight
                }
            }
            request.open("GET", `getMessages.php?id=${idChat}`, true);
            request.send();
        }

        setInterval(() => {
            ajax();
        }, 5000)

    </script>
</head>

<body onload="ajax();">
<div class="container">
    <div class="row">
		<?php include "navigation.php"; ?>
        <div class="d-none d-xl-block col d-md-block d-xxl-block">
			<?php include "chats.php" ?>
        </div>
        <div class="col  d-flex flex-column justify-content-between">
			<?php
			$query = "SELECT * FROM usuarios WHERE id = '$idUser2'";
			$chatWith = $conexion->query($query)->fetch_assoc();
			?>

            <div class="d-flex">
                <a href="messages.php"><i class="fas fa-arrow-left"></i></a>
                <a class="ps-2 profile" style="font-weight: bold; text-transform: uppercase"
                   href="profile.php?id=<?php echo $chatWith['id'] ?>">
					<?php echo $chatWith['name'] ?>
                </a>
            </div>

            <div class="chat border"></div>

            <form action="" method="post">
                <div class="input-group pt-1">
                    <input type="text" name="message" autocomplete="off" class="form-control"
                           placeholder="Escribe un nuevo mensaje">
                    <button type="submit" name="send" style="border: none" class="input-group-text">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>

            </form>

			<?php if (isset($_POST['send'])) {
				$message = $_POST['message'];

				$id = uniqid();
				$query = "INSERT INTO mensajes VALUES ('$id', '$idChatOrigin', '$message', now(), '{$_SESSION['id']}')";
				$conexion->query($query);

				$query = "INSERT INTO mensajes VALUES ('$id', '$idChatDestiny', '$message', now(), '{$_SESSION['id']}')";
				$conexion->query($query);
			} ?>
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