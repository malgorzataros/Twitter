<?php
session_start();

require_once 'src/Connection.php';
require_once 'src/User.php';

echo "<a href='index.php'> Powrot do strony glownej </a><br><br>";

$user = User::getAllUsers($conn);
foreach ($user as $row){
    $row->showUser();
}



