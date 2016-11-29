<?php
require_once "global_class.php";

class composeMessage extends GlobalClass{
    public function __construct($db){
        parent::__construct("usermessages", $db);
    }
    public function addUserMessage($to, $subject, $message, $regdate, $from, $readflag, $login_from, $login_to, $send, $received){
        return $this->add(array("to"=>$to, "subject"=>$subject, "message"=>$message, "date"=>$regdate, "from"=>$from, "readflag"=>$readflag, "from_login"=>$login_from, "to_login"=>$login_to, "sender_deleted"=>$send, "receiver_deleted"=>$received));
    }
}
?>