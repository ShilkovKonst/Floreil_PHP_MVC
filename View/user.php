<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>

<div class="container">
<?php require 'inc/msg.php' ?>
    <div class="row">
        <h2 class="center">Bienvenu, <?= $this->oUser->prenom_Utilisateur ?>!</h2>
    </div>
    <div class="row">
        <div class="col m4 s12">
            <b>Votre adresse de livraison est: </b>
            <p>
                <?= $this->oUser->batimentAdresse_Utilisateur ?>, <?= $this->oUser->rueAdresse_Utilisateur ?>
            </p>
            <p>
                <?= $this->oUser->codePostaleAdresse_Utilisateur ?> <?= $this->oUser->villeAdresse_Utilisateur ?>
            </p>
            <p>
                <?= $this->oUser->paysAdresse_Utilisateur ?>
            </p>
            <b>Votre numero de téléphone est: </b>
            <p>
                <?= $this->oUser->telMob_Utilisateur ?>
            </p>
        </div>
        <div class="col m8 s12">
            <b>Si vous voulez changer cette information, vous pouvez utiliser cette forme: </b>
            <form method="post">
                <div class="row">
                    <div class="input-field col l2 m4 s12">
                        <input type="text" name="batimentAdresse_Utilisateur" id="batimentAdresse_Utilisateur">
                        <label for="batimentAdresse_Utilisateur">Numero du bat</label>
                    </div>
                    <div class="input-field col m4 s12">
                        <input type="text" name="rueAdresse_Utilisateur" id="rueAdresse_Utilisateur">
                        <label for="rueAdresse_Utilisateur">Rue</label>
                    </div>
                    
                    <div class="input-field col l2 m4 s12">
                        <input type="text" name="codePostaleAdresse_Utilisateur" id="codePostaleAdresse_Utilisateur">
                        <label for="codePostaleAdresse_Utilisateur">Code postale</label>
                    </div>
                    <div class="input-field col m4 s12">
                        <input type="text" name="villeAdresse_Utilisateur" id="villeAdresse_Utilisateur">
                        <label for="villeAdresse_Utilisateur">Ville</label>
                    </div>                    
                    <div class="input-field col l6 m4 s12">
                        <input type="text" name="paysAdresse_Utilisateur" id="paysAdresse_Utilisateur">
                        <label for="paysAdresse_Utilisateur">Pays</label>
                    </div>
                    <div class="input-field col l6 m4 s12">
                        <input type="text" name="telMob_Utilisateur" id="telMob_Utilisateur">
                        <label for="telMob_Utilisateur">Téléphone mobile</label>
                    </div>
                </div>
                <center>
                    <button type="submit" name="submit_modification" class="btn waves-effect waves-light light-blue">
                        <i class="material-icons left">perm_identity</i>
                        Modifier
                    </button>
                </center>
            </form>


        </div>
    </div>
</div>
<?php require 'inc/footer.php' ?>