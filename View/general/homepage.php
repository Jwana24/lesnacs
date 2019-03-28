<?php require '../View/header.php' ?>

<header class="wrap slider-content">

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <span class="text-pug">Bienvenue sur le site "Les Nouveaux Animaux de Compagnie"</span>
                <img src="<?= $this->asset('images/pug.jpg') ?>" class="d-block w-100 img-fluid" alt="Un carlin enroulé dans une couverture">
            </div>
            <div class="carousel-item">
                <span class="text-cat">Retrouvez tous nos articles animaliers</span>
                <img src="<?= $this->asset('images/cat.jpg') ?>" class="d-block w-100 img-fluid" alt="Profil d'un chat">
            </div>
            <div class="carousel-item">
                <span class="text-foal">N'hésitez pas à faire un tour sur notre forum</span>
                <img src="<?= $this->asset('images/foal.jpg') ?>" class="d-block w-100 img-fluid" alt="Poulain couché dans l'herbe">
            </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>

</header>

<main class="homepage">

    <section class="article-box">
        <?php foreach($articles as $article): ?>
            <article class="article">

                <div class="div-img">
                    <img src="<?= $this->asset($article->get_image()) ?>">
                </div>

                <div class="containt-article">
                    <h2 class="title-article"><?= $article->get_title_article() ?></h2>
                    <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                    <p class="date-article"><?= $article->get_date_article() ?></p>
                    <p class="text-article"><?= $article->get_text_article() ?></p>
                    <a class="btn-site" href="<?= $this->router->generate('article_show', ['id' => $article->get_id()]) ?>">En voir plus</a>
                </div>
                
            </article>
        <?php endforeach ?>
    </section>

    <aside id="contacts" class="sidebox">
        <h4>Contacts</h4>
            <form method="post">
                <label for="lastName">Nom</label>
                <input id="lastName" type="text">

                <label for="firstName">Prénom</label>
                <input id="firstName" type="text">

                <label for="mail">Adresse e-mail</label>
                <input id="mail" type="mail">

                <label for="message">Message</label>
                <input class="area-message" id="message" type="text">

                <input class="btn-site btn-submit-contact" type="submit" value="Envoyer">
            </form>
    </aside>

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

</main>

<?php require '../View/footer.php' ?>