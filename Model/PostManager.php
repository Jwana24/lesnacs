<?php

class PostManager extends Manager
{
    public function add(Post $post)
    {
        $request = $this->_bdd->prepare('INSERT INTO post (title_post, text_post, text_post_notags, date_post, categorie, id_member_FK) VALUES (:titlePost, :textPost, :textPostNoT, NOW(), :categorie, :idMemberFK)');

        if($request->execute([
            'titlePost' => $post->get_title_post(),
            'textPost' => $post->get_text_post(),
            'textPostNoT' => $post->get_text_post_notags(),
            'categorie' => $post->get_categorie(),
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

    public function list()
    {
        return $this->_bdd->query('SELECT * FROM post', PDO::FETCH_CLASS, 'Post')->fetchAll();
    }

    public function get($id)
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
        LEFT JOIN member
        ON post.id_member_FK = member.id
        LEFT JOIN (comment, member as comMember)
        ON post.id = comment.id_post_FK AND comment.id_member_FK = comMember.id
        WHERE post.id = :id');

        $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
        
        if(!$request->execute())
        {
            return false;
        }
        
        $results = $request->fetchAll(PDO::FETCH_ASSOC);

        if(empty($results))
        {
            return false;
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
            ->set_comments([])
            ->set_member($member);

        if($firstResult['comId'] !== NULL)
        {
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
            $post->set_comments($comments);
        }

            return $post;
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

    public function setNullById($id)
    {
        $request = $this->_bdd->prepare('UPDATE post SET id_member_FK = NULL WHERE id_member_FK = :id');

        if($request->execute([
            'id' => $id
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

    public function searchPost($search, int $offset, int $limit = 8)
    {
        $offsetLimit = ($offset == 0 && $limit == 0) ? '' : 'LIMIT '.$offset.', '.$limit;
        $request = $this->_bdd->prepare('SELECT * FROM post WHERE title_post
        LIKE "%'.$search.'%"
        OR text_post_notags LIKE "%'.$search.'%" '.$offsetLimit);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, 'Post');
    }
}