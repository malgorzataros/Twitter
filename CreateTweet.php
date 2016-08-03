<?php
session_start();
require_once 'src/Tweet.php';
require_once 'src/Connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $newTweet = isset($_POST['tweet']) ? $conn->real_escape_string(trim($_POST['tweet'])) : null;
    $userId = isset($_SESSION['loggedUserId']) ? ($_SESSION['loggedUserId']) : "-1";
    
//    echo "Tweet: " . $newTweet . "<br>";
//    echo "UserID: " . $userId . "<br>";
    
    if(isset($newTweet) && isset($userId) && strlen($newTweet) < 141 & strlen(trim($newTweet)) > 0){
        $tweet = new Tweet();
        $tweet->setUserId($userId);
        $tweet->setText($newTweet);
        //var_dump($tweet);
        
        if($tweet->createTweet($conn)){
            //echo "dodany tweet";
            header("Location: index.php");
        } else {
            echo "Blad dodania tweetu";
        }
    } else {
        echo "Nie dodano Tweeta. Czy Tweet ma na pewno 140 znakow";
        
    }
    
    echo "<a href='index.php'> Powrot do strony glownej</a>";
    
}

