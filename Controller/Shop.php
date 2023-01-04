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
    private $_iIdPlante;

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
        $this->_iIdPlante = (int) (!empty($_GET['idPlante']) ? $_GET['idPlante'] : 0);
    }

    /* ================ ACTIONS AVEC VUS ================ */

    // On obtient les categories (interieur et exterieur) puis on affiche index.php
    public function index()
    {
        $this->oUtil->oPlantes = $this->oModel->getCategorie();

        $this->oUtil->getView('index');
    }

    // Page 404
    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        $this->oUtil->getView('not_found');
    }

    // Récupère les données du plante, les commentaires associés puis affiche la page plante.php
    public function plante()
    {
        if (empty($_GET['idPlante'])) {
            header('Location: shop_index.html');
        }

        $this->oUtil->oPlante = $this->oModel->getPlanteById($this->_iIdPlante);
        $this->oUtil->oComments = $this->oModel->getComments();
        $getUserId = $this->oModel->getUserID(current($_SESSION));

        if (isset($_POST['submit_comment'])) {
            if (empty($_POST['body_Comment'] || $_POST['title_Comment'])) {
                $this->oUtil->sErrMsg = 'Vous n\'avez pas écrit de commentaire';
            } else {
                $aData = array(
                    'idUtilisateur' => $getUserId->idUtilisateur, 
                    'title_Comment' => htmlspecialchars($_POST['title_Comment']), 
                    'body_Comment' => htmlspecialchars($_POST['body_Comment']), 
                    'idPlante' => $_GET['idPlante']);
                $this->oModel->addComment($aData);
?>
<script>
    window.location.replace('shop_plante_<?= $_GET['idPlante'] ?>.html');
</script>
<?php   
                $this->oUtil->sSuccMsg = 'Le Commentaire a été posté !';
            }
        }

        $this->oUtil->getView('shop');
    }

// On obtient tous les plantes par categories puis on affiche la page chapters.php
    public function plantesByCategories($CatName)
	{
		$this->oUtil->oPlantes = $this->oModel->getPlantesByCategories($CatName);

		$this->oUtil->getView('plantes');
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