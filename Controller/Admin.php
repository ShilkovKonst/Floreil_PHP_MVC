<?php

namespace Floreil_PHP_MVC\Controller;

class Admin extends Shop
{
    /* ================ ACTIONS AVEC VUS ================ */

    // Récupère les données de tous les plantes puis affiche la page edit.php
    public function edit()
    {
        if (!$this->isLogged())
            header('Location: shop_index.html');

        $this->oUtil->oPlantes = $this->oModel->getAllPlantes();
        $this->oUtil->getView('edit');
    }

    // Affiche la page d'edition d'article
    // Suite à l'envoie du formulaire, on récupère les données saisies pour puis on update les données du plante.
    // Si on modifie l'image associée, on vérifie que l'extension existe (jpg, png ...)
    public function editPlante()
    {
        $this->oUtil->oCategories = $this->oModel->getCategories();
        if (!$this->isLogged())
            header('Location: shop_index.html');

        if (isset($_POST['edit_submit'])) {
            if (
                empty($_POST['title_Plante']) || empty($_POST['description_Plante'])
                || empty($_POST['prix_Plante']) || empty($_POST['qnty_Plante'])
                || empty($_POST['nomCommun_Plante']) || empty($_POST['hauteurCM_Plante'])
                || empty($_POST['feuillage_Plante']) || empty($_POST['arrosage_Plante'])
                || empty($_POST['floraison_Plante']) || empty($_POST['modeVie_Plante']) 
                || empty($_POST['resistanceFroid_Plante']) || empty($_POST['resistanceFroidBas_Plante']) 
                || empty($_POST['idCategorie']) || empty($_POST['idCategorie'])
            ) {
                $this->oUtil->sErrMsg = 'Tous les champs doivent être remplis.';
            } else {
                $this->oUtil->getModel('Admin');
                $this->oModel = new \Floreil_PHP_MVC\Model\Admin;

                $aData = array(
                    'idPlante' => $_GET['id'],
                    'title_Plante' => $_POST['title_Plante'],
                    'description_Plante' => $_POST['description_Plante'],
                    'prix_Plante' => $_POST['prix_Plante'],
                    'qnty_Plante' => $_POST['qnty_Plante'],
                    'nomCommun_Plante' => $_POST['nomCommun_Plante'],
                    'hauteurCM_Plante' => $_POST['hauteurCM_Plante'],
                    'feuillage_Plante' => $_POST['feuillage_Plante'],
                    'arrosage_Plante' => $_POST['arrosage_Plante'],
                    'floraison_Plante' => $_POST['floraison_Plante'],
                    'modeVie_Plante' => $_POST['modeVie_Plante'],
                    'resistanceFroid_Plante' => $_POST['resistanceFroid_Plante'],
                    'resistanceFroidBas_Plante' => $_POST['resistanceFroidBas_Plante'],
                    'resistanceFroidHaut_Plante' => $_POST['resistanceFroidHaut_Plante'],
                    'idCategorie' => $_POST['idCategorie'],
                );
                $this->oModel->updatePlante($aData);

                if (!empty($_FILES['image']['name'])) {
                    $file = $_FILES['image']['name'];
                    $extensions = ['.png', '.jpg', '.jpeg', '.gif', '.PNG', '.JPG', '.JPEG', '.GIF'];
                    $extension = strrchr($file, '.');
                    $idPlante = $_GET['id'];
                    if (!in_array($extension, $extensions)) {
                        $this->oUtil->sErrMsg = "Cette image n'est pas valable";
                    }
                    $this->oModel->updateImg($_FILES['image']['name'], $_GET['id'], $_FILES['image']['tmp_name']);
                }

                $this->oUtil->sSuccMsg = 'L\'article a bien été mis à jour !';

            }
        }
        /* Récupère les données du post */
        $this->oUtil->oPlante = $this->oModel->getPlanteById($_GET['id']);

        $this->oUtil->getView('edit_plante');
    }

