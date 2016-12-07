<?php
require_once "global_class.php";

class composeMessage extends GlobalClass{
    public function __construct($db){
        parent::__construct("usermessages", $db);
    }
    public function addUserMessage($to, $subject, $message, $regdate, $from, $readflag, $send, $received){
        return $this->add(array("to"=>$to, "subject"=>$subject, "message"=>$message, "date"=>$regdate, "from"=>$from, "readflag"=>$readflag, "sender_deleted"=>$send, "receiver_deleted"=>$received));
    }
}
?>