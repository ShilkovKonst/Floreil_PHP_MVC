<?php

namespace Floreil_PHP_MVC\Controller;

if (empty($_GET['a'])) {
    $_GET['a'] = 'index';
}

class Shop
{
    //const MAX_PLANTES = 3;

    protected $oUtil;
    protected $oModel;
    private $_iId;
    //private $_iIdSup;

    protected $getUserID;

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
        //$this->_iIdSup = (int) (!empty($_GET['idsup']) ? $_GET['idsup'] : 0);

        if (!empty($_SESSION['is_user']))
            $this->getUserID = $this->oModel->getUserID(current($_SESSION));
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

        $plante = $this->oModel->getPlanteById($this->_iId);

        $this->oUtil->oPlante = $this->oModel->getPlanteById($this->_iId);
        $this->oUtil->oComments = $this->oModel->getComments();

        /////__Si on est utilisateur, on peut d'interagir avec bdd__/////
        if (!empty($_SESSION['is_user'])) {

            //$getUserID = $this->oModel->getUserID(current($_SESSION));
            $plantePanier = $this->oModel->getSpecificPlantePanierByUserID($this->getUserID->idUtilisateur, $this->_iId);
            $this->oUtil->oPlantePanier = $this->oModel->getSpecificPlantePanierByUserID($this->getUserID->idUtilisateur, $this->_iId);

            //__Ajouter une plante dans le panier/modifier quantité d'une plante dans la panier__//
            if (isset($_POST['submit_ajouter'])) {
                if ($_POST['qnty_plantePanier'] == 0) {
                    $this->oUtil->sErrMsg = 'Vous n\'avez pas choisi le quantité';
                } else {
                    if ($plantePanier == null) {
                        $aData = array(
                            'idUtilisateur' => $this->getUserID->idUtilisateur,
                            'idPlante' => $this->_iId,
                            'title_PlantePanier' => $plante->title_Plante,
                            'image_PlantePanier' => $plante->image_Plante,
                            'qnty_plantePanier' => $_POST['qnty_plantePanier'],
                            'qnty_planteStock' => $plante->qnty_Plante,
                            'prixPourQnty_plante' => ($plante->prix_Plante * $_POST['qnty_plantePanier'])
                        );
                        $this->oModel->addPanierPlante($aData);
                    } else {
                        $aData = array(
                            'idUtilisateur' => $this->getUserID->idUtilisateur,
                            'idPlante' => $this->_iId,
                            'qnty_Plante' => $_POST['qnty_plantePanier'],
                            'prixPourQnty_plante' => ($plante->prix_Plante * $_POST['qnty_plantePanier'])
                        );
                        $this->oModel->changePanierPlante($aData);
                    }
                }
                ?>
                <script>
                    window.location.replace('shop_plante_<?= $_GET['id'] ?>.html');
                </script>
                <?php
                $this->oUtil->sSuccMsg = 'La plante a été ajouté dans le panier !';
            }

            if (isset($_POST['submit_effacer'])) {
                $aData = array(
                    'idUtilisateur' => $this->getUserID->idUtilisateur,
                    'idPlante' => $this->_iId
                );
                $this->oModel->deletePanierPlante($aData);
                ?>
                <script>
                    window.location.replace('shop_plante_<?= $this->_iId ?>.html');
                </script>
                <?php
            }

            //__Ajouter/editer une commentaire__//
            if (isset($_POST['submit_comment'])) {
                if (empty($_POST['body_Comment'] || $_POST['title_Comment'])) {
                    $this->oUtil->sErrMsg = 'Vous n\'avez pas écrit de commentaire';
                } else {
                    $aData = array(
                        'title_Comment' => htmlspecialchars($_POST['title_Comment']),
                        'body_Comment' => htmlspecialchars($_POST['body_Comment']),
                        'idUtilisateur' => $this->getUserID->idUtilisateur,
                        'idPlante' => $_GET['id']
                    );
                    $this->oModel->addComment($aData);
                    ?>
                    <script>
                        window.location.replace('shop_plante_<?= $this->_iId ?>.html');
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
                        'idUtilisateur' => $this->getUserID->idUtilisateur,
                        'idPlante' => $this->_iId
                    );
                    $this->oModel->editComment($aData);
                    ?>
                        <script>
                            window.location.replace('shop_plante_<?= $this->_iId ?>.html');
                        </script>
                        <?php
                        $this->oUtil->sSuccMsg = 'Le Commentaire a été modifié !';
                }
            }
        }

        $this->oUtil->getView('plante');
    }

    public function panier()
    {
        //$getUserID = $this->oModel->getUserID(current($_SESSION));
        $oPlantesPanier = $this->oModel->getAllPlantesPanierByUserID($this->getUserID->idUtilisateur);
        $oTotalPrixPanier = $this->oModel->getTotalSumPanier($this->getUserID->idUtilisateur);
        $this->oUtil->oPlantesPanier = $this->oModel->getAllPlantesPanierByUserID($this->getUserID->idUtilisateur);
        $this->oUtil->oTotalPrixPanier = $this->oModel->getTotalSumPanier($this->getUserID->idUtilisateur);

        $this->oUtil->getView('panier');

        if (isset($_POST['submit_viderPanier'])) {
            $this->oModel->deleteAllPanierPlantes($this->getUserID->idUtilisateur);
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
            $this->oModel->deleteAllPanierPlantes($this->getUserID->idUtilisateur);
            $aData = array(
                'numero_Facture' => $this->getUserID->idUtilisateur . $oTotalPrixPanier,
                'montantPanier_Facture' => $oTotalPrixPanier,
                'document_Facture' => $this->getUserID->idUtilisateur . $oTotalPrixPanier,
                'idUtilisateur' => $this->getUserID->idUtilisateur
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
        //$getUserID = $this->oModel->getUserID(current($_SESSION));
        $this->oUtil->oPlantesPanier = $this->oModel->getAllPlantesPanierByUserID($this->getUserID->idUtilisateur);

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

    public function user()
    {
        $this->oUtil->oUser = $this->oModel->getUserByUsername(current($_SESSION));

        $this->oUtil->getView('user');

        if (isset($_POST['submit_modification'])) {
            if (
                empty($_POST['telMob_Utilisateur']) || empty($_POST['batimentAdresse_Utilisateur'])
                || empty($_POST['rueAdresse_Utilisateur']) || empty($_POST['codePostaleAdresse_Utilisateur'])
                || empty($_POST['villeAdresse_Utilisateur']) || empty($_POST['paysAdresse_Utilisateur'])
            ) {
                $this->oUtil->sErrMsg = 'Tous les champs doivent être remplis.';
            } else {
                $sTelMob = htmlspecialchars(trim($_POST['telMob_Utilisateur']));
                $sHouseAdresse = htmlspecialchars(trim($_POST['batimentAdresse_Utilisateur']));
                $sStreetAdresse = htmlspecialchars(trim($_POST['rueAdresse_Utilisateur']));
                $sZIPAdresse = htmlspecialchars(trim($_POST['codePostaleAdresse_Utilisateur']));
                $sCityAdresse = htmlspecialchars(trim($_POST['villeAdresse_Utilisateur']));
                $sCountryAdresse = htmlspecialchars(trim($_POST['paysAdresse_Utilisateur']));
                $sIdUtilisateur = $this->getUserID->idUtilisateur;

                $aData = array(
                    'telMob_Utilisateur' => $sTelMob,
                    'batimentAdresse_Utilisateur' => $sHouseAdresse,
                    'rueAdresse_Utilisateur' => $sStreetAdresse,
                    'codePostaleAdresse_Utilisateur' => $sZIPAdresse,
                    'villeAdresse_Utilisateur' => $sCityAdresse,
                    'paysAdresse_Utilisateur' => $sCountryAdresse,
                    'idUtilisateur' => $sIdUtilisateur
                );
                $this->oModel->changeAdresseUser($aData);
                ?>
                <script>
                                window.location.replace('shop_user.html');
                </script>
                <?php
                $this->oUtil->sSuccMsg = 'L\'information a été modifié !';
            }
        }
    }

    public function registration()
    {
        if ($this->isLogged())
            header('Location: shop_index.html');

        if (isset($_POST['submit_registration'])) {
            $sSurname = htmlspecialchars(trim($_POST['nom_Utilisateur']));
            $sName = htmlspecialchars(trim($_POST['prenom_Utilisateur']));
            $sEmail = htmlspecialchars(trim($_POST['email_Utilisateur']));
            $sTelMob = htmlspecialchars(trim($_POST['telMob_Utilisateur']));
            $sUsername = htmlspecialchars(trim($_POST['username_Utilisateur']));
            $sPassword = htmlspecialchars(trim($_POST['password_Utilisateur']));
            $sHouseAdresse = htmlspecialchars(trim($_POST['batimentAdresse_Utilisateur']));
            $sStreetAdresse = htmlspecialchars(trim($_POST['rueAdresse_Utilisateur']));
            $sZIPAdresse = htmlspecialchars(trim($_POST['codePostaleAdresse_Utilisateur']));
            $sCityAdresse = htmlspecialchars(trim($_POST['villeAdresse_Utilisateur']));
            $sCountryAdresse = htmlspecialchars(trim($_POST['paysAdresse_Utilisateur']));
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
                    'nom_Utilisateur' => $sSurname,
                    'prenom_Utilisateur' => $sName,
                    'email_Utilisateur' => $sEmail,
                    'telMob_Utilisateur' => $sTelMob,
                    'username_Utilisateur' => $sUsername,
                    'password_Utilisateur' => sha1($sPassword),
                    //encryption de mdp
                    'batimentAdresse_Utilisateur' => $sHouseAdresse,
                    'rueAdresse_Utilisateur' => $sStreetAdresse,
                    'codePostaleAdresse_Utilisateur' => $sZIPAdresse,
                    'villeAdresse_Utilisateur' => $sCityAdresse,
                    'paysAdresse_Utilisateur' => $sCountryAdresse
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