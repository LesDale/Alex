<?php
require_once "modules_class.php";
require_once "config_class.php";

class UserProfile extends Modules{
   private $db;
    protected $config;

    public function __construct($db){
        parent::__construct($db);
       $this->db=$db;
       $this->config=new Config();
    }
    protected function getTitle(){
        return "Профиль";
    }
    protected function getDescription(){
        return "Справочник функций по PHP.";
    }
    protected function getKeyWords(){
        return "справочник php, справочник php функций";
    }
    protected function getMiddle(){
        return $this->getUserProfile();
    }
    private function getUserProfile(){
        $us=$this->db->getAllOnField("users", "id", $_SESSION["user_id"], "", "");
        for($i=0; $i<count($us); $i++){
            if($us[$i]["avatar"]==""){
                $sr["avatar"]="../avatar/default_avatar.jpg";
            }
            else{
                $sr["avatar"]=$us[$i]["avatar"];
            }
            $sr["login"]=$us[$i]["login"];
            $sr["id"]=$us[$i]["id"];
            $sr["regdate"]=$this->formatDate($us[$i]["regdate"]);
            $sr["%address%"]=$this->getTemplate("user_profile");
            $text .=$this->getReplaceTemplate($sr, "user_profile");
        }
        return $text;
    }
}
?>