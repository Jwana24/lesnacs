<?php require 'header.php' ?>

<main class="container">

    <!-- {% if error %}
        <span>{{ error }}</span>
    {% endif %} -->

        <div class="row justify-content-md-center content-form-co">
            <div class="col-4">

                <!-- <form class="form-signin" action="{{ path('login') }}" method="post"> -->

                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" name="_username" placeholder="Pseudo" required="" autofocus="">
                        <input class="form-control" type="password" name="_password" placeholder="Mot de passe" required="">
                    </div>

                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" value="Se connecter">
                    </div>
                </form>

                    <!-- <a class="btn-site" href="{{ path('lostpassword') }}">Mot de passe oublié ?</a>
                    <a class="btn-site" href="{{ path('accueil') }}">Revenir à la page d'accueil</a> -->

            </div>
        </div>

</main>