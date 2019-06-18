<?php

class SearchController extends Controller
{
    public function search($params)
    {
        extract($params);
        $articleManager = new ArticleManager();
        $postManager = new PostManager();
        
        if(!empty($_GET['search']))
        {
            $search = trim(strip_tags($_GET['search']));

            $articles = $articleManager->searchArticle($search);
            $posts = $postManager->searchPost($search);
        }
    }
}