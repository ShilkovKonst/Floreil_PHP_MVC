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

  public function getCategorie($iIdCat)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Categories WHERE idCategorie = :idCat');
    $oStmt->bindParam(':idCat', $iIdCat, \PDO::PARAM_INT);
    $oStmt->execute();
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getPlantesByCategories($iIdCat)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Plantes WHERE idCategorie = :idCat');
    $oStmt->bindParam(':idCat', $iIdCat, \PDO::PARAM_INT);
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
    $oStmt->bindParam(':planteId', $iPlanteId, \PDO::PARAM_INT);
    $oStmt->execute();
    return $oStmt->fetch(\PDO::FETCH_OBJ);
  }

  // get all products
  public function getAllPlantes()
  {
    $oStmt = $this->oDb->query('SELECT * FROM Plantes ORDER BY createdDate_Plante DESC');
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getAllPlantesPanierByUserID($iUserID)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM ajouter_au_panier WHERE idUtilisateur = :idUtilisateur');
    $oStmt->bindParam(':idUtilisateur', $iUserID, \PDO::PARAM_INT);
    $oStmt->execute();
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getTotalSumPanier($iUserID)
  {
    $totalPrix = 0;
    $oStmt = $this->oDb->prepare('SELECT prixPourQnty_plante FROM ajouter_au_panier WHERE idUtilisateur = :idUtilisateur');
    $oStmt->bindParam(':idUtilisateur', $iUserID, \PDO::PARAM_INT);
    $oStmt->execute();
    foreach ($oStmt->fetchAll(\PDO::FETCH_OBJ) as $prix)
      $totalPrix += $prix->prixPourQnty_plante;
    return $totalPrix;
  }

  public function getSpecificPlantePanierByUserID($iUserID, $iPlanteID)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM ajouter_au_panier WHERE idUtilisateur = :idUtilisateur AND idPlante = :idPlante');
    $oStmt->bindParam(':idUtilisateur', $iUserID, \PDO::PARAM_INT);
    $oStmt->bindParam(':idPlante', $iPlanteID, \PDO::PARAM_INT);
    $oStmt->execute();
    return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function userIsAdmin($sEmail)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Utilisateurs WHERE email_Utilisateur = :email LIMIT 1');
    $oStmt->bindParam(':email', $sEmail, \PDO::PARAM_STR);
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

  public function usernameTaken($sUsername)
  {
    $oStmt = $this->oDb->prepare('SELECT * FROM Utilisateurs WHERE username_Utilisateur = :username');
    $oStmt->bindParam(':username', $sUsername, \PDO::PARAM_STR);
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
  public function getUserID($username)
  {
    $oStmt = $this->oDb->prepare('SELECT idUtilisateur FROM Utilisateurs WHERE username_Utilisateur = :username');
    $oStmt->bindParam(':username', $username, \PDO::PARAM_STR);
    $oStmt->execute();
    return $oStmt->fetch(\PDO::FETCH_OBJ);
  }

  //remade Patrick's method according to my Comments table
  public function getComments()
  {
    $oStmt = $this->oDb->prepare("
    SELECT  
            poster_comment.idUtilisateur,
            poster_comment.title_Comment,
            poster_comment.body_Comment,
            poster_comment.idPlante,
            poster_comment.date_Comment,
            Utilisateurs.username_Utilisateur
    FROM poster_comment
    JOIN Utilisateurs
    ON poster_comment.idUtilisateur = Utilisateurs.idUtilisateur
    WHERE poster_comment.idPlante = :idPlante
    ORDER BY poster_comment.date_Comment DESC
       ");
    $oStmt->bindParam(':idPlante', $_GET['id'], \PDO::PARAM_INT);
    $oStmt->execute();
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
    $oStmt = $this->oDb->prepare('
    INSERT INTO 
    poster_comment (idUtilisateur, title_Comment, body_Comment, idPlante) 
    VALUES
    (:idUtilisateur, :title_Comment, :body_Comment, :idPlante)');
    $oStmt->bindParam(':idUtilisateur', $aData['idUtilisateur'], \PDO::PARAM_INT);
    $oStmt->bindParam(':title_Comment', $aData['title_Comment'], \PDO::PARAM_STR);
    $oStmt->bindParam(':body_Comment', $aData['body_Comment'], \PDO::PARAM_STR);
    $oStmt->bindParam(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
    return $oStmt->execute();
  }

  public function addPanierPlante(array $aData)
  {
    $oStmt = $this->oDb->prepare('
    INSERT INTO
        ajouter_au_panier (idPlante, idUtilisateur, title_PlantePanier, image_PlantePanier, qnty_plantePanier, qnty_planteStock, prixPourQnty_plante)
    VALUES     
      (:idPlante, :idUtilisateur, :title_PlantePanier, :image_PlantePanier, :qnty_plantePanier, :qnty_planteStock, :prixPourQnty_plante)');
    $oStmt->bindParam(':idUtilisateur', $aData['idUtilisateur'], \PDO::PARAM_INT);
    $oStmt->bindParam(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
    $oStmt->bindParam(':title_PlantePanier', $aData['title_PlantePanier'], \PDO::PARAM_STR);
    $oStmt->bindParam(':image_PlantePanier', $aData['image_PlantePanier'], \PDO::PARAM_STR);
    $oStmt->bindParam(':qnty_plantePanier', $aData['qnty_plantePanier'], \PDO::PARAM_INT);
    $oStmt->bindParam(':qnty_planteStock', $aData['qnty_planteStock'], \PDO::PARAM_INT);
    $oStmt->bindParam(':prixPourQnty_plante', $aData['prixPourQnty_plante'], \PDO::PARAM_INT);
    return $oStmt->execute();
  }

  public function createFacture(array $aData)
  {
    $oStmt = $this->oDb->prepare('
    INSERT INTO
    facture (numero_Facture, montantPanier_Facture, document_Facture, idUtilisateur)
    VALUES     
      (:numero_Facture, :montantPanier_Facture, :document_Facture, :idUtilisateur)');
    $oStmt->bindParam(':numero_Facture', $aData['numero_Facture'], \PDO::PARAM_INT);
    $oStmt->bindParam(':montantPanier_Facture', $aData['montantPanier_Facture'], \PDO::PARAM_STR);
    $oStmt->bindParam(':document_Facture', $aData['document_Facture'], \PDO::PARAM_STR);
    $oStmt->bindParam(':idUtilisateur', $aData['idUtilisateur'], \PDO::PARAM_INT);
    return $oStmt->execute();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  ////////////////////////////_____UPDATE_____//////////////////////////////////////////////////////////////////////////////////
  public function editComment(array $aData)
  {
    $oStmt = $this->oDb->prepare('
    UPDATE 
        poster_comment 
    SET     
        title_Comment = :title_Comment, 
        body_Comment = :body_Comment  
    WHERE 
        idUtilisateur = :idUtilisateur 
      AND
        idPlante = :idPlante');
    $oStmt->bindParam(':idUtilisateur', $aData['idUtilisateur'], \PDO::PARAM_INT);
    $oStmt->bindParam(':title_Comment', $aData['title_Comment'], \PDO::PARAM_STR);
    $oStmt->bindParam(':body_Comment', $aData['body_Comment'], \PDO::PARAM_STR);
    $oStmt->bindParam(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
    return $oStmt->execute();
  }

  public function updateQntyPlante(array $aData)
  {
    $oStmt = $this->oDb->prepare('
    UPDATE 
        Plantes 
    SET 
        qnty_Plante = :qnty_Plante
    WHERE 
        idPlante = :idPlante 
    LIMIT 1');
    $oStmt->bindParam(':qnty_Plante', $aData['qnty_Plante'], \PDO::PARAM_INT);
    $oStmt->bindParam(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
    return $oStmt->execute();
  }

  public function changePanierPlante(array $aData)
  {
    $oStmt = $this->oDb->prepare('
    UPDATE 
        ajouter_au_panier 
    SET     
        qnty_plantePanier = :qnty_plantePanier,
        prixPourQnty_plante = :prixPourQnty_plante
    WHERE 
        idUtilisateur = :idUtilisateur 
      AND
        idPlante = :idPlante');
    $oStmt->bindParam(':idUtilisateur', $aData['idUtilisateur'], \PDO::PARAM_INT);
    $oStmt->bindParam(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
    $oStmt->bindParam(':qnty_plantePanier', $aData['qnty_plantePanier'], \PDO::PARAM_INT);
    $oStmt->bindParam(':prixPourQnty_plante', $aData['prixPourQnty_plante'], \PDO::PARAM_INT);
    return $oStmt->execute();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  ////////////////////////////_____DELETE_____//////////////////////////////////////////////////////////////////////////////////

  public function deleteUser(array $aData)
  {
    $oStmt = $this->oDb->prepare('DELETE FROM Utilisateurs WHERE email_Utilisateur = :email AND password_Utilisateur = :password');
    $oStmt->bindParam(':email', $aData['userEmail'], \PDO::PARAM_STR);
    $oStmt->bindParam(':password', $aData['userPassword'], \PDO::PARAM_STR);
    return $oStmt->execute();
  }

  public function deletePanierPlante(array $aData)
  {
    $oStmt = $this->oDb->prepare('DELETE FROM ajouter_au_panier WHERE idPlante = :idPlante AND idUtilisateur = :idUtilisateur LIMIT 1');
    $oStmt->bindParam(':idUtilisateur', $aData['idUtilisateur'], \PDO::PARAM_INT);
    $oStmt->bindParam(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
    return $oStmt->execute();
  }

  public function deleteAllPanierPlantes($userID)
  {
    $oStmt = $this->oDb->prepare('DELETE FROM ajouter_au_panier WHERE idUtilisateur = :idUtilisateur');
    $oStmt->bindParam(':idUtilisateur', $userID, \PDO::PARAM_INT);
    return $oStmt->execute();
  }

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
