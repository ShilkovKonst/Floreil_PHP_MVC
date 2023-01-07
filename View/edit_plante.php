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
					<input type="text" name="title_Plante" id="title_Plante" value="<?= htmlspecialchars($this->oPlante->title_Plante) ?>" required="required">
					<label for="title_Plante">Titre du produit</label>
				</div>

				<div class="input-field col s12">
					<select id="idCategorie" name="idCategorie" required="required">
						<?php foreach ($this->oCategories as $oCategorie) : ?>
							<option value="<?= $oCategorie->idCategorie ?>"><?= $oCategorie->nom_Categorie ?></option>
						<?php endforeach ?>
					</select>
					<label for="idCategorie">Categorie du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="prix_Plante" id="prix_Plante" value="<?= htmlspecialchars($this->oPlante->prix_Plante) ?>" required="required">
					<label for="prix_Plante">Prix du produit, €</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="qnty_Plante" id="qnty_Plante" value="<?= htmlspecialchars($this->oPlante->qnty_Plante) ?>" required="required">
					<label for="qnty_Plante">Quantité du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="nomCommun_Plante" id="nomCommun_Plante" value="<?= htmlspecialchars($this->oPlante->nomCommun_Plante) ?>" required="required">
					<label for="nomCommun_Plante">Nom commun du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="hauteurCM_Plante" id="hauteurCM_Plante" value="<?= htmlspecialchars($this->oPlante->hauteurCM_Plante) ?>" required="required">
					<label for="hauteurCM_Plante">Hauteur du produit, cm</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="feuillage_Plante" id="feuillage_Plante" value="<?= htmlspecialchars($this->oPlante->feuillage_Plante) ?>" required="required">
					<label for="feuillage_Plante">Type de feuillage du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="arrosage_Plante" id="arrosage_Plante" value="<?= htmlspecialchars($this->oPlante->arrosage_Plante) ?>" required="required">
					<label for="arrosage_Plante">Mode d'arrosage</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="floraison_Plante" id="floraison_Plante" value="<?= htmlspecialchars($this->oPlante->floraison_Plante) ?>" required="required">
					<label for="floraison_Plante">Periode de floraison du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="modeVie_Plante" id="modeVie_Plante" value="<?= htmlspecialchars($this->oPlante->modeVie_Plante) ?>" required="required">
					<label for="modeVie_Plante">Mode de vie du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="resistanceFroid_Plante" id="resistanceFroid_Plante" value="<?= htmlspecialchars($this->oPlante->resistanceFroid_Plante) ?>" required="required">
					<label for="resistanceFroid_Plante">Resistance au froid du produit</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="resistanceFroidBas_Plante" id="resistanceFroidBas_Plante" value="<?= htmlspecialchars($this->oPlante->resistanceFroidBas_Plante) ?>" required="required">
					<label for="resistanceFroidBas_Plante">Resistance au froid du produit, bas</label>
				</div>

				<div class="input-field col s12">
					<input type="text" name="resistanceFroidHaut_Plante" id="resistanceFroidHaut_Plante" value="<?= htmlspecialchars($this->oPlante->resistanceFroidHaut_Plante) ?>" required="required">
					<label for="resistanceFroidHaut_Plante">Resistance au froid du produit, haut</label>
				</div>

				<div class="input-field col s12">
					<label for="editable">Description du produit</label>
					<br>
					<textarea name="description_Plante" id="editable" class="materialize-textarea"><?= $this->oPlante->description_Plante ?></textarea>
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