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
        nomCommun_Plante = :nomCommun, hauteurCM_Plante = :hauteurCM,
        feillage_Plante = :feillage, arrosage_Plante = :arrosage,
        floraison_Plante = :floraison, floraisonParfumee_Plante = :floraisonParfume,
        modeVie_Plante = :modeVie, resistanceFroid_Plante = :resFroid,
        resistanceFroidBas_Plante = :resFroidBas, resistanceFroidHaut_Plante = :resFroidHaut
    WHERE 
        idPlante = :idPlante 
    LIMIT 1');
        $oStmt->bindValue(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
        $oStmt->bindValue(':title', $aData['title'], \PDO::PARAM_STR);
        $oStmt->bindValue(':description', $aData['description'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':price', $aData['price'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':qnty', $aData['qnty'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':nomCommun', $aData['nomCommun'], \PDO::PARAM_STR);
        $oStmt->bindValue(':hauteurCM', $aData['hauteurCM'], \PDO::PARAM_INT);
        $oStmt->bindValue(':feuillage', $aData['feuillage'], \PDO::PARAM_STR);
        $oStmt->bindValue(':arrosage', $aData['arrosage'], \PDO::PARAM_STR);
        $oStmt->bindValue(':floraison', $aData['floraison'], \PDO::PARAM_STR);
        $oStmt->bindValue(':floraisonParfume', $aData['floraisonParfume'], \PDO::PARAM_INT);
        $oStmt->bindValue(':modeVie', $aData['modeVie'], \PDO::PARAM_STR);
        $oStmt->bindValue(':resFroid', $aData['resFroid'], \PDO::PARAM_INT);
        $oStmt->bindValue(':resFroidBas', $aData['resFroidBas'], \PDO::PARAM_INT);
        $oStmt->bindValue(':resFroidHaut', $aData['resFroidHaut'], \PDO::PARAM_INT);
        return $oStmt->execute();
    }

    public function updateImg($imageName, $id, $tmp_imageName)
    {
        $i = [
            'idPlante' => $id,
            'image' => $imageName
        ];

        $oStmt = $this->oDb->prepare('UPDATE Plantes SET image_Plante = :image WHERE idPlante = :idPlante');
        move_uploaded_file($tmp_imageName, "static/img/plantes/" . $i['image']);
        return $oStmt->execute($i);
    }

    // I don't know why is this function exist, it's duplucate functionnality of the previous function in my opinion
    public function planteImg($tmp_imageName, $extension)
    {
        $i = [
            'idPlante' => $this->oDb->lastInsertId(),
            'image' => $this->oDb->lastInsertId() . $extension
        ];

        $oStmt = $this->oDb->prepare('UPDATE Plantes SET image_Plante = :image WHERE idPlante = :idPlante');
        move_uploaded_file($tmp_imageName, "static/img/posts/" . $i['image']);
        return $oStmt->execute($i);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////_____DELETE_____////////////////////////////////////////////////////////////////////////////

    public function deletePlante($iId)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM Plantes WHERE idPlante = :idPlante LIMIT 1');
        $oStmt->bindParam(':idPlante', $iId, \PDO::PARAM_INT);
        return $oStmt->execute();
    }

    public function deleteComment($iIdUser, $iIdPlante)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM poster_comment WHERE idUtilisateur = :iIdUser AND idPlante = :iIdPlante');
        $oStmt->bindParam(':iIdUser', $iIdUser, \PDO::PARAM_INT);
        $oStmt->bindParam(':iIdPlante', $iIdPlante, \PDO::PARAM_INT);
        return $oStmt->execute();
    }

    public function deleteCommentsFromPlante($iIdPlante)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM poster_comment WHERE idPlante = :iIdPlante');
        $oStmt->bindParam(':iIdPlante', $iIdPlante, \PDO::PARAM_INT);
        return $oStmt->execute();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //////////////////////_____CREATE_____///////////////////////////////////////////////////////////////////////////////

    public function addPlante(array $aData)
    {
        $oStmt = $this->oDb->prepare('
    INSERT INTO Plantes 
        (title_Plante, description_Plante, 
        prix_Plante, qnty_Plante, 
        nomCommun_Plante, hauteurCM_Plante,
        feillage_Plante, arrosage_Plante,
        floraison_Plante, floraisonParfumee_Plante,
        modeVie_Plante, resistanceFroid_Plante,
        resistanceFroidBas_Plante, resistanceFroidHaut_Plante,) 
    VALUES
        (:title, :description, 
        :price, :qnty, 
        :nomCommun, :hauteurCM,
        :feillage, :arrosage,
        :floraison, :floraisonParfume,
        :modeVie, :resFroid,
        :resFroidBas, :resFroidHaut)');
        $oStmt->bindValue(':title', $aData['title'], \PDO::PARAM_STR);
        $oStmt->bindValue(':description', $aData['description'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':price', $aData['price'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':qnty', $aData['qnty'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':nomCommun', $aData['nomCommun'], \PDO::PARAM_STR);
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