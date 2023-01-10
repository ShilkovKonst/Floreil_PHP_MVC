<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>

<main>
    <div class="container">
        <!-- Plante -->
        <div class="row">
            <?php if (empty($this->oPlante)) : ?>
                <h1>ce Produit n'existe pas !</h1>
            <?php else : ?>
                <article class="col">
                    <time datetime="<?= $this->oPlante->createdDate_Plante ?>" pubdate="pubdate"></time>

                    <h1><?= htmlspecialchars($this->oPlante->title_Plante) ?></h1>
                    <img class="col l6 m4 s12" src="<?= ROOT_URL ?>static/img/plantes/<?= $this->oPlante->image_Plante ?>" alt="<?= $this->oPlante->title_Plante ?>">
                    <div class="col l6 m8 s12">
                        <p><?= nl2br($this->oPlante->description_Plante) ?></p>
                        <p><strong>Nom Commun: </strong><?= nl2br($this->oPlante->nomCommun_Plante) ?></p>
                        <p><strong>Hauteur, CM: </strong><?= nl2br($this->oPlante->hauteurCM_Plante) ?></p>
                        <p><strong>Feuillage: </strong><?= nl2br($this->oPlante->feuillage_Plante) ?></p>
                        <p><strong>Arrosage: </strong><?= nl2br($this->oPlante->arrosage_Plante) ?></p>
                        <p><strong>Floraison: </strong><?= nl2br($this->oPlante->floraison_Plante) ?></p>
                        <p><strong>Mode de Vie: </strong><?= nl2br($this->oPlante->modeVie_Plante) ?></p>
                        <?php if ($this->oPlante->resistanceFroid_Plante != 0) : ?>
                            <p><strong>Résistance au froid:</strong> de <?= nl2br($this->oPlante->resistanceFroidBas_Plante) ?> à <?= nl2br($this->oPlante->resistanceFroidHaut_Plante) ?></p>
                        <?php endif ?>
                        <p><strong>Prix: </strong><?= nl2br($this->oPlante->prix_Plante) ?>, €</p>
                        <p><strong>Quantité: </strong><?= nl2br($this->oPlante->qnty_Plante) ?></p>
                    </div>
                </article>
                <?php if(empty($_SESSION['is_admin']) && !empty($_SESSION['is_user'])) : ?>
                <form method="post">
                    <div class="row">
                        <div class="input-field col m4 s12">
                            <label for="qnty_plantePanier">Ajouter</label>
                            <br>
                            <br>
                            <input type="range" value="0" step="1" min="0" max="<?= $this->oPlante->qnty_Plante ?>" name="qnty_plantePanier" id="qnty_plantePanier" class="materialize-textarea">
                        </div>
                    </div>
                    <button type="submit" name="submit_ajouter" class="btn light-blue waves-effect waves-light">
                        Ajouter au panier
                    </button>
                    <?php if($this->oPlantePanier != null) : ?>
                    <button type="submit" name="submit_effacer" class="btn red waves-effect waves-light">
                        Effacer du panier
                    </button>
                    <?php endif ?>
                </form>
                <?php endif ?>
                <hr>
                <p><em>Posté le <?= date('d/m/Y à H:i', strtotime($this->oPlante->createdDate_Plante)); ?></em></p>
                <br>
        </div>

        <!-- Formulaire -->
        <?php if (empty($_SESSION['is_user']) && empty($_SESSION['is_admin'])) : ?>
            <a href="<?= ROOT_URL ?>?p=shop&amp;a=login"><button class="btn waves-effect waves-light">Se connecter pour commenter ou acheter des plantes</button></a>
            <br><br>

        <?php else : ?>
            <?php if (
                        in_array(current($_SESSION), array_column($this->oComments, 'username_Utilisateur')) &&
                        in_array($_GET['id'], array_column($this->oComments, 'idPlante'))
                    ) : ?>
                <h5>Modifier :</h5>
            <?php else : ?>
                <h5>Commenter :</h5>
            <?php endif ?>
            <?php require 'inc/msg.php' ?>
            <form method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <textarea name="title_Comment" id="title_Comment" class="materialize-textarea" maxlength="120"></textarea>
                        <label for="title_Comment">Titre</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea name="body_Comment" id="body_Comment" class="materialize-textarea" maxlength="1200"></textarea>
                        <label for="body_Comment">Commentaire</label>
                    </div>

                    <?php if (
                        in_array(current($_SESSION), array_column($this->oComments, 'username_Utilisateur')) &&
                        in_array($_GET['id'], array_column($this->oComments, 'idPlante'))
                    ) : ?>
                        <div class="col s12">
                            <button type="submit" name="edit_comment" class="btn waves-effect waves-light">
                                Modifier
                            </button>
                        </div>
                    <?php else : ?>
                        <div class="col s12">
                            <button type="submit" name="submit_comment" class="btn waves-effect waves-light">
                                Commenter
                            </button>
                        </div>
                    <?php endif ?>
                </div>
            </form>
        <?php endif ?>

        <!-- Commentaires -->
        <h4 id="comment_ink">Commentaires :</h4>
        <?php if (empty($this->oComments)) : ?>
            <p class="bold">Aucun commentaire n'a été publié... Soyez le premier!</p>
        <?php else : ?>
            <?php foreach ($this->oComments as $oComment) : ?>
                <blockquote id="blockquote">
                    <strong><?= $oComment->username_Utilisateur ?> <em>(Le <?= date('d/m/Y à H:i', strtotime($oComment->date_Comment)) ?>)</em></strong>
                    <h6><strong><?= nl2br($oComment->title_Comment); ?></strong></h6>
                    <p><?= nl2br($oComment->body_Comment); ?></p>
                </blockquote>
                <?php if (!empty($_SESSION['is_admin'])) : ?>
                    <a href="<?= ROOT_URL ?>?p=admin&amp;a=deleteComment&amp;id=<?= $oComment->idPlante ?>&amp;idsup=<?= $oComment->idUtilisateur ?>"><button class="btn red waves-effect waves-light">Supprimer</button></a>
                <?php endif ?>

                <?php /* if (!empty($_SESSION['is_user'])) : ?>
                    <?php $color = 'is_signaled'; ?>
                    <?php $aIsSignaled = array(); ?>
                    <?php foreach ($this->oUserVotes as $key => $userVote) : ?>
                        <?php $aIsSignaled[] = $userVote->comment_id; ?>
                    <?php endforeach ?>
                    <?php if (in_array($oComment->id, $aIsSignaled) == false) : ?>
                        <?php $color = ''; ?>
                    <?php endif ?>
                    <pre>
                    </pre>
                    <form class="vote-form" action="shop_signal_<?= $this->oPlante->id ?>_<?= $oComment->id ?>_1.html" method="POST">
                        <button class="btn red waves-effect waves-light signal-btn <?= $color ?>" type="submit">Signaler</button>
                    </form>
                <?php endif */ ?>
                <br>
                <hr>
                <br>
            <?php endforeach ?>
        <?php endif ?>
    <?php endif ?>
    </div>
</main>
<?php require 'inc/footer.php' ?>