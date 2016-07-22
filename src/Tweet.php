<?php

class Tweet {
    
    static public function loadAllTweets(mysqli $conn, $user_id){
        $sql = "SELECT Tweet.id, Tweet.user_id, Tweet.text, User.fullName FROM Tweet "
                . "LEFT JOIN User ON Tweet.user_id = User.id WHERE User.id = $user_id ORDER BY Tweet.id DESC";
        $result = $conn->query($sql);
        //var_dump($result);
        $tweets = array();
        if($result->num_rows > 0){
            foreach($result as $row){
                $tweet = new Tweet();
                $tweet->id = $row['id'];
                $tweet->user_id = $row['user_id'];
                $tweet->text = $row['text'];
                $tweet->fullName = $row['fullName'];
                $tweets[] = $tweet;
            }   
        }
        return $tweets;
    }
    
    private $id;
    private $user_id;
    private $text;
    
    public function __construct() {
        $this->id = -1;
        $this->user_id = 0;
        $this->text = '';
    }
    
    public function setUserId ($userId) {
        $this->user_id = is_numeric($userId) ? $userId : 0;
    }
    
    public function setText ($text) {
        $this->text = is_string($text) ? $text : '';
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getUserId(){
        return $this->user_id;
    }
    
    public function getText(){
        return $this->text;
    }
    
    
    
    public function createTweet(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Tweet(user_id, text) VALUE ($this->user_id,'$this->text')";  
            if($conn->query($sql)){
                $this->id = $conn->insert_id;
                return $this;
            } else {
                return false;
            }
        } else {
            $sql = "UPDATE Tweet SET 
                   user_id = $this->user_id,
                   text = '$this->text' 
                   WHERE id = $this->id ";
           if($conn->query($sql)){
               return $this;
           } else {
               return false;
           }
        }
        
    }
    
    public function showTweet(){
        echo "<b>User: </b>" . $this->fullName . "<b> Napisal: </b>" . $this->text . "<br>";
        echo"<a href='detailsTweet.php?tweetId=$this->id'> Informacje o Tweet </a><br>";
    }
    
    public function loadTweet(mysqli $conn, $idTweet){
        $sql = "SELECT * FROM Tweet WHERE Tweet.id = $idTweet";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            //var_dump($result);
            $row = $result->fetch_assoc();
            $this->id = (int)$row['id'];
            $this->user_id = (int)$row['user_id'];
            $this->text = $row['text'];
            return true;
        } else {
            return false;
        }
    }
    
    
    

}
