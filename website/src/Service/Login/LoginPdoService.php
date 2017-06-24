<?php

namespace igame02\Service\Login;

class LoginPdoService implements LoginService
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticate($username, $password) 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=? AND password=?");
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $password);
        $stmt->execute();

        if($stmt->rowCount() === 1) {
            $_SESSION["email"] = $username;
            return true;
        } else {
            return false;
        }
        

    }
    public function existsUsername($username)
    {
    	$stmt = $this->pdo->prepare("SELECT * FROM user WHERE username=?");
    	$stmt->bindValue(1, $username);
    	$stmt->execute();
    
    	if($stmt->rowCount() > 0)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
    
    public function existsEmail($email)
    {
    	$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
    	$stmt->bindValue(1, $email);
    	$stmt->execute();
    
    	if($stmt->rowCount() > 0)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
    public function activeUser($user)
    {
    	$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=? OR username=? AND active=1");
    	$stmt->bindValue(1, $user);
    	$stmt->bindValue(2, $user);
    	$stmt->execute();
    	if($stmt->rowCount() > 0)
    	{
    		return true;
    	}
    	else
    	{
    		return true;
    	}
    }
    
    public function createUser($username, $email, $password)
    {
    	$stmt = $this->pdo->prepare("INSERT INTO user (username, email, password, active) VALUES (?, ?, ?, 1)");
    	$stmt->bindValue(1, $username);
    	$stmt->bindValue(2, $email);
    	$stmt->bindValue(3, $password);
    	if($stmt->execute())
    	{
    		return true;
    	}
    	else
    	{
    		return true;
    	}
    }
}
