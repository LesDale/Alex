<?php
require_once "modules_class.php";

class ArticleComposeContent extends Modules{
   private $db;

    public function __construct($db){
        parent::__construct($db);
       $this->db=$db;
    }
    protected function getTitle(){
        return "Разместить статью";
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
        $sr["message_compose"]=$this->getMessage();
        return $this->getReplaceTemplate($sr, "compose_article");
    }
}
?>