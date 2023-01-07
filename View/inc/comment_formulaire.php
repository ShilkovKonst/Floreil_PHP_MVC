
<h4>Commenter :</h4>
<?php require 'msg.php' ?>
<form method="post">
    <div class="row">
        <div class="input-field col s12">
            <textarea name="title_Comment" id="title_Comment" class="materialize-textarea" maxlength="1200"></textarea>
            <label for="title_Comment">Titre</label>
        </div>
        <div class="input-field col s12">
            <textarea name="body_Comment" id="body_Comment" class="materialize-textarea" maxlength="1200"></textarea>
            <label for="body_Comment">Commentaire</label>
        </div>
        <div class="col s12">
            <button type="submit" name="submit_comment" class="btn waves-effect waves-light">
                Commenter
            </button>
        </div>
    </div>
</form>