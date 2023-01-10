<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>

<div class="container">
  <div class="row">
    <div class="col l8 m10 s12 offset-l2 offset-m1">
      <div class="card-panel">
        <div class="row">
          <div class="col s6 offset-s3">
            <img src="static/img/admin.png" alt="registration" width="100%">
          </div>
        </div>
        <h4 class="center-align">Inscription</h4>
        <center>
          <?php require 'inc/msg.php' ?>
        </center>
        <form method="post">
          <div class="row">
            <div class="input-field col m6 s12">
              <input type="text" name="nom_Utilisateur" id="nom_Utilisateur">
              <label for="nom_Utilisateur">Nom</label>
            </div>
            <div class="input-field col m6 s12">
              <input type="text" name="prenom_Utilisateur" id="prenom_Utilisateur">
              <label for="prenom_Utilisateur">Prenom</label>
            </div>
            <div class="input-field col m6 s12">
              <input type="email" name="email_Utilisateur" id="email_Utilisateur">
              <label for="email_Utilisateur">Adresse email</label>
            </div>
            <div class="input-field col m6 s12">
              <input type="text" name="username_Utilisateur" id="username_Utilisateur">
              <label for="username_Utilisateur">Pseudo</label>
            </div>
            <div class="input-field col m6 s12">
              <input type="password" id="password_Utilisateur" name="password_Utilisateur">
              <label for="password_Utilisateur">Mot de passe</label>
            </div>
            <div class="input-field col m6 s12">
              <input type="password" name="password_again" id="password_again">
              <label for="password_again">Répéter le mot de passe</label>
            </div>
            <div class="input-field col m6 s12">
              <input type="text" name="telMob_Utilisateur" id="telMob_Utilisateur">
              <label for="telMob_Utilisateur">Telephone mobile</label>
            </div>
            <div class="input-field col m6 s12">
              <input type="text" name="paysAdresse_Utilisateur" id="paysAdresse_Utilisateur">
              <label for="paysAdresse_Utilisateur">Pays</label>
            </div>
            <div class="input-field col m2 s12">
              <input type="text" name="codePostaleAdresse_Utilisateur" id="codePostaleAdresse_Utilisateur">
              <label for="codePostaleAdresse_Utilisateur">Code postale</label>
            </div>
            <div class="input-field col m4 s12">
              <input type="text" name="villeAdresse_Utilisateur" id="villeAdresse_Utilisateur">
              <label for="villeAdresse_Utilisateur">Ville</label>
            </div>
            <div class="input-field col m2 s12">
              <input type="text" name="batimentAdresse_Utilisateur" id="batimentAdresse_Utilisateur">
              <label for="batimentAdresse_Utilisateur">Numero du bat</label>
            </div>
            <div class="input-field col m4 s12">
              <input type="text" name="rueAdresse_Utilisateur" id="rueAdresse_Utilisateur">
              <label for="rueAdresse_Utilisateur">Rue</label>
            </div>
          </div>
          <center>
            <button type="submit" name="submit_registration" class="btn waves-effect waves-light light-blue">
              <i class="material-icons left">perm_identity</i>
              Inscription
            </button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>

</div>

</div>
<center>
  <a href="<?= ROOT_URL ?>blog_login.html">Déjà inscrit ?</a>
</center>
</div>
</div>
</div>