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
require_once "lib/compmesscontent_class.php";
require_once "lib/user_message_item_class.php";
require_once "lib/user_profile_class.php";
require_once "lib/user_profile_edit_class.php";
require_once "lib/article_composecontent_class.php";

$db= new DataBase();
$view= $_GET["view"];
switch($view){
	case "":
	     $content = new FrontPageContent($db);
		 break;
	 case "section":
	     $content = new SectionContent($db);
		 break;
	 case "article":
	     $content = new ArticleContent($db);
		 break;
	 case "reg":
	     $content = new RegContent($db);
		 break;
	 case "message":
	     $content = new MessageContent($db);
		 break;
	case "search":
		$content = new SearchContent($db);
		break;
	case "notfound":
		$content = new NotFoundContent($db);
		break;
	case "user_cab":
		$content = new UserCab($db);
		break;
	case "user_articles":
		$content = new UserArticles($db);
		break;
	case "user_messages":
		$content = new UserMessages($db);
		break;
	case "user_message_item":
		$content = new UserMessageItem($db);
		break;
	case "compose_message":
		$content = new ComposeMessageContent($db);
		break;
	case "user_profile":
		$content = new UserProfile($db);
		break;
	case "user_profile_edit":
		$content = new UserProfileEdit($db);
		break;
	case "article_compose":
		$content = new ArticleComposeContent($db);
		break;
	 default: $content=new NotFoundContent($db);
}
echo $content->getContent();

?>