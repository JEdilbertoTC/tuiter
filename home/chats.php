<?php
include '../config/database.php';
if (!isset($_SESSION['id']))
	header('location: ../index.php');
$query = "SELECT * FROM usuarios WHERE id != '{$_SESSION['id']}'";
$users = $conexion->query($query);

/**
 * @param mysqli_result $users
 * @param mysqli $conexion
 */
function extracted(mysqli_result $users, mysqli $conexion)
{
	while ($user = $users->fetch_assoc()) { ?>
        <div class="user_chat pt-3 pb-3 border container-chat">
            <a href="chat.php?id=<?php echo $user['id'] ?>" class="">
                <div class="ps-2">
                    <div class="d-flex flex-row">
                        <img src="<?php echo $user['photo'] ?>" alt="" height="32" width="32"
                             class="rounded-circle">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex">
                                <p class="pe-2 ps-2"
                                   style="font-weight: bold; text-transform: uppercase; font-size: 12px">
									<?php echo $user['name'] ?>
                                </p>
                                <p style="font-size: 12px"><?php echo $user['email'] ?></p>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <p class="ps-2 max">
									<?php
									$query = "SELECT * FROM sala_chat WHERE id_user1 = '{$_SESSION['id']}' AND id_user2 = '{$user['id']}'";

									$lastMessage = null;
									$idChat = null;
									if ($conexion->query($query)->num_rows) {
										$idChat = $conexion->query($query)->fetch_assoc()['id'];
									}

									$query = "SELECT * FROM mensajes WHERE id_chat = '$idChat' ORDER BY date DESC LIMIT 1";
									if ($conexion->query($query)->num_rows > 0) {
										$lastMessage = $conexion->query($query)->fetch_assoc()['mensaje'];
									}
									echo $lastMessage;
                                    ?>
                                </p>
                                <p class="ps-2 show-date pt-5">
									<?php if ($conexion->query($query)->num_rows > 0) {
										echo $conexion->query($query)->fetch_assoc()['date'];
									}
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
	<?php }
}

if (!isset($_GET['q'])) { ?>
    <div class="col">
        <p class="title mb-3">Mensajes</p>
        <div class="user-div">
			<?php extracted($users, $conexion); ?>
        </div>
    </div>
	<?php
} else {
	$query = "SELECT * FROM usuarios WHERE name LIKE '%{$_GET['q']}%' AND id != '{$_SESSION['id']}'";
	$users = $conexion->query($query);
	?>
    <div class="col">
        <div class="d-flex align-items-center">
            <a href="messages.php" class="back"><i class="fas fa-arrow-left"></i></a>
            <p class="title ps-2">Mensajes</p>
        </div>

        <div class="user-div">
			<?php extracted($users, $conexion); ?>
        </div>
    </div>
	<?php
}
?>