<!DOCTYPE html PUBLIC "//-W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>%title%</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="description" content="%meta_desc%" />
<meta name="keywords" content="%meta_key%" />
<link rel="stylesheet" href="%address%css/main.css" type="text/css" />
<link rel="shortcut icon" href="http://tappedoutsecrets.ru/wp-content/themes/techworld/images/favicon.png" type="image/x-icon" />
	<script
			src="https://code.jquery.com/jquery-3.1.0.min.js"
			integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
			crossorigin="anonymous">

	</script>
</head>
<body>
<div id="container">
     <header>
		 <a href="./index.php" title="Главная сайта" id="logo"><img src="../images/kink.jpg" alt="Главная" title="" height="60"></a>
		 <nav>
			 <ul id="topmenu">
				 <li>
					 <a href="#"><span>Ссылка</span></a>
				 </li>
				 <li>
					 <a href="#" class="active"><span>Ссылка</span></a>
				 </li>
				 <li>
					 <a href="#"><span>Ссылка</span></a>
				 </li>
				 <li>
					 <a href="#"><span>Ссылка</span></a>
				 </li>
			 </ul>
		 </nav>
	 </header>
	<div id="top">
		<div class="clear"></div>
		<div id="search">
			<form name="search" action="%address%" method="get">
				<div>
					<input type="text" name="words" placeholder="Поиск"/>
				<input type="hidden" name="view" value="search" />
				<input type="submit" name="search" value="" />
				</div>
			</form>
		</div>
		%auth_user%
	</div>
	<div id="top_block">%top%</div>
<div id="content">
     <div id="left">
		 <div class="block">
			 <div class="header">Меню</div>
			 <div class="content">
				 <nav>
					 <div>
						 %menu%
					 </div>
				 </nav>
			 </div>
		 </div>
	 </div>
	 <div id="right">
		 <div class="block">
			 <div class="header">Реклама</div>
			 <div class="content">
				 <div>
					 %banners%
				 </div>
			 </div>
		 </div>
	 </div>
	 <div id="center">
		 <div class="main">
	     %middle%
		 %bottom%
		 </div>
	 </div>
	 <div class="clear"></div>
	 <div id="footer">
	     <p>Все права защищены &copy; 2016</p>
	 </div>
</div>
</div>
</body>
</html>