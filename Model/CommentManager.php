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

    public function getComment($id)
    {
        $request = $this->_bdd->prepare('SELECT *, comment.id FROM comment INNER JOIN member ON member.id = comment.id_member_FK WHERE comment.id');
        $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, 'Comment')[0];
    }

    public function getByIdParent($id)
    {
        $request = $this->_bdd->prepare('SELECT * FROM comment INNER JOIN member ON membres.id = comment.id_member_FK WHERE comment.id_parent = :id');
        $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS);
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