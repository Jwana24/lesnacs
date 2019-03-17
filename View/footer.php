<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <?php if($this->cookie_exist('cookie-bandeauCookie')): ?>
        <div class="container">
            <div class="toast message-cookie" data-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img widht="10px" height="20px" src="http://localhost/images/gingerman.png" class="rounded mr-2" alt="...">
                    <strong class="mr-auto">Cookies</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    <p>
                        Les cookies vous permettent de bénéficier de nombreuses fonctionnalités afin d'améliorer votre navigation sur le site. En utilisant ce site, vous acceptez de recevoir des cookies. Pour en savoir plus et accepter les cookies, <a href="<?= $this->router->generate('mentionslegales') ?>#cookies">cliquez ici</a>.
                    </p>
                </div>
            </div>
        </div>
    <?php endif ?>

    <footer>
        <div class="footer-elements">
            <div class="elements-center">
                <a href="<?= $this->router->generate('accueil') ?>#contacts">Contacts</a>
                <a href="<?= $this->router->generate('mentionslegales') ?>">Mentions légales</a>
                <a href="<?= $this->router->generate('article_list') ?>">Articles</a>
                <a href="<?= $this->router->generate('post_list') ?>">Forum</a>
                <?php if($this->is_granted('ROLE_USER')): ?>
                    <a href="<?= $this->router->generate('member_show', ['id' => $member->get_id()]) ?>">Mon profil</a>
                <?php endif ?>
                <p class="recommand-sites">
                    Les sites que l'on vous recommande :
                    <div class="logos">
                        <div class="logo-30MA">
                            <a href="https://www.30millionsdamis.fr/"><img class="logo-30MAmis" src="http://localhost/images/logo-30MAmis.png" alt="Logo de la Fondation 30 Millions d'Amis"></a>
                        </div>
                        <div class="logo-spa">
                            <a href="https://www.la-spa.fr/"><img class="logo-spa" src="http://localhost/images/logo-LaSPA.png" alt="Logo de la SPA (Société Protectrice des Animaux)"></a>
                        </div>
                    </div>
                </p>
            </div>
            <p>© Site LesNac créé par Johanna DETRIEUX</p>
        </div>
    </footer>

    <?php if($this->user == NULL): ?>
        <script src="http://localhost/js/registration.js"></script>
    <?php endif ?>

    <!-- Bootstrap links, content JS to Bootstrap -->
    <script src="https://unpkg.com/ionicons@4.5.5/dist/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <script>$('.toast').toast('show')</script>
    <script src="http://localhost/js/main.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
    <script>
        if(document.querySelector('#editor'))
        {
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {} );
        }
    </script>
</body>
</html>