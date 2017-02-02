<?php
require_once "modules_class.php";

class RegContent extends Modules{
		
	public function __construct($db){
		parent::__construct($db);
		
	}
	protected function getTitle(){
		return "Регистрация";
	}
	protected function getDescription(){
		return "Регистрация";
	}
	protected function getKeyWords(){
		return "регистрация сайт, регистрация пользователь сайт";
	}
	
	protected function getMiddle(){
		$sr["message"]=$this->getMessage();
		$sr["login"]=$_SESSION["login"];
		return $this->getReplaceTemplate($sr, "form_reg");
	}
}
?>