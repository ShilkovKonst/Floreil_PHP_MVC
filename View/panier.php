<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>

<div class="container">
  <?php if (empty($this->oPlantesPanier)) : ?>
    <h1>Il n'y a aucun plante.</h1>
    <p><button type="button" onclick="window.location='<?= ROOT_URL ?>shop_index.html'" class="btn waves-effect waves-light">Ajoutez votre premier plante!</button></p>
  <?php else : ?>
    <h1>List des plantes</h1>
    <a href="<?= ROOT_URL ?>shop_index.html"><button class="btn light-blue waves-effect waves-light">Ajouter des plantes</button></a>
    <br>
    <br>
    <hr>

    <table class="striped">
      <thead>
        <tr>
          <th>Image</th>
          <th>Titre</th>
          <th>Quantité</th>
          <th>Montant, €</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->oPlantesPanier as $oPlante) : ?>
          <tr>
            <td><img src="<?= ROOT_URL ?>static/img/plantes/mini/<?= $oPlante->image_PlantePanier ?>" alt="<?= $oPlante->title_PlantePanier ?>"></td>
            <td><?= $oPlante->title_PlantePanier ?></td>
            <td><?= $oPlante->qnty_plantePanier ?></td>
            <td><?= $oPlante->prixPourQnty_plante ?></td>
            <td></td>
          </tr>
        <?php endforeach ?>        
      </tbody>      
      <tfoot>
        <tr>
          <td></td>          
          <td></td>
          <th>Prix total: </th>
          <th><?= $this->oTotalPrixPanier ?>, €</th>
          <th>
            <form method="post">
              <button type="submit" name="submit_validerAchat" class="btn waves-effect waves-light">
                Valider
              </button>
              <button type="submit" name="submit_viderPanier" class="btn red waves-effect waves-light">
                Vider panier
              </button>
            </form>
          </th>
        </tr>
      </tfoot>
    </table>
</div>
<?php endif ?>

<?php require 'inc/footer.php' ?>