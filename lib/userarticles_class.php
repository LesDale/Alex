<?php
require_once "modules_class.php";
require_once "database_class.php";
require_once "config_class.php";

class UserArticles extends Modules{
    private $db;
    protected $config;

    public function __construct($db){
        parent::__construct($db);
        $this->db=$db;
        $this->config=new Config();
    }
    protected function getTitle(){
        return "Записки сумасшедшего";
    }
    protected function getDescription(){
        return "Новостной IT портал";
    }
    protected function getKeyWords(){
        return "новости it, справочник php функций";
    }
    protected function getMiddle(){
        return $this->getUserArticles();
    }
    private function getUserArticles(){
        $art=$this->db->getAllOnFieldby("articles", "user_id", $_SESSION["user_id"],"","");
        for($i=0; $i<count($art); $i++){
            $sr["title"]=$art[$i]["title"];
            $sr["intro_image"]=$art[$i]["article_images"];
            $sr["intro_text"]=$art[$i]["intro_text"];
            $sr["date"]=$this->formatDate($art[$i]["date"]);
            $sr["link_article"]=$this->config->address."?view=article&amp;id=".$art[$i]["id"];
            $text .=$this->getReplaceTemplate($sr, "user_articles");
        }
        return $text;
    }
 }
?>