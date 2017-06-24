<?php

namespace igame02\Controller;

use igame02\SimpleTemplateEngine;

class IndexController 
{
  /**
   * @var igame02\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @param igame02\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template)
  {
     $this->template = $template;
  }

  public function homepage() {
  	echo $this->template->render("base.html.twig");
  }

  public function greet($name) {
  	echo $this->template->render("base.html.twig");
  }

  public function showHome()
  {
  	echo $this->template->render("base.html.twig");
  }
}
