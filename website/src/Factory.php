<?php 

namespace igame02;

class Factory 
{
	private $config;
	public static function createFromIniFile($filename)
	{
		return new Factory(
			parse_ini_file($filename, true)
		);
	}
	public function __construct(array $config)
	{
		$this->config = $config;
	}
	
	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	
	public function getIndexController()
	{
		return new Controller\IndexController(
			$this->getTwigEngine()		
		);
	}
	
	
	public function getLoginController()
	{
		return new Controller\LoginController
		($this->getTwigEngine(), $this->getLoginService(), $this->getFuefs());
	}
	
	public function getPdo()
	{
		return new \PDO(
			"mysql:host=mariadb;dbname=app;charset=utf8",
			$this->config["database"]["user"],
			"my-secret-pw",
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
		);
	}
	
	
	public function getLoginService()
	{
		return new Service\Login\LoginPdoService($this->getPdo());
	}
	
	public function getFuefController(){
		return new Controller\FuefController($this->getTwigEngine(), $this->getFuefs(), $this);
	}
	
	
	public function getFuefs()
	{
		return new Service\Fuef\FuefPdoService($this->getPdo());
	}
	
	private function getTwigEngine()
	{
		$loader = new \Twig_Loader_Filesystem(__DIR__ . "/../templates/");
	
		return new \Twig_Environment($loader);
	}
	
	public function generateCsrf($csrfName)
	{
		$csrf = $this->generateString(50);
		$_SESSION[$csrfName . "csrf"] = $csrf;
		return $csrf;
	}
	
	private function generateString($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$length = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $characters[rand(0, $length - 1)];
		}
		return $randomString;
	}
}
