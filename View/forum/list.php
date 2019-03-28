<?php require '../View/header.php' ?>

<main class="container list-posts">

    <div class="row justify-content-md-center">
        <?php foreach($posts as $post): ?>
            <div class="card border-light card-list-forum col-12 col-md-6 col-lg-4">
                <div class="card-header">
                    <p><?= $this->translation('Catégorie') ?> : <?= $this->translation($post->get_categorie()) ?></p>
                </div>

                <div class="card-body">
                    <h2 class="card-title"><?= $post->get_title_post() ?></h2>
                    <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                    <p><?= $post->get_date_post() ?></p>
                    <a class="btn btn-primary" href="<?= $this->router->generate('post_show', ['id' => $post->get_id()]) ?>"><?= $this->translation('Voir') ?></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="row navigation">
    
        <div class="col-12">
            <form class="category" method="post">
                <select class="select-category" name="Catégories">
                    <option value="mammifères"><?= $this->translation('mammifères') ?></option>
                    <option value="reptiles"><?= $this->translation('reptiles') ?></option>
                    <option value="amphibiens"><?= $this->translation('amphibiens') ?></option>
                    <option value="oiseaux"><?= $this->translation('oiseaux') ?></option>
                    <option value="poissons"><?= $this->translation('poissons') ?></option>
                </select>
            </form>
        </div>

        <div class="container-arrows-forum">
            <a class="arrow-down-f">
                <i class="fas fa-angle-down fa-2x icon-arrow-down-f"></i>
            </a>
            <a class="arrow-up-f">
                <i class="fas fa-angle-up fa-2x icon-arrow-up-f"></i>
            </a>
        </div>
        
        <div class="col-12">
            <div class="btn-link-forum">
                <a class="btn-site" href="<?= $this->router->generate('accueil') ?>"><?= $this->translation('Revenir à l\'accueil') ?></a>
                <?php if($this->is_granted(['ROLE_USER'])): ?>
                    <a class="btn-site" href="<?= $this->router->generate('add_post') ?>"><?= $this->translation('Ajouter un post') ?></a>
                <?php endif ?>
            </div>
        </div>

    </div>

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

    <script src="<?= $this->asset('js/category.js') ?>"></script>
    <script src="<?= $this->asset('js/scrollBtn.js') ?>"></script>

</main>

<?php require '../View/footer.php' ?>