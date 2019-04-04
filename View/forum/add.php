<?php require '../View/header.php' ?>

<main class="add-post-page">
    
    <form method="post">
        <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
        <div class="form-group">
            <input class="form-control form-control-lg" name="title_post" type="text" placeholder="Titre du post">
        </div>
        <div class="form-group">
            <select class="form-control form-control-sm" name="categorie">
                <option value="mammifères">mammifères</option>
                <option value="reptiles">reptiles</option>
                <option value="amphibiens">amphibiens</option>
                <option value="oiseaux">oiseaux</option>
                <option value="poissons">poissons</option>
            </select>
        </div>
        <div class="form-group" id="editor">
            <textarea class="form-control" name="text_post" placeholder="Contenu du post" style="rows:3"></textarea>
        </div>
        <div class="form-group">
            <input class="btn btn-primary btn-send-new-post" type="submit" value="Envoyer">
        </div>
    </form>

    <div class="link-post-page">
        <a class="btn-site link-return-posts" href="<?= $this->router->generate('post_list') ?>">Revenir à la liste des posts</a>
        <a class="btn-site link-return-homepage" href="<?= $this->router->generate('accueil') ?>">Revenir à l'accueil</a>
    </div>

</main>

<?php require '../View/footer.php' ?>