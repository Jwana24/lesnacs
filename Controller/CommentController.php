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
        $commentManager = new CommentManager();
        $comment = $commentManager->getComment($id);
        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['text_comment']) || empty($post['text_comment']))
            {
                $errors[] = 'Erreur sur le contenu';
            }
            if(count($errors) == 0)
            {
                $comment
                    ->set_text_comment($post['text_comment']);
            
                if($commentManager->edit($comment))
                {
                    echo json_encode(['statut' => 'success', 'content' => [
                        'text_comment' => $comment->get_text_comment()
                    ]]);
                }
                else
                {
                    $errors[] = 'Votre commentaire n\'a pas pu être édité';
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
                    $this->addMessages('Le commentaire a été supprimé', 'success');
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