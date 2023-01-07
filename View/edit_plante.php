<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>

<div class="container">
	<?php require 'inc/msg.php' ?>

	<?php if (empty($this->oPlante)) : ?>
		<p class="error">Ce plante n'existe pas !</p>
	<?php else : ?>
		<h1>Modifier le produit :</h1>
		<form method="post" enctype="multipart/form-data">
			<div class="row">

				<div class="input-field col s12">
					<input type="text" name="title" id="title" value="<?= htmlspecialchars($this->oPlante->title_Plante) ?>" required="required">
					<label for="title">Titre du produit</label>
				</div>				
				
				<div class="input-field col s12">
					<input type="text" name="hauteurCM" id="hauteurCM" value="<?= htmlspecialchars($this->oPlante->hauteurCM_Plante) ?>" required="required">
					<label for="hauteurCM">Hauteur du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="feuillage" id="feuillage" value="<?= htmlspecialchars($this->oPlante->feuillage_Plante) ?>" required="required">
					<label for="feuillage">Type de feuillage du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="floraison" id="floraison" value="<?= htmlspecialchars($this->oPlante->floraison_Plante) ?>" required="required">
					<label for="floraison">Periode de floraison du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="modeVie" id="modeVie" value="<?= htmlspecialchars($this->oPlante->modeVie_Plante) ?>" required="required">
					<label for="modeVie">Mode de vie du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="nomCommun" id="nomCommun" value="<?= htmlspecialchars($this->oPlante->nomCommun_Plante) ?>" required="required">
					<label for="nomCommun">Nom commun du produit</label>
				</div>
				
				<div class="input-field col s12">
					<label for="editable">Description du produit</label>
					<br>
					<textarea name="body" id="editable" class="materialize-textarea"><?= $this->oPlante->description_Plante ?></textarea>
				</div>

				<div class="col s6 left-align">
					<br><br>
					<div class="input-field file-field">
						<div class="btn light-blue">
							<span>Modifier l'image</span>
							<input type="file" name="image">
						</div>
						<div class="file-path-wrapper">
							<input type="text" class="file-path validate" readonly>
						</div>
					</div>
				</div>

				<div class="col s6 right-align">
					<br><br>
					<button type="submit" class="btn light-green waves-effect waves-light" name="edit_submit">Confirmer</button>
				</div>
			</div>
		</form>
	<?php endif ?>
</div>