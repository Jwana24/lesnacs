<?php require '../View/header.php' ?>

<main class="main-forum">

    <div class="forum-page">

        <section class="container-forum">
            <article class="forum-show">

                <h2 class="title title-post"><?= $post->get_title_post() ?>
                    {% if post.Resolve == 'resolve' %}
                        <span><br>[{% trans %}Post résolu{% endtrans %}]</span>
                    {% endif %}
                </h2>
                <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                <p class="date"><?= $post->get_date_post() ?></p>
                {% if  not post.IdMemberFK == null %}
                <p class="username"><?= $post->get_id_member_FK()->get_username() ?></p>
                {% else %}
                <p class="member-not-exist">[Ce membre n'existe plus]</p>
                {% endif %}
                <p class="category-post">Catégorie : <?= $post->get_categorie() ?></p>
                <p class="text text-post"><?= $post->get_text_post() ?></p>

                <form class="form-edit-post" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token('edit-post' ~ post.id) }}">

                    <div class="form-group">
                        <input class="form-control" type="text" name="title_post" value="{{ post.TitlePost }}">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="editor" name="text_post"><?= $post->get_text_post() ?></textarea>
                    </div>
                </form>

                <div class="container-btn-post">

                    <div class="btn-comment-post">
                        <a class="btn-site" href="#">
                            <label for="toggle-comment">Commenter</label>
                        </a>
                    </div>

                    <div class="btn-admin-post">
                        
                        {% if is_granted('MODIFPOST', post) %}

                            <div>
                                {{ include('forum/delete.html.twig') }}

                                <a class="btn-site btn-edit-post"  data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="{{ post.id }}" href="{{ path('post_edit', {'id' : post.Id}) }}">Editer le post</a>

                                <a class="btn-site cancel-post" href="#">Annuler</a>
                            </div>

                            {% if post.Resolve != 'resolve' and is_granted('MODIFPOST', post) %} {# the button is show only if the post is not resolved and if the connected user is Admin, or has the post #}
                            <form method="post">
                                <input type="hidden" name="resolve" value="resolve">
                                <input class="btn-site btn-resolve" type="submit" value="Résoudre">
                            </form>
                            {% endif %}

                        {% endif %}
                    </div>

                </div>

            </article>
        </section>

        <input id="toggle-comment" type="checkbox">
        <div class="form-comment-post">
            <?php if($this->is_granted('ROLE_USER')): ?>
                <form method="post">
                    <input class="message-comment-post" type="text">
                    <input class="btn-site" type="submit" value="Envoyer">
                </form>
            <?php else: ?>
            
                <p>Vous devez être connecté pour pouvoir poster un commentaire</p>

            <?php endif ?>
        </div>

        <div class="post-comment">
            <?php foreach($comments as $comment): ?>
                <section class="comment-response-forum">
                    <article class="comment-post">
                        <!-- {% if app.session.get('_locale') == 'fr_FR' %} -->
                        <p class="date">{{ comment.DateCommentPost|date('D d M Y') }}</p>
                        <p class="username username-comment">{{ comment.IdMemberFK.username }}</p>
                        <p class="text-post-comment content-comment-post{{ comment.id }}">{{ comment.TextCommentPost }}</p>

                        <form class="form-edit-comment-post form-edit-comment-post{{ comment.id }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token('edit-comment-post' ~ comment.id) }}">
                            <textarea class="content-comment-edit-post content-comment-edit-post{{ comment.id }}" name="text_comment_post"></textarea>
                        </form>

                        <div class="btn-comment">
                            {% if is_granted('MODIFPOSTCOMMENT', comment) %}
                                <a class="btn-site btn-edit-comment" data-post="true" data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="{{ comment.id }}" href="{{ path('edit_comment_post', {'id':comment.Id}) }}">Editer commentaire</a>
                                <a class="btn-site cancel-comment-post cancel-comment-post{{ comment.id }}" href="#">Annuler</a>
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
                            <p class="text-post-response content-response-post{{ response.id }}">{{ response.TextResponse }}</p>

                            <form class="form-edit-response-post form-edit-response-post{{ response.id }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token('edit-response-post' ~ response.id) }}">
                                <textarea class="content-response-edit-post content-response-edit-post{{ response.id }}" name="text_response_post"></textarea>
                            </form>

                            <div class="btn-response">
                                {% if is_granted('MODIFRESPONSE', response) %}
                                    <a class="btn-site btn-edit-response" data-post="true" data-locale="{{ app.session.get('_locale') }}" data-toggle="false" data-id="{{ response.id }}" href="{{ path('edit_response_post', {'id':response.Id}) }}">{% trans %}Editer réponse{% endtrans %}</a>
                                    <a class="btn-site cancel-response-post cancel-response-post{{ response.id }}" href="#">{% trans %}Annuler{% endtrans %}</a>
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
                <a class="btn-site link-return-posts" href="{{ path('posts_list') }}">{% trans %}Revenir à la liste des posts{% endtrans %}</a>
                <a class="btn-site link-return-homepage" href="{{ path('accueil') }}">{% trans %}Revenir à l'accueil{% endtrans %}</a>
            </div>

            {% for message in app.flashes('success') %}
                <div id="flash-notice" class="text-center mx-auto">
                    {{ message }}
                </div>
            {% endfor %}
        </div>

    </div>

</main>

<script src="http://localhost/js/editComment.js"></script>
<script src="http://localhost/js/editResponse.js"></script>
<script src="http://localhost/js/editPost.js"></script>
<script src="http://localhost/js/toggle-response.js"></script>
<script src="http://localhost/js/textTransform.js"></script>

<?php require '../View/footer.php' ?>