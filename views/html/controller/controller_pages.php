<?php
	switch($_GET['module']){
		case "controller_home";
			include("module/home/controller/".$_GET['module'].".php");
			break;
		case "controller_shop";
			include("module/shop/controller/".$_GET['module'].".php");
			break;
		case "contacto";
			include("views/html/contact.php");
			break;
		case "404";
			include("error".$_GET['seccion'].".php");
			break;
		case "503";
			include("error".$_GET['seccion'].".php");
			break;
		case "ia";
			include("views/html/ia.php");
			break;
		default;
		include("module/curso/controller/controller_home.php");
        break;
	}
?>