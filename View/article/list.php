<?php require '../View/header.php' ?>

<main class="list-articles">
    <div class="accordion" id="accordionExample">

        <?php foreach($articles as $article): ?>
            <div class="card">
                <div class="card-header container-card-articles" id="heading<?= $article->get_id() ?>">
                    <h2 class="mb-0 article-header articles-card-header">
                        <button class="btn btn-link btn-open" type="button" data-toggle="collapse" data-target="#collapse<?= $article->get_id() ?>" aria-expanded="false" aria-controls="collapse<?= $article->get_id() ?>">
                            <span class="article-card-title"><?= $article->get_title_article() ?></span>
                        </button>
                        <span class="article-card-date"><?= $article->get_date_article() ?></span>
                    </h2>
                </div>

                <div id="collapse<?= $article->get_id() ?>" class="collapse" aria-labelledby="heading<?= $article->get_id() ?>" data-parent="#accordionExample">
                    <div class="card-body">
                        
                        <p><?= $article->get_text_article() ?></p>
                        <a class="btn btn-primary" href="<?= $this->router->generate('article_show', ['id' => $article->get_id()]) ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

        <div class="container-arrows">
            <a class="arrow-down">
                <i class="fas fa-angle-down fa-2x icon-arrow-down"></i>
            </a>
            <a class="arrow-up">
                <i class="fas fa-angle-up fa-2x icon-arrow-up"></i>
            </a>
        </div>
    
    </div>

    <div class="link-article-page">
        <a class="btn-site link-homepage" href="<?= $this->router->generate('accueil') ?>">Revenir à l'accueil</a>

        <?php if($this->is_granted(['ROLE_ADMIN'])): ?>
            <a class="btn-site" href="<?= $this->router->generate('add_article') ?>">Ajouter un article</a>
        <?php endif ?>
    </div>

    <!-- Show flash success if the message is create in the Controller -->
    <div class="alert alert-success" role="alert">
        {{ message }}
    </div>

    <script src="http://localhost/js/scrollBtn.js"></script>
</main>

<?php require '../View/footer.php' ?>