<?php
mb_internal_encoding("UTF-8");
require_once "lib/database_class.php";
require_once "lib/frontpagecontent_class.php";
require_once "lib/sectioncontent_class.php";
require_once "lib/articlecontent_class.php";
require_once "lib/regcontent_class.php";
require_once "lib/messagecontent_class.php";
require_once "lib/searchcontent_class.php";
require_once "lib/notfoundcontent_class.php";
require_once "lib/usercab_class.php";
require_once "lib/userarticles_class.php";
require_once "lib/usermessages_class.php";
require_once "lib/user_message_item_class.php";
require_once "lib/user_profile_edit_class.php";

$db= new DataBase();
$view= $_GET["view"];
switch($view){
	case "user_in_messages":
		$content = new UserMessages($db);
		echo $content->getInMessages();
		break;
	case "user_out_messages":
		$content = new UserMessages($db);
		echo $content->getOutMessages();
		break;
	case "delete_received_messages":
		$content = new UserMessages($db);
		echo $content->deleteReceivedMessages($_GET["messageids"]);
		break;
	case "delete_send_messages":
		$content = new UserMessages($db);
		echo $content->deleteSendMessages($_GET["messageids"]);
		break;
	case "user_search":
		$content = new SearchContent($db);
		echo $content->getFoundUsers($_GET["fuck"]);
		break;
	case "delete_avatar":
		$content = new UserProfileEdit($db);
		echo $content->deleteAvatar("c:/Denwer/home/Alex/www/avatar/", $_GET["an"]);
		break;
}
?>