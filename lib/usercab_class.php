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
        return "Новостной IT портал";
    }
    protected function getKeyWords(){
        return "новости it, справочник php функций";
    }
    protected function getMiddle(){
        return $this->getUserCab();
    }
    private function getUserCab(){
        return str_replace("", "", $this->getTemplate("user_cab"));
    }
}
?>