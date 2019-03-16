<?php

class ArticleController
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
}