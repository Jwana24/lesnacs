<?php

class PostController extends Controller
{
    public function show($params)
    {
        extract($params);
        $postManager = new PostManager();
        $post = $postManager->get($id);
        $titlePage = $post->get_title_post();

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