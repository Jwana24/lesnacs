<?php

class CommentManager extends Manager
{
    public function add(Comment $comment)
    {
        $request = $this->_bdd->prepare('INSERT INTO comment(text_comment, date_inscription, id_member_FK, id_article_FK, id_post_FK, id_parent) VALUES (:title_comment, :text_comment, NOW(), :idMemberFK, :idArticleFK, :idPostFK, :idParent)');

        if($request->execute([
            'text_comment' => $comment->get_text_comment(),
            'idMemberFK' => $comment->get_id_member_FK(),
            'idArticleFK' => $comment->get_id_article_FK(),
            'idPostFK' => $comment->get_id_post_FK(),
            'idParent' => $comment->get_id_parent()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function show($id)
    {
        $request = $this->_bdd->prepare('SELECT * FROM comment INNER JOIN member ON member.id = comment.id_member_FK WHERE comment.id_article_FK = :id');
        $request->bindParam(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS);
    }

    public function getByIdParent($id)
    {
        $request = $this->_bdd->prepare('SELECT * FROM comment INNER JOIN member ON membres.id = comment.id_member_FK WHERE comment.id_parent = :id');
        $request->bindParam(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS);
    }

    public function edit(Comment $comment)
    {
        $request = $this->_bdd->prepare('UPDATE comment SET text_comment = :textComment, id_member_FK = :idMemberFK, id_article_FK = :idArtFK, id_post_FK = :idPostFK, id_parent = :idParent WHERE id = :id');

        if($request->execute([
            'id' => $comment->get_id(),
            'text_comment' => $comment->get_text_comment(),
            'idMemberFK' => $comment->get_id_member_FK(),
            'idArtFK' => $comment->get_id_article_FK(),
            'idPostFK' => $comment->get_post_FK(),
            'idParent' => $comment->get_id_parent()
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
        $request = $this->_bdd->prepare('DELETE FROM comment WHERE id = :id');
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