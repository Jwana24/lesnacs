<?php

class AdminArticleController extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);

        if(!$this->is_granted([]))
        {
            header('Location:http://lesnacs.fr/accueil/');
        }
    }

    public function add()
    {
        $titlePage = $this->translation('Ajouter un article');
        $articleManager = new ArticleManager();

        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!empty($_FILES))
            {
                if(!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK || $_FILES['image']['size'] > 500000)
                {
                    $errors[] = 'L\'image n\'a pas pu être téléchargée '.$_FILES['image']['error'];
                }

                if(count($errors) == 0)
                {
                    $fileExtension = explode('.', $_FILES['image']['name'])[1];

                    if(in_array($fileExtension ,['jpg', 'jpeg', 'svg', 'png']))
                    {
                        $fileName = 'images/'. time(). '.'. $fileExtension;

                        if(move_uploaded_file($_FILES['image']['tmp_name'], $fileName))
                        {
                            $image = $fileName;
                        }
                    }
                    else
                    {
                        $errors[] = 'Le fichier doit être en \'jpg\', \'jpeg\', \'svg\', ou \'png\'';
                    }
                }
            }

            if(!isset($post['title_article']) || empty($post['title_article']))
            {
                $errors[] = 'Erreur sur le titre';
            }

            if(!isset($post['text_article']) || empty($post['text_article']))
            {
                $errors[] = 'Erreur sur le contenu';
            }

            if(count($errors) == 0)
            {
                $article = new Article();
                $article
                    ->set_title_article($post['title_article'])
                    ->set_text_article($_POST['text_article'])
                    ->set_text_article_notags($post['text_article'])
                    ->set_image($image);
                
                $articleManager->add($article);
            }
            else
            {
                $errors[] = 'L\'article n\'a pas pu être créé';
            }
            header('Location: http://lesnacs.fr/article/');
        }
        ob_start();
        require '../View/Admin/article/add.php';
        echo ob_get_clean();
    }

    public function edit($params)
    {
        extract($params);
        $articleManager = new ArticleManager();
        $article = $articleManager->get($id);
        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!empty($_FILES))
            {
                if(isset($_FILES['image']) && $_FILES['image']['name'] != '')
                {
                    if(!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK || $_FILES['image']['size'] > 500000)
                    {
                        $errors[] = 'L\'image n\'a pas pu être téléchargée '.$_FILES['image']['error'];
                    }
    
                    if(count($errors) == 0)
                    {
                        $fileExtension = explode('.', $_FILES['image']['name'])[1];
    
                        if(in_array($fileExtension ,['jpg', 'jpeg', 'svg', 'png']))
                        {
                            $fileName = 'images/'. time(). '.'. $fileExtension;
    
                            if(move_uploaded_file($_FILES['image']['tmp_name'], $fileName))
                            {
                                $image = $fileName;
                            }
                        }
                        else
                        {
                            $errors[] = 'Le fichier doit être en \'jpg\', \'jpeg\', \'svg\', ou \'png\'';
                        }
                    }
                }
            }

            if(!isset($post['title_article']) || empty($post['title_article']))
            {
                $errors[] = 'Erreur sur le titre';
            }

            if(!isset($post['text_article']) || empty($post['text_article']))
            {
                $errors[] = 'Erreur sur le contenu';
            }

            if(count($errors) == 0)
            {
                $article
                    ->set_title_article($post['title_article'])
                    ->set_text_article($_POST['text_article'])
                    ->set_image($image ?? $article->get_image());
                
                if($articleManager->edit($article))
                {
                    echo json_encode(['statut' => 'success', 'content' => [
                        'title_article' => $article->get_title_article(),
                        'text_article' => $article->get_text_article(),
                        'image' => $article->get_image()
                    ]]);
                }
                else
                {
                    $errors[] = 'L\'article n\'a pas pu être édité';
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
        $articleManager = new ArticleManager();
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
                if($articleManager->delete($post['id']))
                {
                    $this->addMessages($this->translation('L\'article a été supprimé'), 'success');
                }
                else
                {
                    $this->addMessages($this->translation('Erreur lors de la suppression de l\'article'), 'error');
                }
            }
            else
            {
                $this->addMessages($this->translation('Une erreur s\'est produite'), 'error');
            }
        }
        if(!$this->is_granted([]))
        {
            header('Location:http://lesnacs.fr/accueil/');
        }
        else
        {
            header('Location: http://lesnacs.fr/article/');
        }
    }
}