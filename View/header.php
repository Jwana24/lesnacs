<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $titlePage ?? 'Le site LesNACs' ?></title>
     <!-- Bootstrap links, CSS content to Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/css/style.css">
    <link rel="icon" type="image/png" href="http://localhost/images/icone-site-lesnac-16px.svg" />
</head>
<body>
    
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="<?= $this->router->generate('accueil') ?>"><img class="logo-site" src="http://localhost/images/logo-site-lesnac.svg" alt="Logo du site Les Nacs"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('accueil') ?>">Accueil</a>
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
            
                <?php if($this->is_granted('ROLE_USER')): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon style="color: white" name="person"></ion-icon></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04">
                            <!-- <a class="dropdown-item" href="{{ path('logout') }}">Déconnexion</a> -->
                            <!-- <a class="dropdown-item" href="{{ path('member_show', {'id':app.user.id}) }}">Profil de {{ app.user.username }}</a> -->
                            <?php if($this->is_granted('ROLE_ADMIN')): ?>
                                <!-- <a class="dropdown-item" href="{{ path('members_list', {'id':app.user.id}) }}">Liste des membres</a> -->
                            <?php endif ?>
                        </div>
                    </li>
                
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon class="icon" style="color: white" name="globe"></ion-icon></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04">
                            <!-- <a class="dropdown-item" href="{{ path('translation', {'_language':'fr_FR', 'last_path':last_path}) }}">Français</a>
                            <a class="dropdown-item" href="{{ path('translation', {'_language':'en', 'last_path':last_path}) }}">Anglais</a> -->
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

            <form class="form-inline my-2 my-md-0" action="{{ path('search', {'pageArticle': 1,'pagePost': 1}) }}" method="get">
                <input class="form-control" name="itemSearch" type="text" placeholder="Recherche">
            </form>
        </div>
    </nav>

    {% if not is_granted('ROLE_USER') %}

        <section class="modal_inscription">
            <article class="center_modal_inscription">
                <ion-icon class="cross-close" name="close"></ion-icon>
                <h4>Inscription</h4>
                <form name="member" method="post" enctype="multipart/form-data">
                    <div id="member">

                        <div>
                            <input type="text" placeholder="Nom" id="member_last_name" name="member[last_name]" required maxlength="50" pattern="^[a-zA-Z \-]{5,50}$" title="Votre nom n'est pas valide, il ne doit contenir aucun accent"/>
                        </div>

                        <div>
                            <input type="text" placeholder="Prénom" id="member_first_name" name="member[first_name]" required maxlength="50" pattern="^[a-zA-Z \-àáâãäåçèéêëìíîïðòóôõöùúûüýÿ]{5,50}$" title="Votre prénom n'est pas valide"/>
                        </div>

                        <div>
                            <input type="text" placeholder="Pseudo" id="member_username" name="member[username]" required maxlength="50" pattern=".{2,50}" title="Votre pseudo doit faire entre 2 et 50 caractères" />
                        </div>

                        <div>
                            <input type="password" id="member_password_first" placeholder="Mot de passe" name="member[password][first]" class="password-field" required pattern="^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!&+=]).{8,})$" title="Votre mot de passe doit contenir au minimum 8 caractères, au moins un chiffre, une lettre et un caractère spécial tel que (@, #, $, %, !, &, + et =)" />
                        </div>

                        <div>
                            <input type="password" id="member_password_second" placeholder="Confirmation du mot de passe" name="member[password][second]" class="password-field" required />
                        </div>

                        <div>
                            <input type="email" placeholder="Email" id="member_mail" name="member[mail]" required maxlength="200" />
                        </div>

                        <div>
                            <input type="text" placeholder="Description (facultatif)" id="member_description" name="member[description]" maxlength="500" />
                        </div>

                        <div>
                            <label for="member_avatar">Avatar</label>
                            <input type="file" placeholder="Avatar" id="member_avatar" name="member[avatar]" />
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
                <form name="member-co" action="<?= $this->router->generate('connexion') ?>" method="POST">
                    <div id="member-co">
                        <input type="hidden" name="_target_path" value="<?= $this->router->generate('accueil') ?>" />
                        <div>
                            <input type="text" name="_username" placeholder="Pseudo" required="">
                        </div>

                        <div>
                            <input type="password" name="_password" placeholder="Mot de passe" required>
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

    {% endif %}


    <div class="alert alert-success inscription-success" role="alert">
        Vous avez été inscrit avec succès !
    </div>

    <div class="alert alert-danger inscription-error" role="alert">
        Une erreur s'est produite
    </div>
    
</body>
</html>