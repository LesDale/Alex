<?php
require_once "lib/database_class.php";
require_once "lib/manage_class.php";

$db=new DataBase();
$manage=new Manage($db);
if($_POST["reg"]){
	$r=$manage->regUser();
}
elseif($_POST["auth"]){
	$r=$manage->login();
}
elseif($_GET["logout"]){
	$r=$manage->logout();
}
elseif($_POST["send"]){
	$r=$manage->sendUserMessage();
}
elseif($_POST["load"]) {
	$r=$manage->uploadAvatar($_POST["photos"]);
}
elseif($_POST["email_submit"]) {
	$r=$manage->getNewEmail();
}
elseif($_POST["password_submit"]) {
	$r=$manage->getNewPassword();
}
elseif($_POST["article_submit"]) {
	$r=$manage->newArticleCompose();
}
else exit;
$manage->redirect($r);
?>