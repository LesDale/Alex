<?php
require_once "config_class.php";
require_once "article_class.php";
require_once "section_class.php";
require_once "users_class.php";
require_once "menu_class.php";
require_once "banner_class.php";
require_once "message_class.php";

abstract class Modules{
	protected $config;
	protected $article;
	protected $section;
	protected $user;
	protected $menu;
	protected $banner;
	protected $message;
	protected $data;
	protected $user_info;
	
	public function __construct($db){
		session_start();
		$this->config=new Config();
		$this->article=new Article($db);
		$this->section=new Section($db);
		$this->user=new User($db);
		$this->menu=new Menu($db);
		$this->banner=new Banner($db);
		$this->message=new Message();
		$this->data = $this->secureData($_GET);
		$this->user_info = $this->getUser();
	}
	private function getUser(){
		$login=$_SESSION["login"];
		$password=$_SESSION["password"];
		if($this->user->checkUser($login, $password)) return $this->user->getUserOnLogin($login);
		else return false;
	}
	public function getContent(){
		$sr["title"] = $this->getTitle();
		$sr["meta_desc"] = $this->getDescription();
		$sr["meta_key"] = $this->getKeyWords();
		$sr["menu"] = $this->getMenu();
		$sr["auth_user"] = $this->getAuthUser();
		$sr["banners"] = $this->getBanners();
		$sr["top"] = $this->getTop();
		$sr["middle"] = $this->getMiddle();
		$sr["bottom"] = $this->getBottom();
		return $this->getReplaceTemplate($sr, "main");
	}
	abstract protected function getTitle();
	abstract protected function getDescription();
	abstract protected function getKeyWords();
	abstract protected function getMiddle();

	protected function getMenu(){
		$menu=$this->menu->getAll();
		for($i=0; $i<count($menu); $i++){
			$sr["title"]=$menu[$i]["title"];
			$sr["link"]=$menu[$i]["link"];
			$text .=$this->getReplaceTemplate($sr, "menu_item");
		}
		return $text;
	}
	protected function getAuthUser(){
		if($this->user_info){
			$sr["username"]=$this->user_info["login"];
			return $this->getReplaceTemplate($sr, "user_panel");
		}
		if($_SESSION["error_auth"]==1){
			$sr["message_auth"]=$this->getMessage("ERROR_AUTH");
			unset($_SESSION["error_auth"]);
		}
		else $sr["message_auth"]="";
		return $this->getReplaceTemplate($sr, "form_auth");
	}
	protected function getBanners(){
		$banners=$this->banner->getAll();
		for ($i=0; $i < count($banners); $i++){
			$sr["code"]=$banners[$i]["code"];
			$text .=$this->getReplaceTemplate($sr, "banner");
		}
		return $text;
	}
	protected function getTop(){
		return "";
	}
	protected function getBottom(){
		return "";
	}
	private function secureData($data){
		foreach($data as $key => $value){
			if(is_array($value)) $this->secureData($value);
			else $data[$key] = htmlspecialchars($value);
		}
		return $data;
	}
	protected function getBlogArticles($articles, $page){
		$start = ($page-1)*$this->config->count_blog;
		$end = (count($articles)>$start+$this->config->count_blog)? $start+$this->config->count_blog: count($articles);
		for($i=$start; $i<$end; $i++){
			$sr["title"]=$articles[$i]["title"];
			$sr["intro_image"]=$articles[$i]["article_images"];
			$sr["intro_text"]=$articles[$i]["intro_text"];
			$sr["date"]=$this->formatDate($articles[$i]["date"]);
			$sr["link_article"]=$this->config->address."?view=article&amp;id=".$articles[$i]["id"];
			$text .=$this->getReplaceTemplate($sr, "article_intro");
		}
		return $text;
	}
	protected function formatDate($time){
		return date("Y-m-d H:i:s", $time);
	}
	protected function getMessage($message=""){
		if($message=="") {
			$message = $_SESSION["message"];
			unset($_SESSION["message"]);
		}
		$sr["message"]=$this->message->getText($message);
		return $this->getReplaceTemplate($sr, "message_string");
	}
	protected function getPagination($count, $count_on_page, $link){
		$count_pages=ceil($count/$count_on_page);
		$sr["number"]=1;
		$sr["link"]=$link;
		$pages=$this->getReplaceTemplate($sr, "number_pages");
		$sym=(strpos($link, "?") !==false)? "&amp;": "?";
		for($i=2; $i<=$count_pages; $i++){
			$sr["number"]=$i;
			$sr["link"]=$link.$sym."page=$i";
			$pages .=$this->getReplaceTemplate($sr, "number_pages");
		}
		$els["number_pages"]=$pages;
		return $this->getReplaceTemplate($els, "pagination");
	}
	protected function getTemplate($name){
		$text=file_get_contents($this->config->dir_tmpl.$name.".tpl");
		return str_replace("%address%", $this->config->address, $text);
	}
	protected function getReplaceTemplate($sr, $template){
		return $this->getReplaceContent($sr, $this->getTemplate($template));
	}
	private function getReplaceContent($sr, $content){
		$search=array();
		$replace=array();
		$i=0;
		foreach($sr as $key=>$value){
			$search[$i]="%$key%";
			$replace[$i]=$value;
			$i++;
		}
		return str_replace($search, $replace, $content);
	}
	protected function redirect($link){
		header("Location: $link");
		exit;
	}
	protected function notFound(){
		$this->redirect($this->config->address."?view=notfound");
	}
}
?>