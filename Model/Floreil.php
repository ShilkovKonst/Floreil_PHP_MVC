<?php

namespace Floreil_PHP_MVC\Model;

class Shop
{
  protected $oDb;

  public function __construct()
  {
    $this->oDb = new \Floreil_PHP_MVC\Engine\Db;
  }
  //get some product according custom limits (good for pagination etc)
  public function get($iOffset, $iLimit)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Plantes ORDER BY createdDate DESC LIMIT :offset, :limit');
    $oStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
    $oStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
    $oStmt->execute();
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }
  //get specific product
  public function getById($iId)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Plantes WHERE idPlante = :postId LIMIT 1');
    $oStmt->bindParam(':postId', $iId, \PDO::PARAM_INT);
    $oStmt->execute();
    return $oStmt->fetch(\PDO::FETCH_OBJ);
  }
  // get all products
  public function getAll()
  {
    $oStmt = $this->oDb->query('SELECT * FROM Plantes ORDER BY createdDate DESC');
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function isAdmin($sEmail)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Utilisateurs WHERE email_Utilisateur = :email LIMIT 1');
    $oStmt->bindValue(':email', $sEmail, \PDO::PARAM_STR);
    $oStmt->execute();
    return $oStmt->fetch(\PDO::FETCH_OBJ);
  }

  public function login($sEmail, $sPassword)
  {
    $a = [
      'email' => $sEmail,
      'password' => sha1($sPassword) // encryption de mdp
    ];
    $oStmt = $this->oDb->prepare("SELECT * FROM Utilisateurs WHERE email_Utilisateur = :email AND password_Utilisateur = :password ");
    $oStmt->execute($a);
    return $oStmt->rowCount();
  }

  public function usernameTaken($username)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Utilisateurs WHERE username_Utilisateur = :username');
    $oStmt->bindParam(':username', $username, \PDO::PARAM_STR);
    $oStmt->execute();
    return $oStmt->rowCount();
  }  

  public function emailTaken($sEmail)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Utilisateurs WHERE email_Utilisateur = :email');
    $oStmt->bindParam(':email', $sEmail, \PDO::PARAM_STR);
    $oStmt->execute();
    return $oStmt->rowCount();
  }

  public function getUserId($userId)
  {
    $oStmt = $this->oDb->prepare('SELECT id FROM Utilisateurs WHERE username_Utilisateur = :username');
    $oStmt->bindParam(':username', $username, \PDO::PARAM_STR);
    $oStmt->execute();
    return $oStmt->fetch(\PDO::FETCH_OBJ);
  }
}