<?php
require_once "config_class.php";
require_once "users_class.php";
require_once "compmess_class.php";
require_once "database_class.php";
require_once "article_compose_class.php";

class Manage{
	private $config;
	private $user;
	private $data;
	private $compmess;
	private $artcomp;
	protected $db;

	public function __construct($db){
		session_start();
		$this->config=new Config();
		$this->user=new User($db);
		$this->compmess=new composeMessage($db);
		$this->artcomp=new composeArticle($db);
		$this->data=$this->secureData(array_merge($_POST, $_GET));
		$this->db=$db;
	}
	private function secureData($data){
		foreach($data as $key => $value){
			if(is_array($value)) $this->secureData($value);
			else $data[$key] = htmlspecialchars($value);
		}
		return $data;
	}
	public function redirect($link){
		header("Location: $link");
		exit;
	}
	public function regUser(){
		$link_reg=$this->config->address."?view=reg";
		$captcha=$this->data["captcha"];
		if(($_SESSION["rand"] !=$captcha)&&($_SESSION["rand"] !="")){
			return $this->returnMessage("ERROR_CAPTCHA", $link_reg);
		}
		$login=$this->data["login"];
		if($this->user->isExistsUser($login)) return $this->returnMessage("EXISTS_LOGIN", $link_reg);
		$password=$this->data["password"];
		if($password == "") return $this->unknownError($link_reg);
		$password=$this->hashPassword($password);
		$result=$this->user->addUser($login, $password, time());
		if($result) return $this->returnPageMessage("SUCCESS_REG", $this->config->address."?view=message");
		else return $this->unknownError($link_reg);
	}
	public function login(){
		$login=$this->data["login"];
		$password=$this->data["password"];
		$password=$this->hashPassword($password);
		$r=$_SERVER["HTTP_REFERER"];
		if($this->user->checkUser($login, $password)){
			$user=$this->user->getUserOnLogin($login);
			$_SESSION["login"]=$login;
			$_SESSION["password"]=$password;
			$_SESSION["user_id"]=$user["id"];
			return $r;
		}
		else {
			$_SESSION["error_auth"]=1;
			return $r;
		}
	}
	public function logout(){
		unset($_SESSION["login"]);
		unset($_SESSION["password"]);
		return $_SERVER["HTTP_REFERER"];
	}
	public function sendUserMessage(){
		$to = $this->user->getUserID($this->data["to"]);
		if($this->db->isExists("usermessages", "to", $to)){
			$subject = $this->data["subject"];
			$message = $this->data["message"];
			if($subject == "") return $this->returnMessage("NOT_FOUND_SUBJECT", $this->config->address."?view=compose_message");
			if($message == "") return $this->returnMessage("NOT_FOUND_MESSAGE", $this->config->address."?view=compose_message");
			$result = $this->compmess->addUserMessage($to, $subject, $message, time(), $_SESSION["user_id"], 1, 1, 1);
			if ($result) return $this->returnPageMessage("SUCCESS_COMPOSE", $this->config->address . "?view=message");
		}
		else{
			return $this->returnMessage("NOT_FOUND_LOGIN", $this->config->address."?view=compose_message");
		}
	}
	public function uploadAvatar($files){
		if($files=="")return $this->returnMessage("ERROR_AVATAR_UPLOAD", $this->config->address."?view=user_profile_edit");
		foreach ($files as $n => $fileBody) {
			$fileName = time().$n; // генерируем название файла
			$path="c:/Denwer/home/Alex/www/avatar/";
			$uploadfile=$path.$fileName;

			// определяем формат файла
			preg_match('#data:image\/(png|jpg|jpeg|gif);#', $fileBody, $fileTypeMatch);
			$fileType = $fileTypeMatch[1];//расширение файла

			// декодируем содержимое файла
			$fileBody = preg_replace('#^data.*?base64,#', '', $fileBody);
			$fileBody = base64_decode($fileBody);

			// сохраем файл
			$success=file_put_contents($uploadfile.'.'.$fileType, $fileBody);
			if($success) {
				$dbava=$this->db->getFieldOnId("users", $_SESSION["user_id"], "avatar");
				if(!$dbava==""){unlink($path.$dbava);}
				$this->db->setFieldOnId("users", $_SESSION["user_id"], "avatar", "$fileName.$fileType");
				return $this->config->address."?view=user_profile_edit";
			}
			if(!$success) return $this->returnMessage("ERROR_AVATAR_UPLOAD", $this->config->address."?view=user_profile_edit");

		}
	}
	
	public function getNewEmail(){
		$ne = $this->data["new_email"];
		if((!preg_match("/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i", $ne))){return $this->returnMessage("ERROR_USER_EMAIL", $this->config->address."?view=user_profile_edit");}
		$this->db->setFieldOnId("users", $_SESSION["user_id"], "email", $ne);
		return $this->config->address."?view=user_profile_edit";
	}
	public function getNewPassword(){
		$op=$this->data["old_password"];
		$op=$this->hashPassword($op);
		$np=$this->data["new_password"];
		$np=$this->hashPassword($np);
		$rp=$this->data["repeat_password"];
		$rp=$this->hashPassword($rp);
		if($this->db->isExists("users", "password", $op)){
			if($np==$rp){
				$this->db->setFieldOnId("users", $_SESSION["user_id"], "password", $np);
				return $this->returnMessage("NEW_PASSWORD_SUCCESS", $this->config->address."?view=user_profile_edit");
			}
		}
	}
	public function newArticleCompose(){
		foreach ($this->data["photos"] as $n => $fileBody) {
			$fileName = time().$n; // генерируем название файла
			$path="c:/Denwer/home/Alex/www/images/artimg/";
			$uploadfile=$path.$fileName;

			// определяем формат файла
			preg_match('#data:image\/(png|jpg|jpeg|gif);#', $fileBody, $fileTypeMatch);
			$fileType = $fileTypeMatch[1];//расширение файла

			// декодируем содержимое файла
			$fileBody = preg_replace('#^data.*?base64,#', '', $fileBody);
			$fileBody = base64_decode($fileBody);

			// сохраем файл
			$success=file_put_contents($uploadfile.'.'.$fileType, $fileBody);
		}
		if($this->data["select1"]=="Строковые функции"){$secid="1";}
		if($this->data["select1"]=="Математические функции"){$secid="2";}
		if($this->data["select1"]=="Функции даты и времени"){$secid="3";}
		$title=$this->data["title"];
		$prevtext=$this->data["prevtext"];
		$artimg="$fileName.$fileType";
		$fullart=$this->data["fullart"];
		$result=$this->artcomp->addUserArticle($secid, $_SESSION["user_id"], $title, $prevtext, $artimg, $fullart, time());
		if ($result) return $this->returnMessage("SUCCESS_COMPOSE_ART", $this->config->address . "?view=article_compose");
	}
	private function hashPassword($password){
		return md5($password.$this->config->secret);
	}
	private function unknownError($r){
		return $this->returnMessage("UNKNOWN_ERROR", $r);
	}
	private function returnMessage($message, $r){
		$_SESSION["message"]=$message;
		return $r;
	}
	private function returnPageMessage($message, $r){
		$_SESSION["page_message"]=$message;
		return $r;
	}
}
?>