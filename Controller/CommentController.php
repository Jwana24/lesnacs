<?php

class CommentController extends Controller
{
    public function show()
    {
        $commentManager = new CommentManager();
        $comment = new Comment();
        $id = $comment->get_id();
        $comments = $commentManager->show($id);
        
        ob_start();
        require '../View/article/show.php';
        echo ob_get_clean();
    }

    public function edit($params)
    {
        extract($params);
    }

    public function delete()
    {
        $commentManager = new CommentManager();
        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['token_session']) || $post['token_session'] != $this->member->get_token_session())
            {
                $errors[] = 'Une erreur s\'est produite';
            }
            // We verify the id of the comment
            if(!isset($post['id']) || !is_numeric($post['id']))
            {
                $errors[] = 'Une erreur s\'est produite';
            }
            // We verify the id of the article
            if(!isset($post['idArt']) || !is_numeric($post['idArt']))
            {
                $errors[] = 'Une erreur s\'est produite';
            }

            if(count($errors) == 0)
            {
                if($commentManager->delete($post['id']))
                {
                    $this->addMessages('L\'article a été supprimé', 'success');
                }
                else
                {
                    $this->addMessages('Erreur lors de la suppression du commentaire', 'error');
                }
            }
            else
            {
                $this->addMessages('Une erreur s\'est produite', 'error');
            }
        }
        header('Location: http://localhost/article/'.$post['idArt'].'/');
    }
}