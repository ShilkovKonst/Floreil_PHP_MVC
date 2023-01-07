<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>

<div class="container">
	<h1>Ajouter un produit</h1>
	<?php require 'inc/msg.php' ?>
	<form method="post" enctype="multipart/form-data">
		<div class="row">

			<div class="input-field col s12">
				<input type="text" name="title_Plante" id="title_Plante" required="required">
				<label for="title_Plante">Titre du produit</label>
			</div>

			<div class="input-field col s12">
				<select id="idCategorie" name="idCategorie" required="required">
					<?php foreach ($this->oCategories as $oCategorie) : ?>
						<option value="<?= $oCategorie->idCategorie ?>"><?= $oCategorie->nom_Categorie ?></option>
					<?php endforeach ?>
				</select>
				<!-- <input type="text" name="idCategorie" id="idCategorie" required="required"> -->
				<label for="idCategorie">Categorie du produit</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="prix_Plante" id="prix_Plante" required="required">
				<label for="prix_Plante">Prix du produit, €</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="qnty_Plante" id="qnty_Plante" required="required">
				<label for="qnty_Plante">Quantité du produit</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="nomCommun_Plante" id="nomCommun_Plante" required="required">
				<label for="nomCommun_Plante">Nom commun du produit</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="hauteurCM_Plante" id="hauteurCM_Plante" required="required">
				<label for="hauteurCM_Plante">Hauteur du produit, cm</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="feuillage_Plante" id="feuillage_Plante" required="required">
				<label for="feuillage_Plante">Type de feuillage du produit</label>
			</div>

			<div class="input-field col s12">
				<label for="editable">Mode d'arrosage</label>
				<br><br>
				<textarea name="arrosage_Plante" id="editable1"></textarea>
			</div>

			<div class="input-field col s12">
				<input type="text" name="floraison_Plante" id="floraison_Plante" required="required">
				<label for="floraison_Plante">Periode de floraison du produit</label>
			</div>

			<div class="input-field col s12">
				<!-- <select id="floraisonParfume_Plante" name="floraisonParfume_Plante" required="required">
					<option value="0">Non</option>
					<option value="1">Oui</option>
				</select> -->
				<input type="text" name="floraisonParfume_Plante" id="floraisonParfume_Plante" required="required">
				<label for="floraisonParfume_Plante">Floraison parfumé?</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="modeVie_Plante" id="modeVie_Plante" required="required">
				<label for="modeVie_Plante">Mode de vie du produit</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="resistanceFroid_Plante" id="resistanceFroid_Plante" required="required">
				<label for="resistanceFroid_Plante">Resistance au froid du produit</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="resistanceFroidBas_Plante" id="resistanceFroidBas_Plante" required="required">
				<label for="resistanceFroidBas_Plante">Resistance au froid du produit, bas</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="resistanceFroidHaut_Plante" id="resistanceFroidHaut_Plante" required="required">
				<label for="resistanceFroidHaut_Plante">Resistance au froid du produit, haut</label>
			</div>

			<div class="input-field col s12">
				<label for="editable">Description du produit</label>
				<br><br>
				<textarea name="description_Plante" id="editable"></textarea>
			</div>

			<div class="col s12">
				<div class="input-field file-field">
					<div class="btn">
						<span>Image du Plante</span>
						<input type="file" name="image">
					</div>
					<div class="file-path-wrapper">
						<input type="text" class="file-path validate" readonly>
					</div>
				</div>
			</div>

			<div class="col s12 right-align">
				<br><br>
				<button class="btn waves-effect waves-light" type="submit" name="add_submit">Ajouter</button>
			</div>

		</div>
	</form>
</div>