<?php

class Comment {
    
    static public function loadAllComments(mysqli $conn, $tweetId){
        $sql = "SELECT Comment.id, Comment.user_id, Comment.post_id, 
                       Comment.creation_date, Comment.text, User.fullName 
                       FROM Comment LEFT JOIN User ON Comment.user_id = User.id 
                       WHERE Comment.post_id = $tweetId 
                       ORDER BY Comment.id DESC";
        $result = $conn->query($sql);
        $comments = array();
        if($result !== false){
            if($result->num_rows > 0){
                foreach($result as $row){
                    $comment = new Comment();
                    $comment->id = $row['id'];
                    $comment->user_id = $row['user_id'];
                    $comment->post_id = $row['post_id'];
                    $comment->creationDate = $row['creation_date'];
                    $comment->text = $row['text'];
                    $comment->fullName = $row['fullName'];
                    $comments[] = $comment;
                }
                return $comments;
            } else {
            return false;
            }
        } else {
            return false;
        }
        
    }
    
    private $id;
    private $user_id;
    private $post_id;
    private $creationDate;
    private $text;
    
    public function __construct() {
        $this->id = -1;
        $this->user_id = 0;
        $this->post_id = 0;
        $this->creationDate = '';
        $this->text = '';
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setUserId($userId){
        $this->user_id = is_numeric($userId) ? $userId : 0;
    }
    
    public function getUserID(){
        return $this->user_id;
    }
    
    public function setPostId($postId){
        $this->post_id = is_numeric($postId) ? $postId : 0;
    }
    
    public function getPostId(){
        return $this->post_id;
    }
    
    public function setCreationDate($setDate){
        $this->creationDate = is_string($setDate) ? $setDate : '';
    }
    
    public function getCreationDate(){
        return $this->creationDate;
    }
    
    public function setText($setText) {
        $this->text = is_string($setText) ? $setText : '';
    }
    
    public function getText(){
        return $this->text;
    }
   
    public function loadCommentFromDB(mysqli $conn, $commentId){
        $sql = "SELECT * FROM Comment WHERE Comment.id = $commentId";
        $result = $conn->query($sql);
        if($result-> num_rows == 1){
            $row = $result->fetch_assoc();
            $this->id = (int)$row['id'];
            $this->user_id = (int)$row['user_id'];
            $this->post_id = (int)$row['post_id'];
            $this->creationDate = $row['creation_date'];
            $this->text = $row['text'];
            return true;
        } else {
            return false;
        }
    }
    
    public function createComment(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Comment(user_id, post_id, creation_date, text) VALUE ($this->user_id, $this->post_id, "
                    . "'$this->creationDate', '$this->text')";
            if($conn->query($sql)){
                $this->id = $conn->insert_id;
                return $this;
            } else {
                return false;
            }   
        } else {
            $sql = "UPDATE Comment SET 
                    user_id = $this->user_id,
                    post_id = $this->post_id,
                    creation_date = $this->creationDate,
                    text = $this->text
                    WHERE id = $this->id";
            if($conn->query($sql)){
                return $this;
            } else {
                return false;
            }
        }
    }
    
    public function showComment(){
        echo "<b>User: </b>" . $this->fullName . "<b> Komentarz: </b>" . $this->text . "<br><b> Data Komentarza: </b>" . 
                $this->creationDate . "<br><br>";
    }
    
    
}

