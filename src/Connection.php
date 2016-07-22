<?php

$servername="localhost";
$username="root";
$password="coderslab"; 
$baseName= "Twitter";   

//Tworzenie nowego połączenia
$conn=new mysqli($servername, $username, $password, $baseName);

//sprwadzenie poprawności połączenia
if($conn->connect_error){
    die("Blad przy polaczeiu do baz danych: $conn->connect_error");
}

$conn->set_charset("utf8");
//echo("Polaczenie z baza danych udane. <br>");


