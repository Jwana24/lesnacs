<?php require '../View/header.php' ?>

<main class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-12 col-md-6 border">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center pagination-articles">
                    <!-- The arrow appears if the current page is not the first page -->
                    <?php if($pageArticle > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=1&pagePost=<?= $pagePost ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif ?>

                    <?php if($numberPagesArticles <= 3): ?>
                        <li class="page-item <?php if($pageArticle == 1): ?>active<?php endif ?>">
                            <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=1&pagePost=<?= $pagePost ?>">1</a>
                        </li>

                        <?php if($numberPagesArticles >= 2): ?>
                            <li class="page-item <?php if($pageArticle == 2): ?>active<?php endif ?>">
                                <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=2&pagePost=<?= $pagePost ?>">2</a>
                            </li>
                        <?php endif ?>

                        <?php if($numberPagesArticles >= 3): ?>
                            <li class="page-item <?php if($pageArticle == 3): ?>active<?php endif ?>">
                                <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=3&pagePost=<?= $pagePost ?>">3</a>
                            </li>
                        <?php endif ?>

                    <!-- If there are more than 3 pages, it's show the current page and the next two -->
                    <?php else: ?>

                        <li class="page-item active">
                            <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=<?= $pagePost ?>"><?= $pageArticle ?></a>
                        </li>

                        <?php if(($pageArticle + 1) <= $numberPagesArticles): ?>
                            <li class="page-item <?php if($pageArticle == $pageArticle + 1): ?>active<?php endif ?>">
                                <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle + 1 ?>&pagePost=<?= $pagePost ?>"><?= $pageArticle + 1 ?></a>
                            </li>
                        <?php endif ?>

                        <?php if(($pageArticle + 2) <= $numberPagesArticles): ?>
                            <li class="page-item <?php if($pageArticle == $pageArticle + 2): ?>active<?php endif ?>">
                                <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle + 2 ?>&pagePost=<?= $pagePost ?>"><?= $pageArticle + 1 ?></a>
                            </li>
                        <?php endif ?>

                    <?php endif ?>

                    <!-- The arrow appears if the current page is not the last page -->
                    <?php if(($pageArticle + 2) <= $numberPagesArticles): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=<?= $pagePost ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </nav>

            <div class="title-article-search">
                    <h5><?= $this->translation('Article(s) lié(s) à votre recherche') ?> : "<?= $search ?>"</h5>
            </div>

            <div class="row justify-content-md-center">

                <?php foreach($articles as $article): ?>
                    <div class="card article-card-search" style="max-width: 18rem;">
                        <img src="<?= $this->asset($article->get_image()) ?>" class="card-img-top" alt="Image de l'article">
                        <div class="card-body">
                            <h5 class="card-title"><?= $article->get_title_article() ?></h5>
                            <p class="card-text"><?= $this->splitText($article->get_text_article_notags(), 25) ?></p>
                        </div>
                        
                        <div class="card-footer">
                            <a href="<?= $this->router->generate('article_show', ['id' => $article->get_id()]) ?>" class="btn btn-primary">Voir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-12 col-md-6 border">

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center pagination-posts">
                        <?php if($pagePost > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=1" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif ?>

                        <?php if($numberPagesPosts <= 3): ?>
                            <li class="page-item <?php if($pagePost == 1): ?>active<?php endif ?>">
                                <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=1">1</a>
                            </li>

                            <?php if($numberPagesPosts >= 2): ?>
                                <li class="page-item <?php if($pagePost == 2): ?>active<?php endif ?>">
                                    <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=2">2</a>
                                </li>
                            <?php endif ?>

                            <?php if($numberPagesPosts >= 3): ?>
                                <li class="page-item <?php if($pagePost == 3): ?>active<?php endif ?>">
                                    <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=3">3</a>
                                </li>
                            <?php endif ?>
                        <?php else: ?>

                            <li class="page-item active">
                                <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=<?= $pagePost ?>"><?= $pagePost ?></a>
                            </li>

                            <?php if(($pagePost + 1) <= $numberPagesPosts): ?>
                                <li class="page-item <?php if($pagePost == $pagePost + 1): ?>active<?php endif ?>">
                                    <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=<?= $pagePost + 1 ?>"><?= $pagePost + 1 ?></a>
                                </li>
                            <?php endif ?>

                            <?php if(($pagePost + 2) <= $numberPagesPosts): ?>
                                <li class="page-item <?php if($pagePost == $pagePost + 2): ?>active<?php endif ?>">
                                    <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=<?= $pagePost + 2 ?>"><?= $pagePost + 2 ?></a>
                                </li>
                            <?php endif ?>

                        <?php endif ?>

                        <?php if(($pagePost + 2) <= $numberPagesPosts): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $this->router->generate('recherche') ?>?search=<?= $search ?>&pageArticle=<?= $pageArticle ?>&pagePost=<?= $numberPagesPosts ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </nav>

            <div class="title-post-search">
                    <h5><?= $this->translation('Post(s) lié(s) à votre recherche') ?> : "<?= $search ?>"</h5>
            </div>

            <div class="row justify-content-md-center">
                <?php foreach($posts as $post): ?>
                    <?php
                        $resumeText = explode(' ', strip_tags($post->get_text_post_notags()));
                        $text = join(' ', array_slice($resumeText, 0, 25)). '...';
                    ?>
                    <div class="card col-md-6 bg-light post-card-search" style="max-width: 18rem;">
                        <div class="card-header" style="width: 100%;"><?= $post->get_title_post() ?></div>
                        <div class="card-body">
                            <p class="card-text"><?= $text ?></p>
                        </div>

                        <div class="card-footer">
                            <a href="<?= $this->router->generate('post_show', ['id' => $post->get_id()]) ?>" class="btn btn-primary">Voir</a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>

</main>

<?php require '../View/footer.php' ?>