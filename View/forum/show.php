<?php require '../View/header.php' ?>

<main class="main-forum">

    <div class="forum-page">
        <section class="container-forum">
            <article class="forum-show">
                <h2 class="title title-post"><?= $postF->get_title_post() ?>

                    <?php if($postF->get_resolve() == 'resolve'): ?>
                        <span><br>[Post résolu]</span>
                    <?php endif ?>

                </h2>
                <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                <p class="date"><?= $postF->get_date_post() ?></p>

                <?php if($postF->get_id_member_FK() != 'NULL'): ?>
                    <p class="username"><?= $postF->get_member()->get_username() ?></p>
                <?php else: ?>

                    <p class="member-not-exist">[Ce membre n'existe plus]</p>

                <?php endif ?>

                <p class="category-post">Catégorie : <?= $postF->get_categorie() ?></p>
                <p class="text text-post"><?= $postF->get_text_post() ?></p>

                <form class="form-edit-post" method="post">

                    <div class="form-group">
                        <input class="form-control" type="text" name="title_post" value="<?= $postF->get_title_post() ?>">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="editor" name="text_post"><?= $postF->get_text_post() ?></textarea>
                    </div>
                </form>

                <div class="container-btn-post">
                    <div class="btn-comment-post">
                        <?php if($this->is_granted(['ROLE_USER', 'ROLE_ADMIN'])): ?>
                            <a class="btn-site" href="#">
                                <label for="toggle-comment">Commenter</label>
                            </a>
                        <?php else: ?>

                            <p>Vous devez être connecté pour pouvoir liker ou commenter un article</p>

                        <?php endif ?>
                    </div>

                    <div class="btn-admin-post">
                        
                        <?php if($this->is_granted(['ROLE_ADMIN'])): ?>

                            <form action="<?= $this->router->generate('delete_post') ?>" method="post">
                                <input type="hidden" name="token_session" value="<?= $this->member->get_token_session() ?>">
                                <input type="hidden" name="id" value="<?= $postF->get_id() ?>">
                                <input class="btn-site" value="Supprimer post" type="submit">
                            </form>

                            <div>

                                <a class="btn-site btn-edit-post"  data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="<?= $postF->get_id() ?>">Editer post</a>

                                <a class="btn-site cancel-post" href="#">Annuler</a>
                            </div>


                            <?php if($postF->get_resolve() == 'resolve' && $this->voter($postF)): ?> <!-- the button is show only if the post is not resolved and if the connected user is Admin, or has the post -->
                                <form method="post">
                                    <input type="hidden" name="resolve" value="resolve">
                                    <input class="btn-site btn-resolve" type="submit" value="Résoudre">
                                </form>
                            <?php endif ?>

                        <?php endif ?>
                    </div>

                </div>

            </article>
        </section>

        <input id="toggle-comment" type="checkbox">
        <div class="form-comment-post">
            <?php if($this->is_granted(['ROLE_USER', 'ROLE_ADMIN'])): ?>
                <form method="post">
                    <input class="message-comment-post" type="text">
                    <input class="btn-site" type="submit" value="Envoyer">
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
                        <p class="date">{{ comment.DateCommentPost|date('D d M Y') }}</p>
                        <p class="username username-comment">{{ comment.IdMemberFK.username }}</p>
                        <p class="text-post-comment content-comment{{ comment.id }}">{{ comment.TextCommentPost }}</p>

                        <form class="form-edit-comment form-edit-comment{{ comment.id }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token('edit-comment-post' ~ comment.id) }}">
                            <textarea class="content-comment-edit content-comment-edit{{ comment.id }}" name="text_comment_post"></textarea>
                        </form>

                        <div class="btn-comment">
                            {% if is_granted('MODIFPOSTCOMMENT', comment) %}
                                <a class="btn-site btn-edit-comment" data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="{{ comment.id }}" href="{{ path('edit_comment_post', {'id':comment.Id}) }}">Editer commentaire</a>
                                <a class="btn-site cancel-comment cancel-comment{{ comment.id }}" href="#">Annuler</a>
                            {% endif %}

                            {% if is_granted('MODIFPOSTCOMMENT', comment) %}
                                {{ include('forum/commentsPost/delete.html.twig') }}
                            {% endif %}
                        </div>
                        
                        {% if is_granted('ROLE_USER') %}
                            <a class="btn-site response-btn" href="#" data-id="{{ comment.Id }}">Répondre</a>
                        {% endif %}
                    </article>

                    {% for response in comment.getResponses %}

                        <article class="response-post">
                            {% if app.session.get('_locale') == 'fr_FR' %}
                                <p class="date date-response">{{ response.dateFormat }}</p>
                            {% else %}
                                <p class="date date-response">{{ response.DateResponse|date('D d M Y') }}</p>
                            {% endif %}
                            <p class="username">{{ response.IdMemberFK.username }}</p>
                            <p class="text-post-response content-response{{ response.id }}">{{ response.TextResponse }}</p>

                            <form class="form-edit-response form-edit-response{{ response.id }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token('edit-response-post' ~ response.id) }}">
                                <textarea class="content-response-edit content-response-edit{{ response.id }}" name="text_response_post"></textarea>
                            </form>

                            <div class="btn-response">
                                {% if is_granted('MODIFRESPONSE', response) %}
                                    <a class="btn-site btn-edit-response" data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="{{ response.id }}" href="{{ path('edit_response_post', {'id':response.Id}) }}">{% trans %}Editer réponse{% endtrans %}</a>
                                    <a class="btn-site cancel-response cancel-response{{ response.id }}" href="#">{% trans %}Annuler{% endtrans %}</a>
                                {% endif %}

                                {% if is_granted('MODIFRESPONSE', response) %}
                                    {{ include('forum/responsesPost/delete.html.twig') }}
                                {% endif %}
                            </div>
                        </article>

                    {% endfor %}

                    <div class="contain-response{{ comment.Id }}">

                    </div>

                </section>
            <?php endforeach ?>

            <div class="contain-form-response">
                {{ form_start(formResponse) }}
                {{ form_widget(formResponse.text_response, {'attr': {'class': 'message-edit-response'} }) }}
                <input type="hidden" value="" name="id_comment">
                <input class="btn-site" type="submit" value="Envoyer">
                {{ form_end(formResponse) }}
            </div>

            <div class="link-post-page">
                <a class="btn-site link-return-posts" href="{{ path('posts_list') }}">Revenir à la liste des posts</a>
                <a class="btn-site link-return-homepage" href="{{ path('accueil') }}">Revenir à l'accueil</a>
            </div>

        </div>
    </div>

</main>

<script src="http://localhost/js/editComment.js"></script>
<script src="http://localhost/js/editResponse.js"></script>
<script src="http://localhost/js/editPost.js"></script>
<script src="http://localhost/js/toggle-response.js"></script>
<script src="http://localhost/js/textTransform.js"></script>

<?php require '../View/footer.php' ?>