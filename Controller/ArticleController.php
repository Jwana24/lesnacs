<?php

class ArticleController extends Controller
{
    public function show($params)
    {
        extract($params);
        $articleManager = new ArticleManager();
        $article = $articleManager->get($id);
        $titlePage = $article->get_title_article();

        $errors = [];
        $likeManager = new LikeManager();
        $nbLike = $likeManager->numberLike($article);
        $like = false;

        if($this->member != null)
        {
            $like = $likeManager->verifLike($this->member, $article);

            if(!empty($_POST))
            {
                $post = array_map('trim', array_map('strip_tags', $_POST));

                if(isset($post['ajax-like']) && $post['ajax-like'] == 'true')
                {
                    if($like)
                    {
                        $likeManager->removeLike($this->member, $article);
                        $nbLike = $likeManager->numberLike($article);
                        echo json_encode(['content' => false, 'nbLike' => $nbLike]);
                        return null;
                    }
                    else
                    {
                        $likeManager->add($this->member, $article);
                        $nbLike = $likeManager->numberLike($article);
                        echo json_encode(['content' => true, 'nbLike' => $nbLike]);
                        return null;
                    }
                }

                if(isset($post['form']) && !empty($post['form']))
                {
                    if($post['form'] == 'form-comment')
                    {
                        $comment = new Comment();
                        $commentManager = new CommentManager();
                        $comment
                            ->set_text_comment($post['text_comment'])
                            ->set_id_member_FK($this->member->get_id())
                            ->set_id_article_FK($article->get_id());

                        $commentManager->addCommentArt($comment);
                    }
                }
            }
        }
        $article = $articleManager->get($id);

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