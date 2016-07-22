<?php
session_start();

require_once 'src/Connection.php';
require_once 'src/Comment.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $newComment = isset($_POST['comment']) ? $conn->real_escape_string(trim($_POST['comment'])) : null;
    $userId = isset($_SESSION['loggedUserId']) ? ($_SESSION['loggedUserId']) : "-1";
    $tweetId = isset($_POST['tweetId']) ? $conn->real_escape_string(trim($_POST['tweetId'])) : null;
    
//    echo "Komentarz: " . $newComment . "<br>";
//    echo "UserId: " . $userId . "<br>";
    
    if(isset($newComment) && isset($userId) && strlen($newComment) < 141 && strlen($newComment) > 0){
        $comment = new Comment();
        $date = date('Y-m-d H:i:s');
        $comment->setUserId($userId);
        $comment->setCreationDate($date);
        $comment->setPostId($tweetId);
        $comment->setText($newComment);
        //var_dump($comment);
        
        if($comment->createComment($conn)){
            echo "Dodany komentarz";
        } else {
            echo "Blad dodania komentarza";
        }
    } else {
        echo "Nie dodano komentarza. Czy Komentarz ma na pewno 140 znakow?";
    }
    
    echo "<a href='detailsTweet.php'> Powrot do strony z tweet'em </a>";
}

