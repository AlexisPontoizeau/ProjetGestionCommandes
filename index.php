<?php
	$page= isset($_GET['page'])?$_GET['page']:"order";
	
	$controllerName= "controller".$page;
	
	if (!file_exists("controller/$controllerName.php")){
		$controllerName= "controllerorder";
	}
	
	include "controller/$controllerName.php";
	
	$controller = new $controllerName();
	
	$action= isset($_GET['action'])?$_GET['action']:"display";
	
	if(method_exists($controller, $action)){
			$controller->$action();
	}
	else {
		$controller->displayError("404");
	}
	
