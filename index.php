<?php

session_start();

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php");
}

?>

Id uzytkownika: <?php echo $_SESSION['loggedUserId']; ?>
<br>
<a href="logout.php">Logout</a>
