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
        title_Plante = :title_Plante, 
        description_Plante = :description_Plante, 
        prix_Plante = :prix_Plante, 
        qnty_Plante = :qnty_Plante, 
        nomCommun_Plante = :nomCommun_Plante, 
        hauteurCM_Plante = :hauteurCM_Plante,
        feillage_Plante = :feillage_Plante, 
        arrosage_Plante = :arrosage_Plante,
        floraison_Plante = :floraison_Plante, 
        floraisonParfume_Plante = :floraisonParfume_Plante,
        modeVie_Plante = :modeVie_Plante, 
        resistanceFroid_Plante = :resistanceFroid_Plante,
        resistanceFroidBas_Plante = :resistanceFroidBas_Plante, 
        resistanceFroidHaut_Plante = :resistanceFroidHaut_Plante,
        idCategorie = :idCategorie
    WHERE 
        idPlante = :idPlante 
    LIMIT 1');
        $oStmt->bindValue(':idPlante', $aData['idPlante'], \PDO::PARAM_INT);
        $oStmt->bindValue(':title_Plante', $aData['title_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':description_Plante', $aData['description_Plante'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':prix_Plante', $aData['prix_Plante'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':qnty_Plante', $aData['qnty_Plante'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':nomCommun_Plante', $aData['nomCommun_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':hauteurCM_Plante', $aData['hauteurCM_Plante'], \PDO::PARAM_INT);
        $oStmt->bindValue(':feuillage_Plante', $aData['feuillage_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':arrosage_Plante', $aData['arrosage_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':floraison_Plante', $aData['floraison_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':floraisonParfume_Plante', $aData['floraisonParfume_Plante'], \PDO::PARAM_INT);
        $oStmt->bindValue(':modeVie_Plante', $aData['modeVie_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':resistanceFroid_Plante', $aData['resistanceFroid_Plante'], \PDO::PARAM_INT);
        $oStmt->bindValue(':resistanceFroidBas_Plante', $aData['resistanceFroidBas_Plante'], \PDO::PARAM_INT);
        $oStmt->bindValue(':resistanceFroidHaut_Plante', $aData['resistanceFroidHaut_Plante'], \PDO::PARAM_INT);
        $oStmt->bindValue(':idCategorie', $aData['idCategorie'], \PDO::PARAM_INT);
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
        move_uploaded_file($tmp_imageName, "static/img/plantes/" . $i['image']);
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
        (title_Plante, 
        description_Plante, 
        prix_Plante, 
        qnty_Plante, 
        nomCommun_Plante, 
        hauteurCM_Plante,
        feuillage_Plante, 
        arrosage_Plante,
        floraison_Plante, 
        floraisonParfume_Plante,
        modeVie_Plante, 
        resistanceFroid_Plante,
        resistanceFroidBas_Plante, 
        resistanceFroidHaut_Plante,
        idCategorie) 
    VALUES
        (:title_Plante, 
        :description_Plante, 
        :prix_Plante, 
        :qnty_Plante, 
        :nomCommun_Plante, 
        :hauteurCM_Plante,
        :feuillage_Plante, 
        :arrosage_Plante,
        :floraison_Plante, 
        :floraisonParfume_Plante,
        :modeVie_Plante, 
        :resistanceFroid_Plante,
        :resistanceFroidBas_Plante, 
        :resistanceFroidHaut_Plante,
        :idCategorie)');
        $oStmt->bindValue(':title_Plante', $aData['title_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':description_Plante', $aData['description_Plante'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':prix_Plante', $aData['prix_Plante'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':qnty_Plante', $aData['qnty_Plante'], \PDO::PARAM_LOB);
        $oStmt->bindValue(':nomCommun_Plante', $aData['nomCommun_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':hauteurCM_Plante', $aData['hauteurCM_Plante'], \PDO::PARAM_INT);
        $oStmt->bindValue(':feuillage_Plante', $aData['feuillage_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':arrosage_Plante', $aData['arrosage_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':floraison_Plante', $aData['floraison_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':floraisonParfume_Plante', $aData['floraisonParfume_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':modeVie_Plante', $aData['modeVie_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':resistanceFroid_Plante', $aData['resistanceFroid_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':resistanceFroidBas_Plante', $aData['resistanceFroidBas_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':resistanceFroidHaut_Plante', $aData['resistanceFroidHaut_Plante'], \PDO::PARAM_STR);
        $oStmt->bindValue(':idCategorie', $aData['idCategorie'], \PDO::PARAM_STR);
        return $oStmt->execute();
    }
}