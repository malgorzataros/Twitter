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
<br>
<form action="showUsers.php">
    <input type="submit" position="right" value="Uzytkownicy" >
</form>
<form action="inbox.php">
    <input type="submit" position="right" value="Inbox" >
</form>
<form action="sendbox.php">
    <input type="submit" position="right" value="Sendbox" >
</form>
<form action="CreateTweet.php" method="POST">
    <br>
    Dodaj Tweet:
    <br>
    <textarea rows="3" cols="40" name="tweet" placeholder="Wpisz swojego Tweeta..." max="160"></textarea>
    <br>
    <!-- <input type="text" name="tweet" max="160"> -->
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
    if($comm !== false) {
        echo "<b>Liczba komentarzy: </b>" . count($comm) . "<br><br>";
    } else {
        $comm = 0;
        echo "<b>Liczba komentarzy: </b>" . $comm . "<br><br>";
    }
}

//var_dump($_SESSION['loggedUserId']);
?>