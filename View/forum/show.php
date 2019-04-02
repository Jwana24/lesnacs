<?php require '../View/header.php' ?>

<main class="main-forum">

    <div class="forum-page">
        <section class="container-forum">
            <article class="forum-show">
                <h2 class="title title-post"><?= $postF->get_title_post() ?> </h2>

                <h2 class="text-resolve">
                    <?php if($postF->get_resolve() == 'resolve'): ?>
                        <span>[<?= $this->translation('Post résolu') ?>]</span>
                    <?php endif ?>
                </h2>

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

                                <a class="container-comment-post">
                                    <label class="label-comment-post" title="<?= $this->translation('Commenter le post') ?>" for="toggle-comment"></label>
                                    <i class="icone-comment-post far fa-comment-dots"></i>
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
                                <div class="container-delete-post">
                                    <i class="icone-delete-post far fa-trash-alt"></i>
                                    <input class="btn-delete-post" onclick="return confirm('Etes-vous sûr de vouloir supprimer le post ?');" title="<?= $this->translation('Supprimer le post') ?>" type="submit">
                                </div>
                            </form>

                            <div>

                                <a><i class="btn-edit-post fas fa-pencil-alt" title="<?= $this->translation('Editer le post') ?>" data-locale="<?= $this->lang ?>" data-toggle="false" data-id="<?= $postF->get_id() ?>"style="cursor:pointer;"></i></a>

                                <a><i class="cancel-post fas fa-times" title="<?= $this->translation('Annuler') ?>" style="color:red; cursor:pointer;"></i></a>
                            </div>

                            <?php if($this->voter($postF) && $postF->get_resolve() != 'resolve'): ?> <!-- if the connected user is Admin, or has the post and the post is not resolved -->
                                <i class="icone-resolve resolve fas fa-lock-open" data-locale="<?= $this->lang ?>" data-id="<?= $postF->get_id() ?>" style="cursor:pointer;" title="<?= $this->translation('Résoudre ce post') ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-lock"></i>
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
                                <a><i class="btn-edit-comment fas fa-pencil-alt" title="<?= $this->translation('Editer le commentaire') ?>" data-locale="<?= $this->lang ?>" data-toggle="false" data-id="<?= $comment->get_id() ?>"></i></a>

                                <a><i class="fas fa-times cancel-comment cancel-comment<?= $comment->get_id() ?>" title="<?= $this->translation('Annuler') ?>" style="color:red; cursor:pointer;"></i></a>

                                <form action="<?= $this->router->generate('delete_comment') ?>" method="post">
                                    <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                    <input type="hidden" name="form" value="delete-comment-post">
                                    <input type="hidden" name="id" value="<?= $comment->get_id() ?>">
                                    <input type="hidden" name="idSubject" value="<?= $postF->get_id() ?>">
                                    <div class="container-delete-comment">
                                        <i class="icone-delete-comment far fa-trash-alt"></i>
                                        <input class="btn-delete-comment" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce commentaire ?');" title="<?= $this->translation('Supprimer le commentaire') ?>" type="submit">
                                    </div>
                                </form>
                            <?php endif ?>
                        </div>
                        
                        <?php if($this->is_granted(['ROLE_USER']) && $postF->get_resolve() != 'resolve'): ?>
                            <a class="btn-reply"><i class="response-btn fas fa-reply fa-rotate-180" title="<?= $this->translation('Répondre') ?>" data-id="<?= $comment->get_id() ?>"></i></a>
                        <?php endif ?>
                    </article>

                    <?php foreach($comment->get_responses() as $response): ?>

                        <article class="response-post">
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
                                    <a><i class="btn-edit-response fas fa-pencil-alt" title="<?= $this->translation('Editer la réponse') ?>" data-locale="<?= $this->lang ?>" data-toggle="false" data-id="<?= $response->get_id() ?>"></i></a>
                                    
                                    <a><i class="fas fa-times cancel-response cancel-response<?= $response->get_id() ?>" title="<?= $this->translation('Annuler') ?>" style="color:red; cursor:pointer;"></i></a>

                                    <form action="<?= $this->router->generate('delete_comment') ?>" method="post">
                                        <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                        <input type="hidden" name="form" value="delete-response-post">
                                        <input type="hidden" name="id" value="<?= $response->get_id() ?>">
                                        <input type="hidden" name="idSubject" value="<?= $postF->get_id() ?>">
                                        <div class="container-delete-response">
                                            <i class="icone-delete-response far fa-trash-alt"></i>
                                            <input class="btn-delete-response" title="<?= $this->translation('Supprimer réponse') ?>" type="submit" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette réponse ?');">
                                        </div>
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
<script src="<?= $this->asset('js/resolvePost.js') ?>"></script>

<?php require '../View/footer.php' ?>