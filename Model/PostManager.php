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
        return $this->_bdd->query('SELECT * FROM post', PDO::FETCH_CLASS, 'Post')->fetchAll();
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
            comment.text_comment,
            comment.date_comment,
            comment.id_member_FK as comIdMemberFK,
            comment.id_parent,
            comMember.id as comMemberId,
            comMember.username as comMemberUsername,
            member.*,
            post.*
            FROM post
            INNER JOIN (comment, member, member as comMember)
            ON (post.id = comment.id_post_FK AND comment.id_member_FK = member.id AND comment.id_member_FK = comMember.id)
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
                    $arrayComments[] = $result;
                }
                else
                {
                    $arrayResponses[] = $result;
                }
            }
            
            foreach($arrayComments as $comment)
            {
                $responses = [];

                foreach($arrayResponses as $response)
                {
                    if($response['id_parent'] === $comment['comId'])
                    {
                        $member = new Member();
                        $member
                            ->set_id($response['comMemberId'])
                            ->set_username($response['comMemberUsername']);
                        
                        $finalResponse = new Comment();
                        $finalResponse
                            ->set_id($response['comId'])
                            ->set_text_comment($response['text_comment'])
                            ->set_date_comment($response['date_comment'])
                            ->set_member($member)
                            ->set_id_member_FK($response['comIdMemberFK']);

                        $responses[] = $finalResponse;
                    }
                }

                $member = new Member();
                $member
                    ->set_id($comment['comMemberId'])
                    ->set_username($comment['comMemberUsername']);
                
                $finalComment = new Comment();
                $finalComment
                    ->set_id($comment['comId'])
                    ->set_text_comment($comment['text_comment'])
                    ->set_date_comment($comment['date_comment'])
                    ->set_member($member)
                    ->set_responses($responses)
                    ->set_id_member_FK($comment['comIdMemberFK']);

                $comments[] = $finalComment;
            }

            $firstResult = $results[0];
            $member = new Member();
            $member
                ->set_id($firstResult['id_member_FK'])
                ->set_username($firstResult['username']);
                
            $post = new Post();
            $post
                ->set_id($firstResult['id'])
                ->set_title_post($firstResult['title_post'])
                ->set_text_post($firstResult['text_post'])
                ->set_text_post_notags(strip_tags($firstResult['text_post']))
                ->set_date_post($firstResult['date_post'])
                ->set_categorie($firstResult['categorie'])
                ->set_resolve($firstResult['resolve'])
                ->set_comments($comments)
                ->set_member($member);

            return $post;
        }
        else
        {
            $request = $this->_bdd->prepare('SELECT *, post.id FROM post INNER JOIN member ON member.id = post.id_member_FK WHERE post.id = :id');
            $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $request->execute();
            $result = $request->fetch(PDO::FETCH_ASSOC);

            $member = new Member();
            $member
                ->set_id($result['id_member_FK'])
                ->set_username($result['username']);

            $post = new Post();
            $post
                ->set_id($result['id'])
                ->set_title_post($result['title_post'])
                ->set_text_post($result['text_post'])
                ->set_text_post_notags(strip_tags($result['text_post']))
                ->set_date_post($result['date_post'])
                ->set_categorie($result['categorie'])
                ->set_resolve($result['resolve'])
                ->set_member($member)
                ->set_comments([]);

            return $post;
        }
    }

    public function edit(Post $post)
    {
        $request = $this->_bdd->prepare('UPDATE post SET title_post = :titlePost, text_post = :textPost, text_post_notags = :textPostNoT, resolve = :resolve, id_member_FK = :idMemberFK WHERE id = :id');

        if($request->execute([
            'id' => $post->get_id(),
            'titlePost' => $post->get_title_post(),
            'textPost' => $post->get_text_post(),
            'textPostNoT' => strip_tags($post->get_text_post()),
            'resolve' => $post->get_resolve(),
            'idMemberFK' => $post->get_member()->get_id()
            ]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function findByCategorie($categorie)
    {
        $request = $this->_bdd->prepare('SELECT * FROM post WHERE categorie = :categorie');
        $request->bindValue(':categorie', $categorie);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, 'Post');
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