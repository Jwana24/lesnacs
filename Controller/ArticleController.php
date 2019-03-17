<?php

class ArticleController extends Controller
{
    public function show()
    {
        $articleManager = new ArticleManager();
        $article = new Article();
        $id = $article->get_id();
        $titlePage = $article->get_title_article();
        $articles = $articleManager->show($id);
        
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