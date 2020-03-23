<?php

class CommentManager extends Manager
{
    public function addCommentArt(Comment $comment)
    {
        $request = $this->_bdd->prepare('INSERT INTO comment(text_comment, date_comment, id_member_FK, id_article_FK, id_post_FK, id_parent) VALUES (:textCom, NOW(), :idMemberFK, :idArticleFK, NULL, NULL)');

        if($request->execute([
            'textCom' => $comment->get_text_comment(),
            'idMemberFK' => $comment->get_id_member_FK(),
            'idArticleFK' => $comment->get_id_article_FK()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function addCommentPost(Comment $comment)
    {
        $request = $this->_bdd->prepare('INSERT INTO comment(text_comment, date_comment, id_member_FK, id_article_FK, id_post_FK, id_parent) VALUES (:textCom, NOW(), :idMemberFK, NULL, :idPostFK, NULL)');

        if($request->execute([
            'textCom' => $comment->get_text_comment(),
            'idMemberFK' => $comment->get_id_member_FK(),
            'idPostFK' => $comment->get_id_post_FK()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function addResponseArt(Comment $comment)
    {
        $request = $this->_bdd->prepare('INSERT INTO comment(text_comment, date_comment, id_member_FK, id_article_FK, id_post_FK, id_parent) VALUES (:textCom, NOW(), :idMemberFK, :idArticleFK, NULL, :idParent)');

        if($request->execute([
            'textCom' => $comment->get_text_comment(),
            'idMemberFK' => $comment->get_id_member_FK(),
            'idArticleFK' => $comment->get_id_article_FK(),
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

    public function addResponsePost(Comment $comment)
    {
        $request = $this->_bdd->prepare('INSERT INTO comment(text_comment, date_comment, id_member_FK, id_article_FK, id_post_FK, id_parent) VALUES (:textCom, NOW(), :idMemberFK, NULL, :idPostFK, :idParent)');

        if($request->execute([
            'textCom' => $comment->get_text_comment(),
            'idMemberFK' => $comment->get_id_member_FK(),
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

    public function getComment($id)
    {
        $request = $this->_bdd->prepare('SELECT *, comment.id FROM comment INNER JOIN member ON member.id = comment.id_member_FK WHERE comment.id = :id');
        $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, 'Comment')[0];
    }

    public function edit(Comment $comment)
    {
        $request = $this->_bdd->prepare('UPDATE comment SET text_comment = :textComment WHERE comment.id = :id');
        if($request->execute([
            'id' => $comment->get_id(),
            'textComment' => $comment->get_text_comment()
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