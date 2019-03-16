<?php

class LikeManager extends Manager
{
    public function add(Like $like)
    {
        $request = $this->_bdd->prepare('INSERT INTO likes(id_member_FK, id_article_FK) VALUES (:idMemberFK, :idArtFK)');

        if($request->execute([
            'idMemberFK' => $like->get_id_member_FK(),
            'idArtFK' => $like->get_id_article_FK()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function list($id)
    {
        $request = $this->_bdd->prepare('SELECT * FROM likes INNER JOIN member ON member.id = likes.id_member_FK WHERE likes.id_article_FK = :id');
        if($request->execute())
        {
            $results = $request->fetchAll(\PDO::FETCH_ASSOC);
            $tableLikes = [];
            foreach($results as $value)
            {
                $like = new like();
                $like->set_id($value['id']);

                $tableLikes[] = $like;
            }
            return $tableLikes;
        }
        else
        {
            return false;
        }
    }

    public function show($id)
    {
        $request = $this->_bdd->prepare('SELECT * FROM likes INNER JOIN member ON member.id = likes.id_member_FK WHERE likes.id = :id');
        if($request->execute(['id' => $id]) && $request->rowCount() == 1)
        {
            $results = $request->fetch(\PDO::FETCH_ASSOC);
            $like = new like();
            $like->set_id($results['id']);

            return $like;
        }
        else
        {
            return false;
        }
    }

    public function edit(Like $like)
    {
        $request = $this->_bdd->prepare('UPDATE likes SET id_member_FK = :idMember, id_article_FK = :idArtFK WHERE id = :id');

        if($request->execute([
            'id' => $like->get_id(),
            'idMember' => $like->get_id_member_FK(),
            'idArtFK' => $like->get_id_article_FK()
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
        $request = $this->_bdd->prepare('DELETE FROM likes WHERE id = :id');
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