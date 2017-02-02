<?php
require_once "modules_class.php";

class FrontPageContent extends Modules{
	private $articles;
	private $page;
	private $db;
	
	public function __construct($db){
		parent::__construct($db);
		$this->articles=$this->article->getAllSortDate();
		$this->page=(isset($this->data["page"]))? $this->data["page"]: 1;
		$this->db=$db;
	}
	protected function getTitle(){
		if($this->page>1) return "Справочник по PHP - Страница ".$this->page;
		else return "Справочник по PHP";
	}
	protected function getDescription(){
		return "Справочник функций по PHP.";
	}
	protected function getKeyWords(){
		return "справочник php, справочник php функций";
	}
	protected function getTop(){
		return $this->getTemplate("main_article");
	}
	protected function getMiddle(){
		return $this->getBlogArticles($this->articles, $this->page);
	}
	protected function getBottom(){
		return $this->getPagination (count($this->articles), $this->config->count_blog, $this->config->address);
	}
}
?>