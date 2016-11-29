<?php
require_once "global_class.php";
class composeArticle extends GlobalClass{
    public function __construct($db){
        parent::__construct("articles", $db);
    }
    public function addUserArticle($secid, $user_id, $title, $prevtext, $artimg, $fullart, $date){
        return $this->add(array("section_id"=>$secid, "user_id"=>$user_id, "title"=>$title, "intro_text"=>$prevtext, "article_images"=>$artimg, "full_text"=>$fullart, "meta_desc"=>$title, "date"=>$date));
    }
}
?>