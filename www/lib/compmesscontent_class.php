<?php
require_once "modules_class.php";

class ComposeMessageContent extends Modules{
    private $db;

    public function __construct($db){
        parent::__construct($db);
        $this->db=$db;
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
    protected function getMiddle(){
        return $this->getUserMessages();
    }
    protected function getUserMessages(){
        $sr["message_compose"]=$this->getMessage();
        return $this->getReplaceTemplate($sr, "compose_message");
    }
}
?>