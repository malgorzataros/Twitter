<?php
session_start();
require_once 'src/Connection.php';
require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/Comment.php';

echo "<a href='index.php'> Powrot do strony glownej </a><br><br>";

//if($_SERVER['REQUEST_METHOD'] === "GET" || $_SERVER['REQUEST_METHOD'] === "POST"){

    if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['tweetId'])){
        $tweetId = (int)($_GET['tweetId']);
        //var_dump($tweetId);
        $info = new Tweet();
        $info->loadTweet($conn, $tweetId);
        //var_dump($info);
        $tweetCreator = new User();
        $tweetCreator->loadFromDB($conn, $info->getUserId());
        //var_dump($tweetCreator);
        echo "<b>Tweet: </b>" . $info->getText() . "<br>";
        echo "<b>Author: </b>" . $tweetCreator->getFullName() . "<br>";
        echo "<br>";
        echo "<br>";
        $comment = Comment::loadAllComments($conn, $tweetId);
        if($comment !== false){
            foreach($comment as $row){
                $row->showComment();
            }
        }
    } //else {
    //    echo "Brak mozliwosci wyswietlenia Tweeta <br>";
    //}
    //$comment = new Comment();


    //} 
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $newComment = isset($_POST['comment']) ? $conn->real_escape_string(trim($_POST['comment'])) : null;
        //$newTweetId = isset($_POST['tweetId']) ? (int)($_POST['tweetId']) : 0;
        $userId = isset($_SESSION['loggedUserId']) ? ($_SESSION['loggedUserId']) : "-1";
    //    var_dump($newComment);
    //    var_dump($newTweetId);
    //    var_dump($userId);

    //    echo "Komentarz: " . $newComment . "<br>";
    //    echo "UserId: " . $userId . "<br>";

        if(isset($newComment) && isset($userId) && strlen($newComment) < 141 && strlen($newComment) > 0){
            $comments = new Comment();
            $date = date('Y-m-d H:i:s');
            $tweetId = (int)$_POST['tweetId'];
            $comments->setUserId($userId);
            $comments->setCreationDate($date);
            $comments->setPostId($tweetId);
            $comments->setText($newComment);
            //var_dump($comment);

            if($comments->createComment($conn)){
                //echo "Dodany komentarz";
                $comment = Comment::loadAllComments($conn, $tweetId);
                if($comment !== false){
                    foreach($comment as $row){
                        $row->showComment();
                    }
                }
            } else {
                echo "Blad dodania komentarza";
            }
        } else {
            echo "Nie dodano komentarza. Czy Komentarz ma na pewno 140 znakow?";
        }
    } 
//} else {
//    echo "Brak możliwości wyswietlenia tweeta <br>";
//    echo "Brak mozliwosci wyswietlenia komentarzy";
//}

//if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['tweetId'])){
   
//} else {
//    echo "Brak mozliwosci wyswietlenia komentarzy";
//}


//}

?>

<form method="POST">
    <label> Dodaj komentarz: 
        <br>
        <textarea rows="3" cols="40" name="comment" placeholder="Wpisz swoj komentarz..."></textarea>
        <input type="hidden" value="<?php echo $tweetId?>" name="tweetId">
        <br>
        <input type="submit" value="Dodaj komantarz">
        <br>
    </label>
</form>


