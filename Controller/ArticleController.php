<?php

class ArticleController extends Controller
{
    public function get($params)
    {
        extract($params);
        $articleManager = new ArticleManager();
        $article = $articleManager->get($id);
        $titlePage = $article->get_title_article();

        ob_start();
        require '../View/article/show.php';
        echo ob_get_clean();
    }

    public function list()
    {
        $titlePage = 'Tous nos articles';
        $articleManager = new ArticleManager();
        $articles = $articleManager->list();

        ob_start();
        require '../View/article/list.php';
        echo ob_get_clean();
    }
}