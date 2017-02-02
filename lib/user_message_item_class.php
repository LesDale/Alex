<?php
require_once "modules_class.php";
require_once "database_class.php";

class UserMessageItem extends Modules{
    private $db;
    protected $config;

    public function __construct($db){
        parent::__construct($db);
        $this->db=$db;
        $this->config=new Config();
    }
    protected function getTitle(){
        return "Личные сообщения";
    }
    protected function getDescription(){
        return "Новостной IT портал";
    }
    protected function getKeyWords(){
        return "новости it, справочник php функций";
    }
    protected function getTop(){
        $this->setAlreadyReadMessage();
    }
    protected function getMiddle(){
        return $this->getUserMessageItem();
    }
    public function getUserMessageItem(){
        $mesitem=$this->db->getAllOnField("usermessages", "id", $this->data["id"],"","");
        for($i=0; $i<count($mesitem); $i++){
            $sr["subject"]=$mesitem[$i]["subject"];
            $sr["message"]=$mesitem[$i]["message"];
            $sr["date"]=$this->formatDate($mesitem[$i]["date"]);
            $text .=$this->getReplaceTemplate($sr, "user_message_item");
        }
        return $text;
    }
    public function setAlreadyReadMessage(){
        return $this->db->setFieldOnId("usermessages", $this->data["id"], "readflag", 0);
    }
}
?>
