<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>

<main>
  <div class="container">
    <?php if (empty($this->oCategories)): ?>
        <h1>Il n'y a aucun article.</h1>
        <p><button type="button" onclick="window.location='<?=ROOT_URL?>admin_add.html'" class="btn waves-effect waves-light">Ajoutez votre premier article!</button></p>
    <?php else: ?>
    <h1 class="page-title">Magasin des plantes pour tous!</h1>
    <div class="row">

      <!-- ARTICLES -->
      <?php foreach ($this->oCategories as $oCategorie): ?>
        <div class="col m6 s12">
          <div class="card hoverable">
            <div class="card-content">
              <h5><a class="grey-text text-darken-2" href="<?=ROOT_URL?>shop_plantesCat_<?=$oCategorie->idCategorie?>.html"><?=htmlspecialchars($oCategorie->nom_Categorie)?></a></h5>
            </div>
            <div class="card-image waves-effect waves-block waves-light">
    					<img src="<?=ROOT_URL?>static/img/categories/<?= $oCategorie->image_Categorie ?>" class="activator" alt="<?= $oCategorie->nom_Categorie ?>">
    				</div>
            <div class="card-content">
              <span class="card-title activator grey-text text-darken-4"><i class="material-icons right">more_vert</i></span>
              <p><a href="<?=ROOT_URL?>shop_categorie_<?=$oCategorie->idCategorie?>.html">Voir le produit au complet</a></p>
            </div>
            <div class="card-reveal">
    					<span class="card-title grey-text text-darken-4"><?= $oCategorie->nom_Categorie ?><i class="material-icons right">close</i></span>
    					<p><?= preg_replace("/<img[^>]+\>/i", "", nl2br(mb_strimwidth($oCategorie->body_Categorie, 0, 800, '...'))); ?></p>
    				</div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</main>
<?php endif ?>
<?php require 'inc/footer.php' ?>
