<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<main>
<?php foreach ($this->oCategorie as $oCategorie): ?>
  <div class="container">  
    <h1 class="page-title">Liste des <?=$oCategorie->nom_Categorie ?></h1> 
    <?php foreach ($this->oPlantes as $oPlante): ?>
      <div class="row">
        <hr>
  			<div class="col s12 m12 l12">
  				<h4><?= $oPlante->title_Plante ?></h4>
  				<div class="row">
  					<div class="col s12 m6 l8">
              <!-- On affiche les 1200 premiers caractères et on affiche pas les images -->
  						<?= preg_replace("/<img[^>]+\>/i", "", nl2br(mb_strimwidth($oPlante->description_Plante, 0, 800, '...'))); ?>
              <br><br>
              <?php require 'inc/control_buttons.php' ?>
  					</div>
  					<div class="col s12 m6 l4">
  						<img src="<?=ROOT_URL?>static/img/plantes/<?= $oPlante->image_Plante ?>" class="materialboxed responsive-img" alt="<?= $oPlante->title_Plante ?>"/>
  						<br/><br/>
  				  	<a class="btn light-blue waves-effect waves-light" href="<?=ROOT_URL?>shop_plante_<?=$oPlante->idPlante?>.html">Voir le produit</a>
  					</div>
  				</div>
  			</div>
  		</div>
    <?php endforeach ?>
  </div>
  <?php endforeach ?>
</main>
<?php require 'inc/footer.php' ?>
