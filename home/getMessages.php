<?php
include "../config/database.php";
session_start();

$idChat = $_GET['id'];

$query = "SELECT * FROM sala_chat WHERE id = '$idChat'";
$user2 = $conexion->query($query)->fetch_assoc()['id_user2'];

$query = "SELECT * FROM mensajes WHERE id_chat = '$idChat'";
$messages = $conexion->query($query);

while ($message = $messages->fetch_assoc()) { ?>

	<?php
	if ($message['id_user'] == $_SESSION['id']) { ?>
        <div class="d-flex justify-content-end mt-1">
            <div class="dropdown">
                <a class="d-flex align-items-center text-black-50 text-decoration-none dropdown-toggle posts-settings p-2 fas fa-cog"
                   id="optionsPosts"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">
                </a>
                <ul class="dropdown-menu" aria-labelledby="optionsPosts">
                    <li>
                        <form action="deleteMessageForMe.php" method="post" name="delete">
                            <input type="text"
                                   name="id_chat"
                                   hidden
                                   value="<?php echo $idChat ?>">
                            <input type="text"
                                   name="id_message"
                                   hidden
                                   value="<?php echo $message['id']?>">
                            <input type="text"
                                   name="redirect"
                                   hidden
                                   value="<?php echo $user2 ?>">
                            <input type="text"
                                   hidden
                                   name="user"
                                   value="<?php echo $_SESSION['id']?>">
                            <input type="submit"
                                   class="dropdown-item"
                                   style="color: black"
                                   value="Eliminar para mi"
                                   name="delete-message-for-me">
                        </form>
                    </li>
                    <li>
                        <form action="deleteMessageForAll.php" method="post">
                            <input type="text"
                                   hidden
                                   name="id-message"
                                   value="<?php echo $message['id']?>">
                            <input type="text"
                                   hidden
                                   name="redirect"
                                   value="<?php echo $user2?>">
                            <input type="submit" class="dropdown-item" style="color: black"
                                   value="Eliminar para ambos" name="delete-message-for-all">
                        </form>
                    </li>
                </ul>
            </div>
            <p class="owner-message">
				<?php echo $message['mensaje'] ?>
            </p>
        </div>
		<?php
	} else { ?>
        <div class="d-flex justify-content-start mt-1">
            <p class="friend-message">
				<?php echo $message['mensaje'] ?>
            </p>
            <div class="dropdown">
                <a class="d-flex align-items-center text-black-50 text-decoration-none dropdown-toggle posts-settings p-2 fas fa-cog"
                   id="optionsPosts"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">
                </a>
                <ul class="dropdown-menu" aria-labelledby="optionsPosts">
                    <li>
                        <form action="deleteMessageForMe.php" method="post">
                            <input type="text"
                                   name="id_chat"
                                   hidden
                                   value="<?php echo $idChat ?>">
                            <input type="text"
                                   name="redirect"
                                   hidden
                                   value="<?php echo $user2?>">
                            <input type="text"
                                   name="id_message"
                                   hidden
                                   value="<?php echo $message['id'] ?>">
                            <input type="text"
                                   hidden
                                   name="user"
                                   value="<?php echo $user2?>">
                            <input type="submit"
                                   class="dropdown-item"
                                   style="color: black"
                                   value="Eliminar para mi"
                                   name="delete-message-for-me">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
		<?php
	} ?>
<?php } ?>
