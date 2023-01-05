<?php

namespace Floreil_PHP_MVC\Model;

class Shop
{
  protected $oDb;

  public function __construct()
  {
    $this->oDb = new \Floreil_PHP_MVC\Engine\Db;
  }

  /////////////////////////////////_______READ_______//////////////////////////////////////////////////////////////////
  public function getCategories()
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Categories ORDER BY idCategorie ASC');
    $oStmt->execute();
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }
  public function getPlantesByCategories($iIdCat)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Plantes WHERE idCategorie = :idCat');
    $oStmt->bindValue(':idCat', $iIdCat, \PDO::PARAM_INT);
    $oStmt->execute();
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }

  //get some product according custom limits (good for pagination etc)
  // public function getSomePlantes($iOffset, $iLimit)
  // {
  //   $oStmt = $this->oDb->prepare('SELECT * FROM Plantes ORDER BY createdDate DESC LIMIT :offset, :limit');
  //   $oStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
  //   $oStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
  //   $oStmt->execute();
  //   return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  // }

  //get specific product
  public function getPlanteById($iPlanteId)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Plantes WHERE idPlante = :planteId LIMIT 1');
    $oStmt->bindValue(':planteId', $iPlanteId, \PDO::PARAM_INT);
    $oStmt->execute();
    return $oStmt->fetch(\PDO::FETCH_OBJ);
  }

  // get all products
  public function getAllPlantes()
  {
    $oStmt = $this->oDb->query('SELECT * FROM Plantes ORDER BY createdDate_Plante DESC');
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }

  

  public function userIsAdmin($sEmail)
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
  // this is Patrick's code, don't understand logic 
  public function getUserId($username)
  {
    $oStmt = $this->oDb->prepare('SELECT idUtilisateur FROM Utilisateurs WHERE username_Utilisateur = :username');
    $oStmt->bindParam(':username', $username, \PDO::PARAM_STR);
    $oStmt->execute();
    return $oStmt->fetch(\PDO::FETCH_OBJ);
  }

  //remade Patrick's method according to my Comments table
  public function getComments()
  {
    $oStmt = $this->oDb->query("
    SELECT  
            Utilisateurs.idUtilisateur,
            poster_comment.idUtilisateur,
            poster_comment.title_Comment,
            poster_comment.body_Comment,
            poster_comment.idPlante,
            poster_comment.date_Comment,
            Utilisateurs.username_Utilisateur,
    FROM poster_comment
    JOIN Utilisateurs
    ON poster_comment.idUtilisateur = Utilisateurs.idUtilisateur
    WHERE idPlante = '{$_GET['id']}'
    ORDER BY date DESC
       ");
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // this is my code based on Patrick's code 
  // public function getUserId($userId)
  // {
  //   $oStmt = $this->oDb->prepare('SELECT idUtilisateur FROM Utilisateurs WHERE idUtilisateur = :userId');
  //   $oStmt->bindParam(':userId', $userId, \PDO::PARAM_STR);
  //   $oStmt->execute();
  //   return $oStmt->fetch(\PDO::FETCH_OBJ);
  // }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /////////////////////////////_______CREATE_______////////////////////////////////////////////////////////////////////////

  public function addUser($aData)
  {
    $oStmt = $this->oDb->prepare('
    INSERT INTO Utilisateurs 
    (nom_Utilisateur, prenom_Utilisateur , 
    email_Utilisateur, telMob_Utilisateur, 
    username_Utilisateur, password_Utilisateur, 
    batimentAdresse_Utilisateur, rueAdresse_Utilisateur, 
    codePostaleAdresse_Utilisateur, villeAdresse_Utilisateur, 
    paysAdresse_Utilisateur) 
    VALUES
    (:surname, :name, 
    :email, :telMob, 
    :username, :password, 
    :houseAdresse, :streetAdresse, 
    :ZIPAdresse, :cityAdresse, :countryAdresse)');
    return $oStmt->execute($aData);
  }

  public function addComment(array $aData)
  {
    $oStmt = $this->oDb->prepare('INSERT INTO poster_comment (idUtilisateur, title_Comment, body_Comment, idPlante) VALUES(:user_id, :title, :comment, :plante_id');
    return $oStmt->execute($aData);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  ////////////////////////////_____UPDATE_____//////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  ////////////////////////////_____DELETE_____//////////////////////////////////////////////////////////////////////////////////

  public function deleteUser($aData)
  {
    $oStmt = $this->oDb->prepare('DELETE FROM Utilisateurs WHERE email_Utilisateur = :email AND password_Utilisateur = :password');
    $oStmt->bindParam(':email', $aData['userEmail'], \PDO::PARAM_STR);
    $oStmt->bindParam(':password', $aData['userPassword'], \PDO::PARAM_STR);
    return $oStmt->execute();
  }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}