<?php

class ArticleManager extends Manager
{
    public function add(Article $article)
    {
        $request = $this->_bdd->prepare('INSERT INTO article (title_article, text_article, text_article_notags, date_article, image) VALUES (:title_article, :text_article, :text_article_notags, NOW(), :image)');

        if($request->execute([
            'title_article' => $article->get_title_article(),
            'text_article' => $article->get_text_article(),
            'text_article_notags' => strip_tags($article->get_text_article()),
            'image' => $article->get_image()
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
        return $this->_bdd->query('SELECT * FROM article', PDO::FETCH_CLASS, 'Article')->fetchAll();
    }

    public function showLast()
    {
        return $this->_bdd->query('SELECT * FROM article ORDER BY date_article DESC LIMIT 0,4', PDO::FETCH_CLASS, 'Article')->fetchAll();
    }

    public function get($id)
    {
        $request = $this->_bdd->prepare('SELECT * FROM comment WHERE id_article_FK = :id');
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
            member.*,
            article.*
            FROM article
            INNER JOIN (comment, member)
            ON (article.id = comment.id_article_FK AND comment.id_member_FK = member.id)
            WHERE article.id = :id');

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
                            ->set_member($member)
                            ->set_id_member_FK($response['comIdMemberFK']);

                        $responses[] = $finalResponse;
                    }
                }

                $member = new Member();
                $member
                    ->set_id($comment['comIdMemberFK'])
                    ->set_username($comment['username'])
                    ->set_avatar($comment['avatar'])
                    ->set_date_inscription($comment['date_inscription'])
                    ->set_roles($comment['roles']);
                
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
            $article = new Article();
            $article
                ->set_id($firstResult['id'])
                ->set_title_article($firstResult['title_article'])
                ->set_text_article($firstResult['text_article'])
                ->set_text_article_notags(strip_tags($firstResult['text_article']))
                ->set_date_article($firstResult['date_article'])
                ->set_image($firstResult['image'])
                ->set_comments($comments);

            return $article;
        }
        else
        {
            $request = $this->_bdd->prepare('SELECT * FROM article WHERE id = :id');
            $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $request->execute();
            $article = $request->fetchAll(PDO::FETCH_CLASS, 'Article')[0];
            $article->set_comments([]);
            return $article;
        }
    }

    public function edit(Article $article)
    {
        $request = $this->_bdd->prepare('UPDATE article SET title_article = :titleArt, text_article = :textArt, text_article_notags = :textArtNoT, image = :image WHERE id = :id');

        if($request->execute([
            'id' => $article->get_id(),
            'titleArt' => $article->get_title_article(),
            'textArt' => $article->get_text_article(),
            'textArtNoT' => strip_tags($article->get_text_article()),
            'image' => $article->get_image()
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
        $request = $this->_bdd->prepare('DELETE FROM article WHERE id = :id');
        if($request->execute(['id' => $id]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function searchArticle($search)
    {
        $request = $this->_bdd->prepare('SELECT * FROM article WHERE title_article
        LIKE "%'.$search.'%"
        OR text_article_notags LIKE "%'.$search.'%"');
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, 'Article');
    }
}