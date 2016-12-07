<?php
require_once "modules_class.php";
require_once "config_class.php";

class UserProfileEdit extends Modules{
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
        return $this->getUserProfileEdit();
    }
    private function getUserProfileEdit(){
        $us=$this->db->getAllOnField("users", "id", $_SESSION["user_id"], "", "");
        for($i=0; $i<count($us); $i++){
            $sr["message"]=$this->getMessage();
            if($us[$i]["avatar"]==""){
                $sr["avatar"]="../avatar/default_avatar.jpg";
            }
            else{
                $sr["avatar"]=$us[$i]["avatar"];
            }
            $sr["login"]=$us[$i]["login"];
            $sr["id"]=$us[$i]["id"];
            $sr["user_email"]=$us[$i]["email"];
            $text .=$this->getReplaceTemplate($sr, "user_profile_edit");
        }
        return $text;
    }
    public function deleteAvatar($path, $avaname){
        if($avaname=="default_avatar.jpg"){return false;}
        else {
            unlink($path.$avaname);
            $this->db->setFieldOnId("users", $_SESSION["user_id"], "avatar", "");
        }
    }
}
?>