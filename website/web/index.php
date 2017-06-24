<?php

require_once("../vendor/autoload.php");
$factory = igame02\Factory::createFromIniFile(__DIR__ . "/../config.ini");

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->homepage();
		break;
	case "/login":
		$cnt = $factory->getLoginController();
		if($_SERVER["REQUEST_METHOD"] === "GET") {
			$cnt->showLogin();
		} else {
			$cnt->login($_POST);
		}
		break;
	case "/home":
		$cnt = $factory->getIndexController();
		if($_SERVER["REQUEST_METHOD"] === "GET") {
			$cnt->showHome();
		} else {
			
		}
		break;
	case "/register":
		$cnt = $factory->getLoginController();
		if($_SERVER["REQUEST_METHOD"] === "GET") {
			$cnt->showRegister();
		} else {
			$cnt->register($_POST);
		}
		break;
	case "/upload":
		$cnt = $factory->getFuefController();
		if($_SERVER["REQUEST_METHOD"] === "GET") {
			$cnt->showUpload();
		} else {
			
		}
		break;
	case "/fuef":
		$cnt = $factory->getFuefController();
		if($_SERVER["REQUEST_METHOD"] === "GET") {
			$cnt->showfuef();
		}
		else {
			
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

