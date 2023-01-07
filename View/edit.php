<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>

<div class="container">
  <?php if (empty($this->oPlantes)): ?>
    <h1>Il n'y a aucun plante.</h1>
    <p><button type="button" onclick="window.location='<?=ROOT_URL?>admin_addPlante.html'" class="btn waves-effect waves-light">Ajoutez votre premier produit!</button></p>
  <?php else: ?>
  <h1>Edition</h1>
  <a href="<?=ROOT_URL?>admin_addPlante.html"><button class="btn light-blue waves-effect waves-light">Ajouter un produit</button></a>
  <br>
  <br>
  <hr>

  <table class="striped">
    <thead>
      <tr>
          <th>Titre</th>
          <th>Date</th>
          <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($this->oPlantes as $oPlante): ?>
        <tr>
          <td><?= $oPlante->title_Plante ?></td>
          <td>Le <?= date('d/m/Y à H:i', strtotime($oPlante->createdDate_Plante)); ?></td>
          <td>
            <?php require 'inc/control_buttons.php' ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<?php endif ?>
