<?php

session_start();
require_once 'src/Connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/Comment.php';

echo "<a href='index.php'> Powrot do strony glownej </a><br><br>";
echo "<a href='showUsers.php'> Powrot do uzytkownikow </a><br><br>";

if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['userId'])){
    $userId = (int)($_GET['userId']);
    $user = new User();
    $user->loadFromDB($conn, $userId);
    $user->showUserTweet();

    $tweet = Tweet::loadAllTweets($conn, $userId);
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
}