    // Affiche la page add_post.php
    // Suite à l'envoie du formulaire, on récupère les données et on les insert dans la table post
    // Si il n'y a pas d'image associée, alors l'image de base sera post.png
    public function addPlante()
    {
        $this->oUtil->oCategories = $this->oModel->getCategories();

        if (!$this->isLogged())
            header('Location: shop_index.html');

        if (isset($_POST['add_submit'])) {
            if (
                empty($_POST['title_Plante']) || empty($_POST['description_Plante'])
                || empty($_POST['prix_Plante']) || empty($_POST['qnty_Plante'])
                || empty($_POST['nomCommun_Plante']) || empty($_POST['hauteurCM_Plante'])
                || empty($_POST['feuillage_Plante']) || empty($_POST['arrosage_Plante'])
                || empty($_POST['floraison_Plante']) || empty($_POST['modeVie_Plante']) 
                || empty($_POST['resistanceFroid_Plante']) || empty($_POST['resistanceFroidBas_Plante']) 
                || empty($_POST['resistanceFroidHaut_Plante']) || empty($_POST['idCategorie'])
            ) {
                $this->oUtil->sErrMsg = 'Tous les champs doivent être remplis.';
            } else {
                $this->oUtil->getModel('Admin');
                $this->oModel = new \Floreil_PHP_MVC\Model\Admin;

                $aData = array(
                    'idCategorie' => $_POST['idCategorie'],
                    'title_Plante' => $_POST['title_Plante'],
                    'description_Plante' => $_POST['description_Plante'],
                    'prix_Plante' => $_POST['prix_Plante'],
                    'qnty_Plante' => $_POST['qnty_Plante'],
                    'nomCommun_Plante' => $_POST['nomCommun_Plante'],
                    'hauteurCM_Plante' => $_POST['hauteurCM_Plante'],
                    'feuillage_Plante' => $_POST['feuillage_Plante'],
                    'arrosage_Plante' => $_POST['arrosage_Plante'],
                    'floraison_Plante' => $_POST['floraison_Plante'],
                    'modeVie_Plante' => $_POST['modeVie_Plante'],
                    'resistanceFroid_Plante' => $_POST['resistanceFroid_Plante'],
                    'resistanceFroidBas_Plante' => $_POST['resistanceFroidBas_Plante'],
                    'resistanceFroidHaut_Plante' => $_POST['resistanceFroidHaut_Plante']
                );
                $this->oModel->addPlante($aData);

                if (!empty($_FILES['image']['name'])) 
                {
                    $file = $_FILES['image']['name'];
                    $extensions = ['.png', '.jpg', '.jpeg', '.gif', '.PNG', '.JPG', '.JPEG', '.GIF'];
                    $extension = strrchr($file, '.');
                    if (!in_array($extension, $extensions)) {
                        $this->oUtil->sErrMsg = "Cette image n'est pas valable";
                    }
                    $this->oModel->planteImg($_FILES['image']['tmp_name'], $extension);
                }

                $this->oUtil->sSuccMsg = 'L\'article a bien été ajouté !';
            }
        }

        $this->oUtil->getView('add_plante');
    }

    // On affiche la page dashboard.php
    // On définit les tables qui seront affichées sur la page ainsi que leur couleur
    // On obtient les commentaires non-signalés, les commentaires signalés et le nombre de signalements
    public function dashboard()
    {
      if (!$this->isLogged())
      header('Location: shop_index.html');

      $this->oUtil->getModel('Admin');
      $this->oModel = new \Floreil_PHP_MVC\Model\Admin;

      $tables = [
      	'Plantes' 	      	 => 'Plantes',
      	'Commentaires'  	 => 'poster_comment',
      	'Utilisateurs' 	     => 'Utilisateurs'
      ];

      $colors = [
      	'Plantes'			 => 'green',
      	'poster_comment' 	 => 'brown',
      	'Utilisateurs'		 => 'blue'
      ];

      $ids = [
        'Plantes'			 => 'idPlante',
      	'poster_comment' 	 => 'idUtilisateur',
      	'Utilisateurs'		 => 'idUtilisateur'
      ];

      $this->oUtil->aColors = array();
      $this->oUtil->aInTable = array();
      $this->oUtil->aTableName = array();

      foreach ($tables as $table_name => $table)
      {
        $this->oUtil->aColors[] = $this->getColor($table,$colors);
        $this->oUtil->aInTable[] = $this->oModel->inTable($table, $ids[$table]);
        $this->oUtil->aTableName[] = $table_name;
      }

      $this->oUtil->length = count($this->oUtil->aTableName);

      $this->oUtil->getView('dashboard');
    }

    /* ================ ACTIONS SANS VUS ================ */

    // On supprime le plante ainsi que les commentaires associés à ce plante de ces commentaires
    public function delete()
    {
      if (!$this->isLogged())
      header('Location: blog_index.html');

      $this->oUtil->getModel('Admin');
      $this->oModel = new \Floreil_PHP_MVC\Model\Admin;

      $this->oModel->deleteCommentsFromPlante($_GET['id']); // supprime les commentaires du plante
      $this->oModel->deletePlante($_GET['id']); // supprime le plante

      header('Location: admin_edit.html');
    }

    //On supprime le commentaire ainsi que les signalements associés
    public function deleteComment()
    {
      if (!$this->isLogged())
      header('Location: blog_index.html');

      $oPlante = $this->oUtil->oPlante = $this->oModel->getPlanteById($_GET['id']); // Récupère les données du plante
      $this->oUtil->getModel('Admin');
      $this->oModel = new \Floreil_PHP_MVC\Model\Admin;

      $iIdPlante = $_GET['id'];
      $iIdUser = $_GET['idsup'];
      $this->oModel->deleteComment($iIdUser, $iIdPlante); // supprime le commentaire

      header("Location: shop_plante_$oPlante->idPlante.html");
    }

    // On obtient la couleur associé à chaque table
    private function getColor($aTable,$sColors)
    {
      if(isset($sColors[$aTable])){
  			return $sColors[$aTable];
  		}else {
  			return "orange";
  		}
    }
}