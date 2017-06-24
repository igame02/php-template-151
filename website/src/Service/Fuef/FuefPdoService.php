<?php
namespace igame02\Service\Fuef;


class FuefPdoService implements FuefService
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	public function getFuef()
	{
		$stmt = $this->pdo->prepare("SELECT FIRST FROM FUEF ORDER BY RAND()");
		$stmt->execute();
		return $stmt->fetch()["word"];
	}

	public function addFuef($word)
	{
		//$stmt = $this->pdo->prepare("INSERT INTO word (word) VALUES (?)");
		//$stmt->bindValue(1, $word);
		//$stmt->execute();
	}
}