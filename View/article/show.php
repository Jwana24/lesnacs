<?php require '../View/header.php' ?>

<main class="main-article">

    <div class="article-page">

        <section class="container-article">
            <article class="article-show">

                <img class="image" src="<?= $this->asset($article->get_image()) ?>" alt="Image de l'article">
                <h2 class="title title-article"><?= $article->get_title_article() ?></h2>
                <p class="date"><?= $article->get_date_article() ?></p>
                <div class="text text-article"><?= $article->get_text_article() ?></div>
                
                <form class="form-edit-article" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <input class="form-control" type="text" name="title_article" value="<?= $article->get_title_article() ?>">
                    </div>

                    <div class="form-group" id="editor">
                        <?= $article->get_text_article() ?>
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

                <div class="like" data-tokencsrf="<?= $this->member->get_token_session() ?>" data-id="<?= $article->get_id() ?>">
                    <?php if($this->is_granted(['ROLE_USER'])): ?>
                        <ion-icon name="heart"></ion-icon>
                        <ion-icon name="heart-empty"></ion-icon>
                    <?php endif ?>
                <p class="nb-like-article"><?= $nbLike ?> likes</p>
                </div>

                <div class="container-btn-article">
                    <div class="like-article">
                        <?php if($this->is_granted(['ROLE_USER'])): ?>

                            <a class="container-comment-article">
                                <label class="btn-comment-article" title="<?= $this->translation('Commenter l\'article') ?>" for="toggle-comment"></label>
                                <i class="icone-comment-article far fa-comment-dots"></i>
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

                                <div class="container-delete-article">
                                    <i class="icone-delete-article far fa-trash-alt"></i>
                                    <input class="btn-delete-article" onclick="return confirm('Etes-vous sûr de vouloir supprimer l\'article ?');" title="<?= $this->translation('Supprimer l\'article') ?>" type="submit">
                                </div>
                            </form>

                            <a><i class="btn-edit-article fas fa-pencil-alt" title="<?= $this->translation('Editer l\'article') ?>" data-locale="<?= $this->lang ?>" data-toggle="false" data-tokencsrf="<?= $this->member->get_token_session() ?>" data-id="<?= $article->get_id() ?>" style="cursor:pointer;"></i></a>

                            <a><i class="cancel-article fas fa-times" title="<?= $this->translation('Annuler') ?>" style="color:red; cursor:pointer;"></i></a>

                        <?php endif ?>
                    </div>
                </div>

            </article>
        </section>

        <input id="toggle-comment" type="checkbox">
        <div class="form-comment-article">

            <?php if($this->is_granted(['ROLE_USER'])): ?>
                <form method="post">
                    <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                    <input type="hidden" name="form" value="form-comment">
                    <input class="message-comment-article" type="text" name="text_comment">
                    <input class="btn-site" type="submit" value="<?= $this->translation('Envoyer') ?>">
                </form>
            <?php endif ?>

        </div>

        <div class="article-comment">
            <?php foreach($article->get_comments() as $comment): ?>
                <section class="comment-response-article">
                    <article class="comment-article">
                        <p class="date" style="margin-top:40px;"><?= $comment->get_date_comment() ?></p>
                        <p class="username username-comment"><?= $comment->get_member()->get_username() ?></p>
                        <p class="text-article-comment content-comment<?= $comment->get_id() ?>"><?= $comment->get_text_comment() ?></p>
                        
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
                                    <input type="hidden" name="form" value="delete-comment-art">
                                    <input type="hidden" name="id" value="<?= $comment->get_id() ?>">
                                    <input type="hidden" name="idSubject" value="<?= $article->get_id() ?>">

                                    <div class="container-delete-comment">
                                        <i class="icone-delete-comment far fa-trash-alt"></i>
                                        <input class="btn-delete-comment" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce commentaire ?');" title="<?= $this->translation('Supprimer le commentaire') ?>" type="submit">
                                    </div>
                                </form>
                            <?php endif ?>
                        </div>

                        <?php if($this->is_granted(['ROLE_USER'])): ?>
                            <a><i class="response-btn fas fa-reply fa-rotate-180" title="<?= $this->translation('Répondre') ?>" data-id="<?= $comment->get_id() ?>"></i></a>
                        <?php endif ?>
                    </article>

                    <?php foreach($comment->get_responses() as $response): ?>

                        <article class="response-article">
                            <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                            <p class="date date-response"><?= $response->get_date_comment() ?></p>
                            <p class="username"><?= $response->get_member()->get_username() ?></p>
                            <p class="text-article-response content-response<?= $response->get_id() ?>"><?= $response->get_text_comment() ?></p>

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
                                        <input type="hidden" name="form" value="delete-response-art">
                                        <input type="hidden" name="id" value="<?= $response->get_id() ?>">
                                        <input type="hidden" name="idSubject" value="<?= $article->get_id() ?>">

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
                        <input class="btn-site btn-send-response" type="submit" value="<?= $this->translation('Envoyer') ?>">
                    </form>
                </div>
            <?php endif ?>

            <div class="link-article-page">
                <a class="btn-site link-return-articles" href="<?= $this->router->generate('article_list') ?>"><?= $this->translation('Revenir à la liste des articles') ?></a>
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

<script src="<?= $this->asset('js/editArticle.js') ?>"></script>
<script src="<?= $this->asset('js/editComment.js') ?>"></script>
<script src="<?= $this->asset('js/editResponse.js') ?>"></script>
<script src="<?= $this->asset('js/likeArticle.js') ?>"></script>
<script src="<?= $this->asset('js/toggle-response.js') ?>"></script>
<script src="<?= $this->asset('js/textTransform.js') ?>"></script>

<?php require '../View/footer.php' ?>