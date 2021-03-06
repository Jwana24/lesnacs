<?php require '../View/header.php' ?>

<main class="add-article-page">

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">

        <div class="form-group">
            <input class="form-control form-control-lg" type="text" name="title_article" placeholder="<?= $this->translation('Titre de l\'article') ?>">
        </div>

        <div class="form-group" id="editor">
            <textarea class="form-control" name="text_article" rows="3"></textarea>
        </div>
        <input type="hidden" id="textQuillInput" name="text_article">

        <div class="form-group">
            <input class="form-control-file" name="image" type="file">
        </div>

        <div class="form-group">
            <input class="btn btn-primary btn-send-new-article" type="submit" value="<?= $this->translation('Envoyer') ?>">
        </div>
    </form>

    <div class="link-article-page">
        <a class="btn-site link-return-articles" href="<?= $this->router->generate('article_list') ?>"><?= $this->translation('Revenir à la liste des articles') ?></a>
        <a class="btn-site link-return-homepage" href="<?= $this->router->generate('accueil') ?>"><?= $this->translation('Revenir à l\'accueil') ?></a>
    </div>

</main>

<?php require '../View/footer.php' ?>