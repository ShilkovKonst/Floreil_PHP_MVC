<?php

namespace Floreil_PHP_MVC\Model;

class Admin extends Shop
{

    /////////////////////______READ______////////////////////////////////////////

    public function inTable($sTable)
    {
        $oStmt = $this->oDb->query("SELECT COUNT(id) FROM $sTable");
        return $oStmt->fetch();
    }
/////////////////////////////////////////////////////////////////////////////

/////////////////////_____UPDATE_____////////////////////////////////////////

public function updatePlante(array $aData)
  {
    $oStmt = $this->oDb->prepare('
    UPDATE 
        Plantes 
    SET 
        title_Plante = :title, description_Plante = :description, 
        prix_Plante = :price, qnty_Plante = :qnty, 
        nomCommun_Plante = :nomCommun, genre_Plante = :genre, 
        espece_Plante = :espece, variete_Plante = :variete,
        famille_Plante = :famille, hauteurCM_Plante = :hauteurCM,
        feillage_Plante = :feillage, arrosage_Plante = :arrosage,
        floraison_Plante = :floraison, floraisonParfumee_Plante = :floraisonParfume,
        modeVie_Plante = :modeVie, resistanceFroid_Plante = :resFroid,
        resistanceFroidBas_Plante = resFroidBas, resistanceFroidHaut_Plante = resFroidHaut,

    WHERE 
        idPlante = :idPlante 
    LIMIT 1');
    $oStmt->bindValue(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
    $oStmt->bindValue(':title', $aData['title'], \PDO::PARAM_STR);
    $oStmt->bindValue(':description', $aData['description'], \PDO::PARAM_LOB);
    $oStmt->bindValue(':price', $aData['price'], \PDO::PARAM_LOB);
    $oStmt->bindValue(':qnty', $aData['qnty'], \PDO::PARAM_LOB);
    $oStmt->bindValue(':nomCommun', $aData['nomCommun'], \PDO::PARAM_STR);
    $oStmt->bindValue(':genre', $aData['genre'], \PDO::PARAM_STR);
    $oStmt->bindValue(':espece', $aData['espece'], \PDO::PARAM_STR);
    $oStmt->bindValue(':variete', $aData['variete'], \PDO::PARAM_STR);
    $oStmt->bindValue(':famille', $aData['famille'], \PDO::PARAM_STR);
    $oStmt->bindValue(':hauteurCM', $aData['hauteurCM'], \PDO::PARAM_INT);
    $oStmt->bindValue(':feuillage', $aData['feuillage'], \PDO::PARAM_STR);
    $oStmt->bindValue(':arrosage', $aData['arrosage'], \PDO::PARAM_STR);    
    $oStmt->bindValue(':floraison', $aData['floraison'], \PDO::PARAM_STR);
    $oStmt->bindValue(':floraisonParfume', $aData['floraisonParfume'], \PDO::PARAM_STR);
    $oStmt->bindValue(':modeVie', $aData['modeVie'], \PDO::PARAM_STR);
    $oStmt->bindValue(':resFroid', $aData['resFroid'], \PDO::PARAM_STR);
    $oStmt->bindValue(':resFroidBas', $aData['resFroidBas'], \PDO::PARAM_STR);
    $oStmt->bindValue(':resFroidHaut', $aData['resFroidHaut'], \PDO::PARAM_STR);
    return $oStmt->execute();
  }
}