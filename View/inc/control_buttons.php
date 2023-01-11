<?php if (!empty($_SESSION['is_admin'])): ?>

  
<form method="post">
    <?php if (!isset($_POST["submit_delete_$oPlante->idPlante"])): ?>

      <a class="btn light-blue waves-effect waves-light"
        href="<?= ROOT_URL ?>admin_editPlante_<?= $oPlante->idPlante ?>.html">Modifier </a>

      <button type="submit" name="submit_delete_<?= $oPlante->idPlante ?>"
        class="btn red waves-effect waves-light">Supprimer</button>

    <?php elseif (isset($_POST["submit_delete_$oPlante->idPlante"])): ?>

      <p>Etes-vous sûr de vouloir supprimer?</p>
      <a class="btn red waves-effect waves-light" 
      href="<?= ROOT_URL ?>admin_delete_<?= $oPlante->idPlante ?>.html">Oui </a>
      
      <button type="submit" name="submit_refuse_delete_<?= $oPlante->idPlante ?>"
        class="btn green waves-effect waves-light">Non</button>
 
    <?php endif ?>
</form>
 
  <?php if (isset($_POST["submit_refuse_delete_$oPlante->idPlante"])) {
    $_POST["submit_delete_$oPlante->idPlante"] = null;
  } ?>


<?php endif ?>