<?php

namespace Floreil_PHP_MVC\Controller;

if (empty($_GET['a'])) {
    $_GET['a'] = 'index';
}

class Shop
{
    const MAX_PLANTES = 3;

    protected $oUtil;
    protected $oModel;
    private $_iId;
    private $_iIdSup;

    public function __construct()
    {
        // Active la session

        if (empty($_SESSION))
            @session_start();

        $this->oUtil = new \Floreil_PHP_MVC\Engine\Util;

        /** Récupère la classe Model dans toute la class controller **/
        $this->oUtil->getModel('Shop');
        $this->oModel = new \Floreil_PHP_MVC\Model\Shop;

        /** Récupère l'identifiant de publication dans le constructeur afin d'éviter la duplication du même code **/
        $this->_iId = (int) (!empty($_GET['id']) ? $_GET['id'] : 0);
        $this->_iIdSup = (int) (!empty($_GET['idsup']) ? $_GET['idsup'] : 0);
    }

    /* ================ ACTIONS AVEC VUS ================ */

    // On obtient les categories (interieur et exterieur) puis on affiche index.php
    public function index()
    {
        $this->oUtil->oCategories = $this->oModel->getCategories();

        $this->oUtil->getView('index');
    }

    // Page 404
    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        $this->oUtil->getView('not_found');
    }

    // On obtient tous les plantes par categories puis on affiche la page categorie.php
    public function plantesCat()
    {
        $this->oUtil->oPlantes = $this->oModel->getPlantesByCategories($this->_iId);
        $this->oUtil->oCategorie = $this->oModel->getCategorie($this->_iId);
        $this->oUtil->getView('categorie');
    }

    // Récupère les données du plante, les commentaires associés puis affiche la page plante.php
    public function plante()
    {
        if (empty($_GET['id'])) {
            header('Location: shop_index.html');
        }
        //__Montrer les plantes__//
        $this->oUtil->oPlante = $this->oModel->getPlanteById($this->_iId);
        $this->oUtil->oComments = $this->oModel->getComments();
        $getUserID = $this->oModel->getUserID(current($_SESSION));
        $plante = $this->oModel->getPlanteById($this->_iId);
        $plantePanier = $this->oModel->getSpecificPlantePanierByUserID($getUserID->idUtilisateur, $this->_iId);

        //__Ajouter une plante dans le panier/modifier quantité d'une plante dans la panier__//
        if (isset($_POST['submit_ajouter'])) {
            if (empty($_POST['qnty_plantePanier'])) {
                $this->oUtil->sErrMsg = 'Vous n\'avez pas choisi le quantité';
            } else {
                if ($plantePanier == null) {
                    $aData = array(
                        'title_PlantePanier' => $plante->title_Plante,
                        'image_PlantePanier' => $plante->image_Plante,
                        'idUtilisateur' => $getUserID->idUtilisateur,
                        'idPlante' => $this->_iId,
                        'qnty_plantePanier' => $_POST['qnty_plantePanier'],
                        'qnty_planteStock' => $plante->qnty_Plante,
                        'prixPourQnty_plante' => ($plante->prix_Plante * $_POST['qnty_plantePanier'])
                    );
                } else {
                    $aData = array(
                        'idUtilisateur' => $getUserID->idUtilisateur,
                        'idPlante' => $this->_iId,
                        'qnty_Plante' => $_POST['qnty_plantePanier'],
                        'prixPourQnty_plante' => ($plante->prix_Plante * $_POST['qnty_plantePanier'])
                    );
                }
            }
            if ($plantePanier == null) {
                $this->oModel->addPanierPlante($aData);
            } else {
                $this->oModel->changePanierPlante($aData);
            }
?>
            <script>
                window.location.replace('shop_plante_<?= $_GET['id'] ?>.html');
            </script>
            <?php
            $this->oUtil->sSuccMsg = 'La plante a été ajouté dans le panier !';
        }

        //__Ajouter/editer une commentaire__//
        if (isset($_POST['submit_comment'])) {
            if (empty($_POST['body_Comment'] || $_POST['title_Comment'])) {
                $this->oUtil->sErrMsg = 'Vous n\'avez pas écrit de commentaire';
            } else {
                $aData = array(
                    'title_Comment' => htmlspecialchars($_POST['title_Comment']),
                    'body_Comment' => htmlspecialchars($_POST['body_Comment']),
                    'idUtilisateur' => $getUserID->idUtilisateur,
                    'idPlante' => $_GET['id']
                );
                $this->oModel->addComment($aData);
            ?>
                <script>
                    window.location.replace('shop_plante_<?= $_GET['id'] ?>.html');
                </script>
            <?php
                $this->oUtil->sSuccMsg = 'Le Commentaire a été posté !';
            }
        } else if (isset($_POST['edit_comment'])) {
            if (empty($_POST['body_Comment'] || $_POST['title_Comment'])) {
                $this->oUtil->sErrMsg = 'Vous n\'avez rien modifié';
            } else {
                $aData = array(
                    'title_Comment' => htmlspecialchars($_POST['title_Comment']),
                    'body_Comment' => htmlspecialchars($_POST['body_Comment']),
                    'idUtilisateur' => $getUserID->idUtilisateur,
                    'idPlante' => $_GET['id']
                );
                $this->oModel->editComment($aData);
            ?>
                <script>
                    window.location.replace('shop_plante_<?= $_GET['id'] ?>.html');
                </script>
            <?php
                $this->oUtil->sSuccMsg = 'Le Commentaire a été modifié !';
            }
        }
        $this->oUtil->getView('plante');
    }

    public function panier()
    {
        $getUserID = $this->oModel->getUserID(current($_SESSION));
        $oPlantesPanier = $this->oModel->getAllPlantesPanierByUserID($getUserID->idUtilisateur);
        $oTotalPrixPanier = $this->oModel->getTotalSumPanier($getUserID->idUtilisateur);
        $this->oUtil->oPlantesPanier = $this->oModel->getAllPlantesPanierByUserID($getUserID->idUtilisateur);
        $this->oUtil->oTotalPrixPanier = $this->oModel->getTotalSumPanier($getUserID->idUtilisateur);
        $this->oUtil->getView('panier');

        if (isset($_POST['submit_viderPanier'])) {
            $this->oModel->deleteAllPanierPlantes($getUserID->idUtilisateur);
            ?>
            <script>
                window.location.replace('shop_panier.html');
            </script>
        <?php
        }

        if (isset($_POST['submit_validerAchat'])) {
            foreach ($oPlantesPanier as $plantePanier) {
                $aData = array(
                    'idPlante' => $plantePanier->idPlante,
                    'qnty_Plante' => $this->oModel->getPlanteById($plantePanier->idPlante)->qnty_Plante - $plantePanier->qnty_plantePanier
                );
                $this->oModel->updateQntyPlante($aData);
            }
            $this->oModel->deleteAllPanierPlantes($getUserID->idUtilisateur);
            $aData = array(
                'numero_Facture' => $getUserID->idUtilisateur . $oTotalPrixPanier,
                'montantPanier_Facture' => $oTotalPrixPanier,
                'document_Facture' => $getUserID->idUtilisateur . $oTotalPrixPanier,
                'idUtilisateur' => $getUserID->idUtilisateur
            );
            $this->oModel->createFacture($aData);
        ?>
            <script>
                window.location.replace('shop_panier.html');
            </script>
            <?php
        }
    }

    public function supprimerPlantePanier()
    {
        $getUserID = $this->oModel->getUserID(current($_SESSION));
        $this->oUtil->oPlantesPanier = $this->oModel->getAllPlantesPanierByUserID($getUserID->idUtilisateur);

        $this->oUtil->getView('panier');
    }

    public function login()
    {
        if ($this->isLogged())
            header('Location: ' . ROOT_URL . 'shop_index.html');

        if (isset($_POST['submit'])) {
            $sEmail = htmlspecialchars(trim($_POST['email']));
            $sPassword = htmlspecialchars(trim($_POST['password']));
            $oIsAdmin = $this->oModel->userIsAdmin($_POST['email']);

            if (empty($sEmail) || empty($sPassword)) {
                $this->oUtil->sErrMsg = "Tous les champs n'ont pas été remplis !";
            } elseif ($this->oModel->login($sEmail, $sPassword) == 0) {
                $this->oUtil->sErrMsg = "Identifiant ou mot de passe incorrect!";
            } else {
                if ($oIsAdmin->isAdmin_Utilisateur != null) {
                    $_SESSION['is_admin'] = $oIsAdmin->username_Utilisateur; // Admin est connecté maintenant
                    header('Location: ' . ROOT_URL . 'shop_index.html');
                    exit;
                } else {
                    $_SESSION['is_user'] = $oIsAdmin->username_Utilisateur; // user est connecté maintenant
                    header('Location: ' . ROOT_URL . 'shop_index.html');
                    exit;
                }
            }
        }

        $this->oUtil->getView('login');
    }

    public function registration()
    {
        if ($this->isLogged())
            header('Location: shop_index.html');

        if (isset($_POST['submit'])) {
            $sSurname = htmlspecialchars(trim($_POST['surname']));
            $sName = htmlspecialchars(trim($_POST['name']));
            $sTelMob = htmlspecialchars(trim($_POST['telMob']));
            $sHouseAdresse = htmlspecialchars(trim($_POST['houseAdresse']));
            $sStreetAdresse = htmlspecialchars(trim($_POST['streetAdresse']));
            $sZIPAdresse = htmlspecialchars(trim($_POST['ZIPAdresse']));
            $sCityAdresse = htmlspecialchars(trim($_POST['cityAdresse']));
            $sCountryAdresse = htmlspecialchars(trim($_POST['countryAdresse']));
            $sUsername = htmlspecialchars(trim($_POST['username']));
            $sEmail = htmlspecialchars(trim($_POST['email']));
            $sPassword = htmlspecialchars(trim($_POST['password']));
            $sPassword_again = htmlspecialchars(trim($_POST['password_again']));

            if (empty($sPassword) || empty($sPassword_again)) {
                $this->oUtil->sErrMsg = "Tous les champs n'ont pas été remplis";
            } elseif ($sPassword != $sPassword_again) {
                $this->oUtil->sErrMsg = "Les mots de passe sont différents";
            } elseif ($this->oModel->emailTaken($sEmail)) {
                $this->oUtil->sErrMsg = "Cette adresse email est déjà utilisée";
            } elseif ($this->oModel->usernameTaken($sUsername)) {
                $this->oUtil->sErrMsg = "Ce pseudo est déjà utilisé";
            } else {
                $aData = array(
                    'surname' => $sSurname,
                    'name' => $sName,
                    'telMob' => $sTelMob,
                    'houseAdresse' => $sHouseAdresse,
                    'streetAdresse' => $sStreetAdresse,
                    'ZIPAdresse' => $sZIPAdresse,
                    'cityAdresse' => $sCityAdresse,
                    'countryAdresse' => $sCountryAdresse,
                    'email' => $sEmail,
                    'username' => $sUsername,
                    'password' => sha1($sPassword)      //encryption de mdp
                );
                $this->oModel->addUser($aData);
            ?>

                <script>
                    window.location.replace('shop_login.html');
                </script>

<?php
                $this->oUtil->sSuccMsg = 'Votre compte a été créé, vous pouvez maintenant vous connecter';
            }
        }
        $this->oUtil->getView('registration');
    }

    public function legalNotice()
    {
        $this->oUtil->getView('legalNotice');
    }

    /* ================ ACTIONS SANS VUS ================ */

    // si admin est connecté return true
    protected function isLogged()
    {
        return !empty($_SESSION['is_admin']);
    }

    // si user est connecté return true
    protected function userIsLogged()
    {
        return !empty($_SESSION['is_user']);
    }

    // Si il y a une session, la détruit pour déconnecter l'admin
    public function logout()
    {
        if (!$this->isLogged())
            header('Location: shop_index.html');

        if (!empty($_SESSION)) {
            $_SESSION = array();
            session_unset();
            session_destroy();
        }

        // Redirection à la page d'accueil
        header('Location: ' . ROOT_URL);
        exit;
    }
}
