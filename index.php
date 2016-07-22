<?php
session_start();
require_once 'src/Tweet.php';
require_once 'src/Connection.php';
require_once 'src/User.php';
require_once 'src/Comment.php';

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php");
}

?>

Id uzytkownika: <?php echo $_SESSION['loggedUserId']; ?>
<br>
<a href="logout.php">Logout</a>
<br>
<form action="CreateTweet.php" method="POST">
Dodaj Tweet:
<input type="text" name="tweet" max="160">
<input type="submit" value="Dodaj Tweet">
</form>
<br>

<b><u>Tweety: </b></u>
<br>

<?php
$tweet = Tweet::loadAllTweets($conn, $_SESSION['loggedUserId']);
foreach($tweet as $row){
    $row->showTweet();
    $comm = Comment::loadAllComments($conn, $row->getId());
    echo "<b>Liczba komentarzy: </b>" . count($comm) . "<br><br>";
}

//var_dump($_SESSION['loggedUserId']);
?>