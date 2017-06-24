<?php

namespace igame02\Controller;

use igame02\SimpleTemplateEngine;
use igame02\Service\Login\LoginService;

class LoginController 
{
  /**
   * @var igame02\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @var igame02\Service\Login\LoginService
   */
  private $loginService;
  
  /**
   * @param igame02\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, LoginService $loginService)
  {
     $this->template = $template;
     $this->loginService = $loginService;
  }
  
  public function showLogin()	
  {
  	//$csrf = $this->factory->generateCsrf("register");
  	echo $this->template->render("login.html.twig"/* ,["loginCsrf" => $csrf]*/);
  }
  
  public function showRegister($email = "", $username = "", $error = "")
  {
  	//$csrf = $this->factory->generateCsrf("register");
  	echo $this->template->render("register.html.twig"/*, ["registerCsrf" => $csrf, "email" => $email, "username" => $username, "error" => $error] */);
  }
  
  public function register(array $data)
  {
  	$error = "";
  	if(!isset($data["email"]) || trim($data["email"] == ''))
  	{
  		$error = $error."<br />Please enter a email!";
  	}
  	if(!isset($data["username"]) || trim($data["username"] == ''))
  	{
  		$error = $error."<br />Please enter a username!";
  	}
  	if(!isset($data["password"]) || trim($data["password"] == ''))
  	{
  		$error = $error."<br />Please enter a password!";
  	}
  	if ($this->loginService->existsEmail($data["email"]))
  	{
  		$error = $error."<br />Diese Email wurde bereits registriert!";
  	}
  	if(!isset($error["email"]) && !isset($error["username"]) && !isset($error["password"]))
  	{
  		$this->loginService->createUser($data["username"], $data["email"], $data["password"]);
  		echo $this->template->render("base.html.twig", [
  				"email" => $data["email"]
  		]);
  		return;
  	}
  	echo $this->showRegister($data["email"], $data["username"], $error);
  }

  
  public function login(array $data)
  {
  	if (!array_key_exists("email", $data) OR !array_key_exists("password", $data)) {
  		$this->showLogin();
  		return;
  	}
  	 
  	 
  	if($this->loginService->authenticate($data["email"], $data["password"])) {
  		//session_destroy();
  		//session_start();
  		$_SESSION["email"] = $data["email"];
  		echo $this->template->render("base.html.twig", [
  				"email" => $data["email"]
  		]);
  	} else {
  		echo $this->template->render("login.html.twig", [
  				"email" => $data["email"]
  		]);
  	}
  }
}












