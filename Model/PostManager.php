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
        return $this->_bdd->query('SELECT * FROM post INNER JOIN member ON member.id = post.id_member_FK', PDO::FETCH_CLASS, 'Post')->fetchAll();
    }

    public function get($id)
    {
        $request = $this->_bdd->prepare('SELECT * FROM comment WHERE id_post_FK = :id');
        $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();

        if($request->rowCount() > 0)
        {
            $request = $this->_bdd->prepare('SELECT
            comment.id as comId,
            comment.id_member_FK as comIdMemberFK,
            member.*,
            post.*
            FROM post
            INNER JOIN (comment, member)
            ON (post.id = comment.idPostFK AND comment.idMemberFK = member.id)
            WHERE post.id = :id');

            $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $request->execute();
            $results = $request->fetchAll(PDO::FETCH_ASSOC);

            $comments = [];

            $arrayComments = [];
            $arrayResponses = [];

            foreach($results as $result)
            {
                if($result['id_parent'] === NULL)
                {
                    $arrayComments = $result;
                }
                else
                {
                    $arrayResponses = $result;
                }
            }

            foreach($arrayComments as $comment)
            {
                $responses = [];

                foreach($arrayResponses as $response)
                {
                    if($responses['id_parent'] === $comment['comId'])
                    {
                        $member = new Member();
                        $member
                            ->set_id($response['comIdMemberFK'])
                            ->set_username($response['username'])
                            ->set_avatar($response['avatar'])
                            ->set_date_inscription($response['date_inscription'])
                            ->set_roles($response['roles']);
                        
                        $finalResponse = new Comment();
                        $finalResponse
                            ->set_id($response['comId'])
                            ->set_text_comment($response['text_comment'])
                            ->set_date_comment($response['date_comment'])
                            ->set_member($member);

                        $responses[] = $finalResponse;
                    }
                }

                $member = new Member();
                $member
                    ->set_id($response['comIdMemberFK'])
                    ->set_username($response['username'])
                    ->set_avatar($response['avatar'])
                    ->set_date_inscription($response['date_inscription'])
                    ->set_roles($response['roles']);
                
                $finalComment = new Comment();
                $finalComment
                    ->set_id($comment['comId'])
                    ->set_text_comment($comment['text_comment'])
                    ->set_date_comment($comment['date_comment'])
                    ->set_member($member)
                    ->set_responses($responses);

                $comments[] = $finalComment;
            }

            $firstResult = $results[0];
            $post = new Post();
            $post
                ->set_id($firstResult['id'])
                ->set_title_post($firstResult['title_post'])
                ->set_text_post($firstResult['text_post'])
                ->set_date_post($firstResult['date_post'])
                ->set_categorie($firstResult['categorie'])
                ->set_resolve($firstResult['resolve'])
                ->set_comments($comments);

            return $post;
        }
        else
        {
            $post = $this->_bdd->query('SELECT *, post.id FROM post INNER JOIN member ON member.id = post.id_member_FK', PDO::FETCH_CLASS, 'Post')->fetchAll()[0];
            $post->set_comments([]);
            return $post;
        }
    }

    public function edit(Post $post)
    {
        $request = $this->_bdd->prepare('UPDATE post SET title_post = :titleArt, text_post = :textArt, image = :image, id_member_FK = :idMember WHERE id = :id');

        if($request->execute([
            'id' => $post->get_id(),
            'title_post' => $post->get_title_post(),
            'text_post' => $post->get_text_post(),
            'date_inscription' => $post->get_date_inscription(),
            'image' => $post->get_image(),
            'idMember' => $post->get_id_member_FK()
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