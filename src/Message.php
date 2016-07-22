<?php

class Message {
    
    static public function loadAllReceive(mysqli $conn, $receivUserId){
        $sql = "SELECT Message.id, Message.sender_id, Message.receiver_id, Message.message, 
                       Message.message_date, Message.message_status, User.fullName FROM 
                       Message LEFT JOIN User ON Message.receiver_id = User.id 
                       WHERE Message.receiver_id = $receivUserId ORDER BY Message.id DESC";
        
        
        $result = $conn->query($sql);
        $messages = array();
        if($result !== false){
            if($result->num_rows > 0){
                foreach($result as $row){
                    $message = new Message();
                    $message->id = $row['id'];
                    $message->senderId = $row['sender_id'];
                    $message->receiverId = $row['receiver_id'];
                    $message->message = $row['message'];
                    $message->messageDate = $row['message_date'];
                    $message->messageStatus = $row['message_status'];
                    $message->fullName = $row['fullName'];
                    $messages[] = $message;
                }
                return $messages;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    static public function loadAllSend(mysqli $conn, $sendUserId){
        $sql = "SELECT Message.id, Message.sender_id, Message.receiver_id, Message.message, 
                       Message.message_date, Message.message_status, User.fullName FROM 
                       Message LEFT JOIN User ON Message.receiver_id = User.id 
                       WHERE Message.sender_id = $sendUserId ORDER BY Message.id DESC";
        $result = $conn->query($sql);
        $messages = array();
        if($result !== false){
            if($result->num_rows > 0){
                foreach($result as $row){
                    $message = new Message();
                    $message->id = $row['id'];
                    $message->senderId = $row['sender_id'];
                    $message->receiverId = $row['receiver_id'];
                    $message->message = $row['message'];
                    $message->messageDate = $row['message_date'];
                    $message->messageStatus = $row['message_status'];
                    $message->fullName = $row['fullName'];
                    $messages[] = $message;
                }
                return $messages;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    private $id;
    private $senderId;
    private $receiverId;
    private $message;
    private $messageDate;
    private $messageStatus;
    
    
    public function __construct() {
        $this->id = -1;
        $this->senderId = 0;
        $this->receiverId = 0;
        $this->message = '';
        $this->messageDate = '';
        $this->messageStatus = 1;
    }
                
    public function getId(){
        return $this->id;
    }
    
    public function setSenderId($idSender){
        $this->senderId = is_numeric($idSender) ? $idSender : 0;
    }
    
    public function getSenderId(){
        return $this->senderId;
    }
    
    public function setReceiverId($idReceiver){
        $this->receiverId = is_numeric($idReceiver) ? $idReceiver : 0;
    }
    
    public function getReceiverId(){
        return $this->receiverId;
    }
    
    public function setMessage($mess){
        $this->message = is_string($mess) ? $mess : '';
    }
    
    public function getMessage(){
        return $this->message;
    }
    
    public function setMessageDate($date){
        $this->messageDate = is_string($date) ? $date : '';
    }
    
    public function getMessageDate(){
        return $this->messageDate;
    }
    
    public function setMessageStatus($status){
        $this->messageStatus = is_numeric($status) ? $status : 1;
    }
    
    public function getMessageStatus(){
        return $this->messageStatus;
    }
    
    public function loadMessageFromDB(mysqli $conn, $messageId){
        $sql = "SELECT * FROM Message WHERE Message.id = $messageId";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->senderId = $row['sender_id'];
            $this->receiverId = $row['receiver_id'];
            $this->message = $row['message'];
            $this->messageDate = $row['message_date'];
            $this->messageStatus = $row['message_status'];
            return true;
        } else {
            return false;
        }
    }
    
    public function createMessage(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Message(sender_id, receiver_id, message, message_date, message_status)
                    VALUE ($this->senderId, $this->receiverId, '$this->message', '$this->messageDate', 
                    '$this->messageStatus')";
            if($conn->query($sql)){
                $this->id = $conn->insert_id;
                return $this;
            } else {
                return false;
            }
        } else {
            $sql = "UPDATE Message SET
                    sender_id = $this->senderId,
                    receiver_id = $this->receiverId,
                    message = $this->message,
                    message_date = $this->messageDate,
                    message_status = $this->messageStatus
                    WHERE Message.id = $this->id";
            if($conn->query($sql)){
                return $this;
            } else {
                return false;
            }
        }
    }
    
    public function showMessage(){
        $cutMessage = substr($this->message, 0, 30) . "...";
        echo "<b>User: </b>" . $this->fullName . "<b> Wiadomosc: </b>" . $cutMessage . "<br><b> Data Wiadomosci: </b>" . 
                $this->creationDate . "<br><br>";
    }
    
    
    
    
    
}

