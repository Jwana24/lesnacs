<?php require '../View/header.php' ?>

<main class="main-forum">

    <div class="forum-page">
        <section class="container-forum">
            <article class="forum-show">
                <h2 class="title title-post"><?= $postF->get_title_post() ?>

                    <?php if($postF->get_resolve() == 'resolve'): ?>
                        <span><br>[<?= $this->translation('Post résolu') ?>]</span>
                    <?php endif ?>

                </h2>
                <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                <p class="date"><?= $postF->get_date_post() ?></p>

                <?php if($postF->get_id_member_FK() != 'NULL'): ?>
                    <p class="username"><?= $postF->get_member()->get_username() ?></p>
                <?php else: ?>

                    <p class="member-not-exist">[Ce membre n'existe plus]</p>

                <?php endif ?>

                <p class="category-post"><?= $this->translation('Catégorie') ?> : <?= $this->translation($postF->get_categorie()) ?></p>
                <div class="text text-post"><?= $postF->get_text_post() ?></div>

                <form class="form-edit-post" data-id="<?= $postF->get_id() ?>" method="post">
                    <div class="form-group">
                        <input class="form-control" type="text" name="title_post" value="<?= $postF->get_title_post() ?>">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="editor1" name="text_post"><?= $postF->get_text_post() ?></textarea>
                    </div>
                </form>

                <div class="container-btn-post">
                    <div class="btn-comment-post">
                        <?php if($postF->get_resolve() != 'resolve'): ?>
                            <?php if($this->is_granted(['ROLE_USER'])): ?>
                                <a class="btn-site" href="#">
                                    <label for="toggle-comment"><?= $this->translation('Commenter') ?></label>
                                </a>
                            <?php else: ?>

                                <p>Vous devez être connecté pour pouvoir liker ou commenter un post</p>

                            <?php endif ?>
                        <?php endif ?>
                    </div>

                    <div class="btn-admin-post">
                        
                        <?php if($this->voter($postF)): ?>

                            <form action="<?= $this->router->generate('delete_post') ?>" method="post">
                                <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                <input type="hidden" name="id" value="<?= $postF->get_id() ?>">
                                <input class="btn-site" value="<?= $this->translation('Supprimer post') ?>" type="submit">
                            </form>

                            <div>

                                <a class="btn-site btn-edit-post"  data-locale="<?= $this->lang ?>" data-toggle="false" data-id="<?= $postF->get_id() ?>"><?= $this->translation('Editer post') ?></a>

                                <a class="cancel-post" href="#"><?= $this->translation('Annuler') ?></a>
                            </div>


                            <?php if($this->voter($postF) && $postF->get_resolve() != 'resolve'): ?> <!-- the button is show only if the post is not resolved and if the connected user is Admin, or has the post -->
                                <form method="post">
                                    <input type="hidden" name="form" value="resolve">
                                    <input class="btn-site btn-resolve" type="submit" value="<?= $this->translation('Résoudre') ?>">
                                </form>
                            <?php endif ?>

                        <?php endif ?>
                    </div>
                </div>

            </article>
        </section>

        <input id="toggle-comment" type="checkbox">
        <div class="form-comment-post">

            <?php if($this->is_granted(['ROLE_USER'])): ?>
                <form method="post">
                    <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                    <input type="hidden" name="form" value="form-comment">
                    <input class="message-comment-post" type="text" name="text_comment">
                    <input class="btn-site" type="submit" value="<?= $this->translation('Envoyer') ?>">
                </form>
            <?php else: ?>
            
                <p>Vous devez être connecté pour pouvoir poster un commentaire</p>

            <?php endif ?>
        </div>

        <div class="post-comment">
            <?php foreach($postF->get_comments() as $comment): ?>
                <section class="comment-response-forum">
                    <article class="comment-post">
                        <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                        <p class="date"><?= $comment->get_date_comment() ?></p>
                        <p class="username username-comment"><?= $comment->get_member()->get_username() ?></p>
                        <p class="text-post-comment content-comment<?= $comment->get_id() ?>"><?= $comment->get_text_comment() ?></p>

                        <?php if($this->is_granted(['ROLE_USER'])): ?>
                            <form class="form-edit-comment form-edit-comment<?= $comment->get_id() ?>" method="post">
                                <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                <textarea class="content-comment-edit content-comment-edit<?= $comment->get_id() ?>" name="text_comment"></textarea>
                            </form>
                        <?php endif ?>

                        <div class="btn-comment">
                            <?php if($this->voter($comment)): ?>
                                <a class="btn-site btn-edit-comment" data-locale="<?= $this->lang ?>" data-toggle="false" data-id="<?= $comment->get_id() ?>"><?= $this->translation('Editer commentaire') ?></a>

                                <a class="btn-site cancel-comment cancel-comment<?= $comment->get_id() ?>" href="#"><?= $this->translation('Annuler') ?></a>

                                <form action="<?= $this->router->generate('delete_comment') ?>" method="post">
                                    <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                    <input type="hidden" name="form" value="delete-comment-post">
                                    <input type="hidden" name="id" value="<?= $comment->get_id() ?>">
                                    <input type="hidden" name="idSubject" value="<?= $postF->get_id() ?>">
                                    <input class="btn-site" value="<?= $this->translation('Supprimer commentaire') ?>" type="submit">
                                </form>
                            <?php endif ?>
                        </div>
                        
                        <?php if($this->is_granted(['ROLE_USER']) && $postF->get_resolve() != 'resolve'): ?>
                            <a class="btn-site response-btn" href="#" data-id="<?= $comment->get_id() ?>"><?= $this->translation('Répondre') ?></a>
                        <?php endif ?>
                    </article>

                    <?php foreach($comment->get_responses() as $response): ?>

                        <article class="response-post">
                            <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                            <p class="date date-response"><?= $response->get_date_comment() ?></p>
                            <p class="username"><?= $response->get_member()->get_username() ?></p>
                            <p class="text-post-response content-response<?= $response->get_id() ?>"><?= $response->get_text_comment() ?></p>

                            <?php if($this->is_granted(['ROLE_USER'])): ?>
                                <form class="form-edit-response form-edit-response<?= $response->get_id() ?>" method="post">
                                    <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                    <textarea class="content-response-edit content-response-edit<?= $response->get_id() ?>" name="text_comment"></textarea>
                                </form>
                            <?php endif ?>

                            <div class="btn-response">
                                <?php if($this->voter($response)): ?>
                                    <a class="btn-site btn-edit-response" data-locale="<?= $this->lang ?>" data-toggle="false" data-id="<?= $response->get_id() ?>"><?= $this->translation('Editer réponse') ?></a>
                                    
                                    <a class="btn-site cancel-response cancel-response<?= $response->get_id() ?>" href="#"><?= $this->translation('Annuler') ?></a>

                                    <form action="<?= $this->router->generate('delete_comment') ?>" method="post">
                                        <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                        <input type="hidden" name="form" value="delete-response-post">
                                        <input type="hidden" name="id" value="<?= $response->get_id() ?>">
                                        <input type="hidden" name="idSubject" value="<?= $postF->get_id() ?>">
                                        <input class="btn-site" type="submit" value="<?= $this->translation('Supprimer réponse') ?>">
                                    </form>
                                <?php endif ?>
                            </div>
                        </article>

                    <?php endforeach ?>

                    <div class="contain-response<?= $comment->get_id() ?>"></div>
                </section>

            <?php endforeach ?>

            <?php if($this->is_granted(['ROLE_USER'])): ?>
                <div class="contain-form-response">
                    <form method="post">
                        <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                        <input type="hidden" name="form" value="form-response">
                        <input type="hidden" name="id_comment" value="">
                        <textarea class="message-edit-response" name="text_comment"></textarea>
                        <input class="btn-site btn-send-response" type="submit" value="Envoyer">
                    </form>
                </div>
            <?php endif ?>

            <div class="link-post-page">
                <a class="btn-site link-return-posts" href="<?= $this->router->generate('post_list') ?>"><?= $this->translation('Revenir à la liste des posts') ?></a>
                <a class="btn-site link-return-homepage" href="<?= $this->router->generate('accueil') ?>"><?= $this->translation('Revenir à l\'accueil') ?></a>
            </div>

        </div>
    </div>

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

<script src="<?= $this->asset('js/editPost.js') ?>"></script>
<script src="<?= $this->asset('js/editComment.js') ?>"></script>
<script src="<?= $this->asset('js/editResponse.js') ?>"></script>
<script src="<?= $this->asset('js/toggle-response.js') ?>"></script>
<script src="<?= $this->asset('js/textTransform.js') ?>"></script>

<?php require '../View/footer.php' ?>