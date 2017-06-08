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
  public function __construct(SimpleTemplateEngine $template, LoginService $loginService)
  {
     $this->template = $template;
     $this->loginService = $loginService;
  }
  
  public function showLogin($username = "", $errormessage = "")
  {
  	 echo $this->template->render("login.html.twig");
  }
  
  public function showRegister($email = "", $username = "", $errormessage = "", $confirmation = false)
  {
  	$csrf = $this->factory->generateCsrf("register");
  	echo $this->template->render("register.html.twig", ["registercsrf" => $csrf, "email" => $email, "username" => $username, "errormessage" => $errormessage, "confirm" => $confirmation]);
  }
  
  public function register(array $data)
  {
  	if (!array_key_exists("registercsrf", $data) && !isset($data["registercsrf"]) && trim($data["registercsrf"]) == '' && $_SESSION["registercsrf"] != $data["registercsrf"])
  	{
  		$this->showRegister();
  		return;
  	}
  	 
  	if (!array_key_exists("email", $data) OR !array_key_exists("password", $data) OR !array_key_exists("username", $data))
  	{
  		$this->showRegister();
  		return;
  	}
  	
  	$this->showRegister();
  	return;
  }
  
  public function login(array $data)
  {
  	if(!array_key_exists("email", $data) OR !array_key_exists("password", $data)) {
  		$this->showLogin();
  		return;
  	}
  	
  	if($this->loginService->authenticate($data["email"], $data["password"])) {
  		header("Location: /");
  	} else {
  		echo $this->template->render("login.html.twig", [
  			"email" => $data["email"]		
  		]);
  	}
  }
}












