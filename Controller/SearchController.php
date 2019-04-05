<?php

class SearchController extends Controller
{
    public function search($params)
    {
        extract($params);
        $articleManager = new ArticleManager();
        $articleManager->searchArticle();
        
        $postManager = new PostManager();
        $postManager->searchPost();

    }
}