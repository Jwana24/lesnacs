<?php require '../View/header.php' ?>

<main class="main-article">

    <div class="article-page">

        <section class="container-article">
            <article class="article-show">

                <img class="image" src="http://localhost/<?= $article->get_image() ?>" alt="Image de l'article">
                <h2 class="title title-article"><?= $article->get_title_article() ?></h2>
                <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                <p class="date"><?= $article->get_date_article() ?></p>
                <p class="text text-article"><?= $article->get_text_article() ?></p>
                
                <form class="form-edit-article" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <input class="form-control" type="text" name="title_article" value="<?= $article->get_title_article() ?>">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="editor" name="text_article"><?= $article->get_text_article() ?></textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" name="image">
                    </div>
                </form>

                <!-- Pass the value from PHP to JS if the connected member has already liked or not -->
                <?php if($like): ?>
                    <div class="member-like" data-like="true" style="display:none"></div>
                <?php else: ?>
                    <div class="member-like" data-like="false" style="display:none"></div>
                <?php endif ?>

                <div class="like" data-id="<?= $article->get_id() ?>">
                    <?php if($this->is_granted(['ROLE_USER', 'ROLE_ADMIN'])): ?>
                        <ion-icon name="heart"></ion-icon>
                        <ion-icon name="heart-empty"></ion-icon>
                    <?php endif ?>
                <p class="nb-like-article"><?= $nbLike ?> likes</p>
                </div>

                <div class="container-btn-article">
                    <div class="like-article">
                        <?php if($this->is_granted(['ROLE_USER', 'ROLE_ADMIN'])): ?>

                            <a class="btn-site" href="#">
                            <label for="toggle-comment">Commenter</label>
                            </a>

                        <?php else: ?>

                            <p>Vous devez être connecté pour pouvoir liker ou commenter un article</p>

                        <?php endif ?>
                    </div>

                    <div class="btn-admin-article">
                        <?php if($this->is_granted(['ROLE_ADMIN'])): ?>

                            <form action="<?= $this->router->generate('delete_article') ?>" method="post">
                                <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                <input type="hidden" name="id" value="<?= $article->get_id() ?>">
                                <input class="btn-site" value="Supprimer article" type="submit">
                            </form>

                            <a class="btn-site btn-edit-article" data-locale="fr_FR" data-toggle="false" data-id="<?= $article->get_id() ?>" href="#">Editer article</a>

                            <a class="btn-site cancel-article" href="#">Annuler</a>

                        <?php endif ?>
                    </div>
                </div>

            </article>
        </section>

        <input id="toggle-comment" type="checkbox">
        <div class="form-comment-article">

            <?php if($this->is_granted(['ROLE_USER', 'ROLE_ADMIN'])): ?>
                <form method="post">
                    <input type="hidden" name="form" value="form-comment">
                    <input class="message-comment-article" type="text" name="text_comment">
                    <input class="btn-site" type="submit" value="Envoyer">
                </form>
            <?php endif ?>

        </div>

        <div class="article-comment">
            <?php foreach($article->get_comments() as $comment): ?>
                <section class="comment-response-article">
                    <article class="comment-article">
                        <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                        <p class="date"><?= $comment->get_date_comment() ?></p>
                        <p class="username username-comment"><?= $comment->get_member()->get_username() ?></p>
                        <p class="text-article-comment content-comment<?= $comment->get_id() ?>"><?= $comment->get_text_comment() ?></p>
                        
                        <form class="form-edit-comment form-edit-comment<?= $comment->get_id() ?>" method="post">
                            <textarea class="content-comment-edit content-comment-edit<?= $comment->get_id() ?>" name="text_comment"></textarea>
                        </form>

                        <div class="btn-comment">
                            <?php if($this->voter($comment)): ?>
                                <a class="btn-site btn-edit-comment" data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="<?= $comment->get_id() ?>" href="<?= $this->router->generate('article_show', ['id' => $comment->get_id()]) ?>">Editer commentaire</a>

                                <a class="btn-site cancel-comment cancel-comment<?= $comment->get_id() ?>" href="#">Annuler</a>

                                <form action="<?= $this->router->generate('delete_comment') ?>" method="post">
                                    <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                    <input type="hidden" name="id" value="<?= $comment->get_id() ?>">
                                    <input type="hidden" name="idArt" value="<?= $article->get_id() ?>">
                                    <input class="btn-site" value="Supprimer commentaire" type="submit">
                                </form>
                            <?php endif ?>
                        </div>

                        <?php if($this->is_granted(['ROLE_USER'])): ?>
                            <a class="btn-site response-btn" href="#" data-id="{{ comment.Id }}">Répondre</a>
                        <?php endif ?>
                    </article>

                    <?php foreach($comment->get_responses() as $response): ?>

                        <article class="response-article">
                            <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                            <p class="date date-response"><?= $response->get_id() ?></p>
                            <p class="username"><?= $response->get_member()->get_username() ?></p>
                            <p class="text-article-response content-response<?= $response->get_id() ?>"><?= $response->get_text_comment() ?></p>

                            <form class="form-edit-response form-edit-response<?= $response->get_id() ?>" method="post">
                                <textarea class="content-response-edit content-response-edit<?= $response->get_id() ?>" name="text_response"></textarea>
                            </form>

                            <div class="btn-response">
                                <?php if($this->voterArticle()): ?>
                                    <a class="btn-site btn-edit-response" data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="<?= $response->get_id() ?>" href="<?= $this->router->generate('article_show', ['id' => $response->get_id()]) ?>">Editer réponse</a>
                                    
                                    <a class="btn-site cancel-response cancel-response<?= $response->get_id() ?>" href="#">Annuler</a>
                                <?php endif ?>

                                <?php if($this->voterArticle()): ?>
                                    {{ include('article/responses/delete.html.twig') }}
                                <?php endif ?>
                            </div>
                        </article>

                    <?php endforeach ?>
                    
                    <div class="contain-response{{ comment.Id }}">

                    </div>
                </section>

            <?php endforeach ?>

            <div class="contain-form-response">
                <form action="">
                    <input class="message-edit-response" type="text">
                    <input type="hidden" value="" name="id_comment">
                    <input class="btn-site btn-send-response" type="submit" value="Envoyer">
                </form>
            </div>

            <div class="link-article-page">
                <a class="btn-site link-return-articles" href="<?= $this->router->generate('article_list') ?>">Revenir à la liste des articles</a>
                <a class="btn-site link-return-homepage" href="<?= $this->router->generate('accueil') ?>">Revenir à l'accueil</a>
            </div>

            {% for message in app.flashes('success') %}
                <div id="flash-notice" class="text-center mx-auto">
                    {{ message }}
                </div>
            {% endfor %}
        </div>

    </div>

</main>

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

<script src="http://localhost/js/editArticle.js"></script>
<script src="http://localhost/js/editComment.js"></script>
<script src="http://localhost/js/editResponse.js"></script>
<script src="http://localhost/js/likeArticle.js"></script>
<script src="http://localhost/js/toggle-response.js"></script>

<?php require '../View/footer.php' ?>