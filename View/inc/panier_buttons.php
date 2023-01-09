<?php if (!empty($_SESSION['is_user']) && $_GET['a'] == 'plante') : ?>

  <a href="<?= ROOT_URL ?>shop_ajouterPlantePanier_<?= $_GET['id'] ?>.html"><button class="btn light-blue waves-effect waves-light">Ajouter au panier</button></a>
  <a href="<?= ROOT_URL ?>shop_supprimerPlantePanier_<?= $_GET['id'] ?>.html"><button class="btn red waves-effect waves-light">Supprimer du panier</button></a>

<?php endif ?>

<?php if (!empty($_SESSION['is_user']) && $_GET['a'] == 'panier') : ?>

  <a href="<?= ROOT_URL ?>shop_supprimerPlantePanier_<?= $oPlante->idPlante ?>.html"><button class="btn red waves-effect waves-light">Supprimer du panier</button></a>

<?php endif ?>