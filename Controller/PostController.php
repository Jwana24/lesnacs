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

    public function edit($params)
    {
        extract($params);
        header('Content-Type: application/json');
        $postManager = new PostManager();
        $postF = $postManager->get($id);
        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['title_post']) || empty($post['title_post']))
            {
                $errors[] = 'Erreur sur le titre';
            }

            if(!isset($post['text_post']) || empty($post['text_post']))
            {
                $errors[] = 'Erreur sur le contenu';
            }

            if(count($errors) == 0)
            {
                $postF
                    ->set_title_post($post['title_post'])
                    ->set_text_post($_POST['text_post']);
           
                if($postManager->edit($postF))
                {
                    echo json_encode(['statut' => 'success', 'content' => [
                        'title_post' => $postF->get_title_post(),
                        'text_post' => $postF->get_text_post()
                    ]]);
                }
                else
                {
                    $errors[] = 'Le post n\'a pas pu être édité';
                    echo json_encode(['statut' => 'error', 'error' => $errors]);
                }
            }
            else
            {
                echo json_encode(['statut' => 'error', 'error' => $errors]);
            }
        }
    }

    public function delete()
    {
        $postManager = new PostManager();
        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['token_session']) || $post['token_session'] != $this->member->get_token_session())
            {
                $errors[] = 'Une erreur s\'est produite';
            }

            if(!isset($post['id']) || !is_numeric($post['id']))
            {
                $errors[] = 'Une erreur s\'est produite';
            }

            if(count($errors) == 0)
            {
                if($postManager->delete($post['id']))
                {
                    $this->addMessages('Le post a été supprimé', 'success');
                }
                else
                {
                    $this->addMessages('Erreur lors de la suppression du post', 'error');
                }
            }
            else
            {
                $this->addMessages('Une erreur s\'est produite', 'error');
            }
        }
        header('Location: http://localhost/forum/');
    }
}