<?php
require_once "modules_class.php";
require_once "config_class.php";
require_once "user_message_item_class.php";

class UserMessages extends Modules{
    private $db;
    protected $config;
    protected $usmesitem;
    protected $messages;

    public function __construct($db){
        parent::__construct($db);
        $this->db=$db;
        $this->config=new Config();
        $this->usmesitem=new UserMessageItem($db);
        $this->messages=$this->getME("from");
    }
    protected function getTitle(){
        return "Личные сообщения";
    }
    protected function getDescription(){
        return "Справочник функций по PHP.";
    }
    protected function getKeyWords(){
        return "справочник php, справочник php функций";
    }
    protected function getUserMessages(){
        $text=str_replace("", "", $this->getTemplate("user_messages"));
        return $text;
        }
    protected function getMiddle(){
        return $this->getUserMessages();
    }
    protected function getInOutMessages($field){
        $where="`"."lesson_usermessages"."`"."."."`".$field."`"."=".$_SESSION["user_id"]." and ";
        if ($field=="to"){
            $where=$where."`lesson_usermessages`.`receiver_deleted`=1";
        }
        else {
            $where=$where."`lesson_usermessages`.`sender_deleted`=1";
        }
        //$mes=$this->db->getAllOnFields("usermessages", $where,"","");
        if($field=="to"){$key="from";}
        if($field=="from"){$key="to";}
        $mes=$this->db->selectWithJoin("usermessages","users", array("lesson_usermessages`.`id","lesson_usermessages`.`from","lesson_usermessages`.`to","lesson_usermessages`.`subject","lesson_usermessages`.`message","lesson_usermessages`.`readflag","lesson_usermessages`.`date","lesson_usermessages`.`sender_deleted","lesson_usermessages`.`receiver_deleted","lesson_users`.`login"),$key,"id", $where,"","");
        for($i=0; $i<count($mes); $i++){
            $sr["subject"]=$mes[$i]["subject"];
            $sr["message_id"]=$mes[$i]["id"];
            $sr["date"]=$this->formatDate($mes[$i]["date"]);
            $sr["read_flag"]=$mes[$i]["readflag"];
            $sr["name"]=$mes[$i]["login"];
            $sr["link_message"]=$this->config->address."?view=user_message_item&amp;id=".$mes[$i]["id"];
            $text .=$this->getReplaceTemplate($sr, "user_prevmessage_item");
        }
        return $text;
    }
    public function getInMessages(){
        $sr["messages"]=$this->getInOutMessages("to");
        $text .=$this->getReplaceTemplate($sr, "user_inout_messages");
        return $text;
    }
    public function getOutMessages(){
        $sr["messages"]=$this->getInOutMessages("from");
        $text .=$this->getReplaceTemplate($sr, "user_inout_messages");
        return $text;
    }
    public function deleteReceivedMessages($id){
        for($i=0; $i<count($id); $i++){
            $this->db->setFieldOnId("usermessages", $id[$i], "receiver_deleted", 0);
            if($result) return $this->returnPageMessage("SUCCESS_DELETE", $this->config->address."?view=message");
        }
    }
    public function deleteSendMessages($id){
        for($i=0; $i<count($id); $i++){
            $this->db->setFieldOnId("usermessages", $id[$i], "sender_deleted", 0);
            if($result) return $this->returnPageMessage("SUCCESS_DELETE", $this->config->address."?view=message");
        }
    }
    private function returnPageMessage($message, $r){
        $_SESSION["page_message"]=$message;
        return $r;
    }
    protected function getME($field){
        return $this->db->getAllOnField("usermessages", $field, $_SESSION["user_id"],"","");
    }
}
?>