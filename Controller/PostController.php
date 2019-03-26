<?php

class PostController extends Controller
{
    public function show($params)
    {
        extract($params);
        $postManager = new PostManager();
        $postF = $postManager->get($id);
        $titlePage = $postF->get_title_post();
        $errors = [];

        if($this->member != null)
        {
            if(!empty($_POST))
            {
                $post = array_map('trim', array_map('strip_tags', $_POST));

                if(isset($post['form']) && !empty($post['form']))
                {
                    if($post['form'] == 'form-comment')
                    {
                        $comment = new Comment();
                        $commentManager = new CommentManager();
                        $comment
                            ->set_text_comment($post['text_comment'])
                            ->set_id_member_FK($this->member->get_id())
                            ->set_id_post_FK($postF->get_id());

                        $commentManager->addCommentPost($comment);
                    }

                    if($post['form'] == 'form-response')
                    {
                        $comment = new Comment();
                        $commentManager = new CommentManager();
                        $comment
                            ->set_text_comment($post['text_comment'])
                            ->set_id_member_FK($this->member->get_id())
                            ->set_id_post_FK($postF->get_id())
                            ->set_id_parent($post['id_comment']);

                        $commentManager->addResponsePost($comment);
                    }
                }
            }
        }
        $postF = $postManager->get($id);

        ob_start();
        require '../View/forum/show.php';
        echo ob_get_clean();
    }

    public function list()
    {
        $titlePage = 'Tous les posts de notre forum';
        $postManager = new PostManager();
        $posts = $postManager->list();

        ob_start();
        require '../View/forum/list.php';
        echo ob_get_clean();
    }
}