<?php

class CommentController
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
}