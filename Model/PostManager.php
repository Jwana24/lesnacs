<?php

class PostManager extends Manager
{
    public function add(Post $post)
    {
        $request = $this->_bdd->prepare('INSERT INTO post(title_post, text_post, date_post, categorie, resolve, id_member_FK) VALUES (:title_post, :text_post, NOW(), :categorie, :resolve, :idMemberFK)');

        if($request->execute([
            'title_post' => $post->get_title_post(),
            'text_post' => $post->get_text_post(),
            'categorie' => $post->get_categorie(),
            'resolve' => $post->get_resolve(),
            'idMemberFk' => $post->get_id_member_FK()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function list()
    {
        $request = $this->_bdd->prepare('SELECT *, DATE_FORMAT(date_post, \'%d/%m/%Y\') AS datePost FROM post INNER JOIN member ON membres.id = post.id_member_FK');
        if($request->execute())
        {
            $results = $request->fetchAll(\PDO::FETCH_ASSOC);
            $tablePost = [];
            foreach($results as $value)
            {
                $post = new post();
                $post->set_id($value['id']);
                $post->set_title_post($value['titlePost']);
                $post->set_text_post($value['textPost']);
                $post->set_date_post($value['datePost']);
                $post->set_categorie($value['categorie']);
                $post->set_resolve($value['resolve']);

                $tablePosts[] = $post;
            }
            return $tablePosts;
        }
        else
        {
            return false;
        }
    }

    public function show($id)
    {
        $request = $this->_bdd->prepare('SELECT *, DATE_FORMAT(date_post, \'%d/%m/%Y\') AS datePost FROM post INNER JOIN member ON member.id = post.id_member_FK WHERE post.id = :id');
        if($request->execute(['id' => $id]) && $request->rowCount() == 1)
        {
            $results = $request->fetch(\PDO::FETCH_ASSOC);
            $post = new post();
            $post->set_id($results['id']);
            $post->set_title_post($results['titlePost']);
            $post->set_text_post($results['textPost']);
            $post->set_date_post($results['datePost']);
            $post->set_categorie($results['categorie']);
            $post->set_resolve($results['resolve']);

            return $post;
        }
        else
        {
            return false;
        }
    }

    public function edit(Post $post)
    {
        $request = $this->_bdd->prepare('UPDATE post SET title_post = :titlePost, text_post = :textPost, categorie = :categorie, resolve = :resolve, id_member_FK = :idMemberFK WHERE id = :id');

        if($request->execute([
            'id' => $post->get_id(),
            'title_post' => $post->get_title_post(),
            'text_post' => $post->get_text_post(),
            'categorie' => $post->get_categorie(),
            'resolve' => $post->get_resolve(),
            'idMemberFK' => $post->get_id_member_FK()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete($id)
    {
        $request = $this->_bdd->prepare('DELETE FROM post WHERE id = :id');
        if($request->execute(['id' => $id]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}