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
                        <?php
                            $date = new DateTime($article->get_date_article());
                        ?>
                        <span class="article-card-date"><?= $date->format('D d M Y') ?></span>
                    </h2>
                </div>

                <div id="collapse<?= $article->get_id() ?>" class="collapse" aria-labelledby="heading<?= $article->get_id() ?>" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="ql-editor text-article-card"><?= $this->splitText($article->get_text_article(), 15) ?></div>
                        <a class="btn btn-primary" href="<?= $this->router->generate('article_show', ['id' => $article->get_id()]) ?>"><?= $this->translation('Voir') ?></a>
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
        <a class="btn-site link-homepage" href="<?= $this->router->generate('accueil') ?>"><?= $this->translation('Revenir à l\'accueil') ?></a>

        <?php if($this->is_granted(['ROLE_ADMIN'])): ?>
            <a class="btn-site" href="<?= $this->router->generate('add_article') ?>"><?= $this->translation('Ajouter un article') ?></a>
        <?php endif ?>
    </div>

    <script src="<?= $this->asset('js/scrollBtn.js') ?>"></script>
</main>

<div class="showMessage"></div>

<script>
    <?php $errorsMessage = $this->getMessage('error'); ?>
    <?php if(!empty($errorsMessage)): ?>
        showMessage('error', <?= json_encode($errorsMessage) ?>);
    <?php endif ?>

    <?php $successMessage = $this->getMessage('success'); ?>
    <?php if(!empty($successMessage)): ?>
        showMessage('success', [<?= json_encode($successMessage) ?>]);
    <?php endif ?>
</script>

<?php require '../View/footer.php' ?>