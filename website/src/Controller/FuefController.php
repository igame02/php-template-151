<?php

namespace igame02\Controller;
use igame02\SimpleTemplateEngine;
use igame02\Service\Game\GameService;
use igame02\Service\Fuef\FuefPdoService;
class FuefController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $FuefService;
  private $factory;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, FuefPdoService $fuefService, $factory)
  {
     $this->template = $template;
     $this->fuefService = $fuefService;
     $this->factory = $factory;
  }
  
  public function showFuef($error = "", $info= ""){
	echo $this->template->render("fuef.html.twig", ["error" => $error, "info" => $info]);
  }
  public function getfuef(){
	$word = "Sorry, hadn't enough time to make the game. Here's a random Word: ".$this->gameService->getRandomWord();
	echo $this->template->render("hangman.html.twig", ["word" => $word]);
  }
  public function addfuef(array $data) {
	$info = "";
	$error = "";
	
	$this->fuefService->addfuef($data["inputWord"]);
	$info = "Füf successfully added";
	
	$this->showGame($error, $info);
	return;
  }
}