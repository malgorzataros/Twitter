<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    require_once 'src/Connection.php';
    require_once 'src/User.php';
    
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? $conn->real_escape_string(trim($_POST['password'])) : null;
    $passwordConfirmation = isset($_POST['passwordConfirmation']) ? trim($_POST['passwordConfirmation']) : null;
    $fullName = isset($_POST['fullName']) ? $conn->real_escape_string(trim($_POST['fullName'])) : null;
    
    $user = User::getUserByEmail($conn, $email);
    if($email && $password && $password == $passwordConfirmation && !$user){
        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setHashedPassword($password);
        $newUser->setFullName($fullName);
        $newUser->setActive(1);
        //metoda do zapisu lub actualnienia danych
        if($newUser->saveToDB($conn)){
            header("Location: login.php");
        } else {
            echo "Rejestracja nie powiadla sie <br>";
        }
           
    } else {
        if($user){
            echo "Podany adres e-mail istnieje w bazie danych <br>";
        } else {
        echo "Nieprawidlowe dane <br>";
        }
    }
    
    $conn->close();
    $conn = null;
    
}
?>

<form method="POST">
    <fieldset
        <label>
            E-mail:
            <br>
            <input type="text" name="email">
            <br>
        </label>
        <br>
        <label>
            Password:
            <br>
            <input type="password" name="password">
            <br>
        </label>
        <br>
        <label>
            Password confirmation:
            <br>
            <input type="password" name="passwordConfirmation">
            <br>
        </label>
        <br>
        <label>
            Full name:
            <br>
            <input type="text" name="fullName">
        </label>
    </fieldset>
    <br>
    <br>
    <input type="submit" value="Register">
    
</form>

