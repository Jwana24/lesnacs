<?php

class SearchController extends Controller
{
    public function search($params)
    {
        extract($params);
        $articleManager = new ArticleManager();
        $postManager = new PostManager();
        
        if(!empty($_GET['search']) && !empty($_GET['pageArticle']) && !empty($_GET['pagePost']))
        {   
            $pageArticle = $_GET['pageArticle'];
            $pagePost = $_GET['pagePost'];

            if($pageArticle <= 1)
            {
                $numberArticle = 0;
            }
            else
            {
                $numberArticle = ($pageArticle - 1) * 8;
            }

            if($pagePost <= 1)
            {
                $numberPost = 0;
            }
            else
            {
                $numberArticle = ($pagePost - 1) * 8;
            }

            $search = trim(strip_tags($_GET['search']));

            $articles = $articleManager->searchArticle($search, $numberArticle);
            $posts = $postManager->searchPost($search, $numberPost);

            $numberPagesArticles = ceil(count($articleManager->searchArticle($search, 0, 0)) / 8);
            $numberPagesPosts = ceil(count($postManager->searchPost($search, 0, 0)) / 8);
        }

        ob_start();
        require '../View/general/search.php';
        echo ob_get_clean();
    }
}