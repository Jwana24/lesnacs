<?php

class ArticleManager extends Manager
{
    public function add(Article $article)
    {
        $request = $this->_bdd->prepare('INSERT INTO article(title_article, text_article, date_inscription, image, id_member_FK) VALUES (:title_article, :text_article, NOW(), :image, :idMemberFK)');

        if($request->execute([
            'title_article' => $article->get_title_article(),
            'text_article' => $article->get_text_article(),
            'image' => $article->get_image(),
            'idMemberFK' => $article->get_id_member_FK()
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
        return $this->_bdd->query('SELECT * FROM article INNER JOIN member ON member.id = article.id_member_FK', PDO::FETCH_CLASS, 'Article').fetchAll();
    }

    public function showLast()
    {
        return $this->_bdd->query('SELECT * FROM article INNER JOIN member ON member.id = article.id_member_FK ORDER BY date_article DESC LIMIT 0,4', PDO::FETCH_CLASS, 'Article')->fetchAll();
    }

    public function show($id)
    {
        $request = $this->_bdd->prepare('SELECT *, DATE_FORMAT(date_inscription, \'%d/%m/%Y\') AS dateInsc FROM article INNER JOIN member ON member.id = article.id_member_FK WHERE article.id = :id');
        if($request->execute(['id' => $id]) && $request->rowCount() == 1)
        {
            $results = $request->fetch(\PDO::FETCH_ASSOC);
            $article = new article();
            $article->set_id($results['id']);
            $article->set_title_article($results['titleArt']);
            $article->set_text_article($results['textArt']);
            $article->set_date_inscription($results['dateInsc']);
            $article->set_image($results['image']);

            return $article;
        }
        else
        {
            return false;
        }
    }

    public function edit(Article $article)
    {
        $request = $this->_bdd->prepare('UPDATE article SET title_article = :titleArt, text_article = :textArt, image = :image, id_member_FK = :idMember WHERE id = :id');

        if($request->execute([
            'id' => $article->get_id(),
            'title_article' => $article->get_title_article(),
            'text_article' => $article->get_text_article(),
            'date_inscription' => $article->get_date_inscription(),
            'image' => $article->get_image(),
            'idMember' => $article->get_id_member_FK()
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
}