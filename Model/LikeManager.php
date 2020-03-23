<?php

class LikeManager extends Manager
{
    public function add($member, $article)
    {
        $request = $this->_bdd->prepare('INSERT INTO likes(id_member_FK, id_article_FK) VALUES (:idMemberFK, :idArtFK)');

        if($request->execute([
            'idMemberFK' => $member->get_id(),
            'idArtFK' => $article->get_id()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // We verify if the member liked the article
    public function verifLike($member, $article)
    {
        $request = $this->_bdd->prepare('SELECT * FROM likes WHERE id_member_FK = :idMemberFK AND id_article_FK = :idArticleFK');
        if($request->execute(['idMemberFK' => $member->get_id(), 'idArticleFK' => $article->get_id()]))
        {
            if($request->rowCount() == 0)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    public function numberLike($article)
    {
        $request = $this->_bdd->prepare('SELECT * FROM likes WHERE id_article_FK = :idArticleFK');
        if($request->execute(['idArticleFK' => $article->get_id()]))
        {
            return $request->rowCount();
        }
        else
        {
            return false;
        }
    }

    public function removeLike($member, $article)
    {
        $request = $this->_bdd->prepare('DELETE FROM likes WHERE id_member_FK = :idMemberFK AND id_article_FK = :idArticleFK');
        if($request->execute(['idMemberFK' => $member->get_id(), 'idArticleFK' => $article->get_id()]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}