<?php require '../View/header.php' ?>

<header class="wrap slider-content">

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <span class="text-pug">Bienvenue sur le site "Les Nouveaux Animaux de Compagnie"</span>
                <img src="http://localhost/images/pug.jpg" class="d-block w-100 img-fluid" alt="Un carlin enroulé dans une couverture">
            </div>
            <div class="carousel-item">
                <span class="text-cat">Retrouvez tous nos articles animaliers</span>
                <img src="http://localhost/images/cat.jpg" class="d-block w-100 img-fluid" alt="Profil d'un chat">
            </div>
            <div class="carousel-item">
                <span class="text-foal">N'hésitez pas à faire un tour sur notre forum</span>
                <img src="http://localhost/images/foal.jpg" class="d-block w-100 img-fluid" alt="Poulain couché dans l'herbe">
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
                    <img src="<?= $article->get_image() ?>">
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

    <div class="container">
        <?php if(!empty($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert">
                <p>
                    <?php echo $_SESSION['success'];
                    $_SESSION['success'] = '';
                    ?>
                </p>
            </div>
        <?php endif ?>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <p> <?= $error ?? '' ?> </p>
            </div>
        <?php endif ?>
    </div>

</main>

<?php require '../View/footer.php' ?>