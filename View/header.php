<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $titlePage ?? 'Le site LesNACs' ?></title>

    <!-- Bootstrap links, CSS content to Bootstrap -->
    <link rel="stylesheet" href="<?= $this->asset('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- My css -->
    <link rel="stylesheet" href="<?= $this->asset('css/style.css') ?>">
    <link rel="icon" type="image/png" href="<?= $this->asset('images/icone-site-lesnac-16px.svg') ?>" />

    <!-- Quill editor css -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="<?= $this->asset('js/main.js') ?>"></script>
</head>
<body>
    
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="<?= $this->router->generate('accueil') ?>"><img class="logo-site" src="<?= $this->asset('images/logo-site-lesnac.svg') ?>" alt="Logo du site Les Nacs"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('accueil') ?>"><?= $this->translation('Accueil') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('article_list') ?>">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('post_list') ?>">Forum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('accueil') ?>#contacts">Contacts</a>
                </li>
            
                <?php if($this->is_granted(['ROLE_USER', 'ROLE_ADMIN'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon style="color: white" name="person"></ion-icon></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04">
                            <a class="dropdown-item" href="<?= $this->router->generate('deconnexion') ?>"><?= $this->translation('Déconnexion') ?></a>
                            <a class="dropdown-item" href="<?= $this->router->generate('member_show', ['id' => $this->member->get_id()]) ?>"><?= $this->translation('Profil de ') ?><?= $this->member->get_username() ?></a>
                            <?php if($this->is_granted(['ROLE_ADMIN'])): ?>
                                <a class="dropdown-item" href="<?= $this->router->generate('member_list') ?>"><?= $this->translation('Liste des membres') ?></a>
                            <?php endif ?>
                        </div>
                    </li>
                
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon class="icon" style="color: white" name="globe"></ion-icon></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04">
                            <a class="dropdown-item lang-link" data-locale="fr" href="#"><?= $this->translation('Français') ?></a>
                            <a class="dropdown-item lang-link" data-locale="en" href="#"><?= $this->translation('Anglais') ?></a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon style="color: white" name="person"></ion-icon></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04">
                            <a class="dropdown-item btn-connection" href="<?= $this->router->generate('connexion') ?>">Connexion</a>
                            <a class="dropdown-item btn-inscription" href="<?= $this->router->generate('inscription') ?>">Inscription</a>
                        </div>
                    </li>
                <?php endif ?>
            
            </ul>

            <form class="form-inline my-2 my-md-0" action="<?= $this->router->generate('recherche') ?>" method="get">
                <input class="form-control" name="search" type="text" placeholder="<?= $this->translation('Recherche') ?>">
                <input name="pageArticle" type="hidden" value="1">
                <input name="pagePost" type="hidden" value="1">
            </form>
        </div>
    </nav>

    <?php if(!$this->is_granted(['ROLE_USER'])): ?>

        <section class="modal_inscription">
            <article class="center_modal_inscription">
                <ion-icon class="cross-close" name="close"></ion-icon>
                <h4>Inscription</h4>
                <form name="member" method="post" enctype="multipart/form-data">
                    <div id="member">

                        <div>
                            <input type="text" placeholder="Nom" id="member_last_name" name="last_name" required maxlength="50" pattern="^[a-zA-Z \-]{5,50}$" title="Votre nom n'est pas valide, il ne doit contenir aucun accent"/>
                        </div>

                        <div>
                            <input type="text" placeholder="Prénom" id="member_first_name" name="first_name" required maxlength="50" pattern="^[a-zA-Z \-àáâãäåçèéêëìíîïðòóôõöùúûüýÿ]{5,50}$" title="Votre prénom n'est pas valide"/>
                        </div>

                        <div>
                            <input type="text" placeholder="Pseudo" id="member_username" name="username" required maxlength="50" pattern=".{2,50}" title="Votre pseudo doit faire entre 2 et 50 caractères" />
                        </div>

                        <div>
                            <input type="password" id="member_password_first" placeholder="Mot de passe" name="password" class="password-field" required pattern="^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!&+=]).{8,})$" title="Votre mot de passe doit contenir au minimum 8 caractères, au moins un chiffre, une lettre et un caractère spécial tel que (@, #, $, %, !, &, + et =)" />
                        </div>

                        <div>
                            <input type="password" id="member_password_second" placeholder="Confirmation du mot de passe" name="password2" class="password-field" required />
                        </div>

                        <div>
                            <input type="email" placeholder="Email" id="member_mail" name="mail" required maxlength="200" />
                        </div>

                        <div>
                            <input type="text" placeholder="Description (facultatif)" id="member_description" name="description" maxlength="500" />
                        </div>

                        <div>
                            <label for="member_avatar">Avatar</label>
                            <input type="file" placeholder="Avatar" id="member_avatar" name="avatar" />
                        </div>

                    </div>
                    
                    <div>
                        <input type="submit" value="M'inscrire">
                    </div>
                </form>
            </article>
        </section>

        <section class="modal_connection">
            <article class="center_modal_connection">
                <ion-icon class="cross-close-co" name="close"></ion-icon>
                <h4>Connexion</h4>
                <form name="member-co" method="POST">
                    <div id="member-co">
                        <div>
                            <input type="text" name="username" placeholder="Pseudo" required="">
                        </div>

                        <div>
                            <input type="password" name="password" placeholder="Mot de passe" required>
                        </div>

                        <div class="autoCo">
                            <input type="checkbox" id="autoCo" name="autoCo" value="ok">
                            <label for="autoCo">Connexion automatique</label>
                        </div>

                        <div>
                            <input type="submit" value="Se connecter">
                        </div>

                        <div>
                            <a href="<?= $this->router->generate('motdepasseoublie') ?>">Mot de passe oublié ?</a>
                        </div>
                    </div>
                </form>
            </article>
        </section>

    <?php endif ?>