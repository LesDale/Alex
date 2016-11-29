<?php
require_once "modules_class.php";

class UserCab extends Modules{
   private $db;

    public function __construct($db){
        parent::__construct($db);
       $this->db=$db;
    }
    protected function getTitle(){
        return "Личный кабинет";
    }
    protected function getDescription(){
        return "Справочник функций по PHP.";
    }
    protected function getKeyWords(){
        return "справочник php, справочник php функций";
    }
    protected function getMiddle(){
        return $this->getUserCab();
    }
    private function getUserCab(){
        return str_replace("", "", $this->getTemplate("user_cab"));
    }
}
?>