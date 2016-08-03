<?php

class User {
    
    static public function logIn(mysqli $conn, $email, $password){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            //var_dump($row);
            if(password_verify($password, $row['password'])) {
                return $row['id'];
            }
            else{
                return false;
            }
        } else {
            return false;
        }
    }
    
    static public function getUserByEmail(mysqli $conn, $email){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $user = new User();
            $user->setId($row['id']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);
            $user->setFullName($row['fullName']);
            $user->setActive($row['active']);
            return $user;
        } else {
            return false;
        }
    }

    static public function getAllUsers(mysqli $conn){
        $sql = "SELECT * FROM User";
        $result = $conn->query($sql);
        $users = array();
        if($result->num_rows > 0){
            foreach($result as $row) {
                $user = new User();
                $user->id = (int)$row['id'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                $user->fullName = $row['fullName'];
                $user->active = (int)$row['active'];
                $users[] = $user;
            }
            return $users;
        } else {
            return false;
        }
    }
    
    private $id; 
    private $email;
    private $password;
    private $fullName;
    private $active;
    
    public function __construct() {
        $this-> id = -1;
        $this-> email = '';
        $this-> password = '';
        $this-> fullName = '';
        $this-> active = 0;
    }
    
    public function setId($id) {
        $this->id = is_integer($id) ? $id : -1;
    }
 
    public function setEmail($email) {
        $this->email = is_string($email) ? $email : '';
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setPassword($password) {
        $this->password = is_string($password) ? $password : '';
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setHashedPassword($password){
        $this->password = is_string($password) ? password_hash($password, PASSWORD_DEFAULT) : '';
    }
    
    public function setFullName($fullName){
        $this->fullName = is_string($fullName) ? $fullName : '';
    }
    
    public function getFullName(){
        return $this->fullName;
    }
    
    public function setActive($active){
        $this->active = $active == 0 || $active == 1 ? $active : 0;
    }
    
    public function getActive(){
        return $this->active;
    }
    
    public function loadFromDB(mysqli $conn, $userId){
        $sql = "SELECT * FROM User WHERE User.id = $userId";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            //var_dump($result);
            $row = $result->fetch_assoc();
            $this->id = (int)$row['id'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->fullName = $row['fullName'];
            $this->active = (int)$row['active'];
            return true;
        } else {
            return false;
        }
    }
    
   public function saveToDB(mysqli $conn){
       $sql = '';
       if($this->id == -1) {
           $sql = "INSERT INTO User(email, password, fullName, active) VALUE ('$this->email', 
                   '$this->password', '$this->fullName', $this->active)";
           if($conn->query($sql)) {
               $this->id = $conn->insert_id;
               return $this;
           } else {
               return false;
           }
       }
       else {
           $sql = "UPDATE User SET 
                   email = '$this->email',
                   password = '$this->password', 
                   fullName = '$this->fullName',
                   active = $this->active
                   WHERE id = $this->id ";
           if($conn->query($sql)){
               return $this;
           } else {
               return false;
           }
       }
   }

    public function showUser(){
        echo "<br><b>User: </b>" . $this->fullName . "<br>";
        echo"<a href='detailsUser.php?userId=$this->id'> Informacje o $this->fullName </a><br>";
        if($_SESSION['loggedUserId'] != $this->id){
            echo "<a href='sendMessage.php?userId=$this->id'> Wyslij wiadomosc do $this->fullName </a><br><br>";
        }
    }

    public function showUserTweet(){
        echo "<br><b>User: " . $this->fullName . "</b><br><br>";
    }
    
}

