<?php

class Article
{
    private $id;
    private $title_article;
    private $text_article;
    private $text_article_notags;
    private $date_article;
    private $image;
    private $comments;


    /**
     * Get the value of _id
     */ 
    public function get_id()
    {
        return $this->id;
    }

    /**
     * Set the value of _id
     *
     * @return  self
     */ 
    public function set_id($_id)
    {
        $this->id = $_id;

        return $this;
    }

    /**
     * Get the value of _title_article
     */ 
    public function get_title_article()
    {
        return $this->title_article;
    }

    /**
     * Set the value of _title_article
     *
     * @return  self
     */ 
    public function set_title_article($_title_article)
    {
        $this->title_article = $_title_article;

        return $this;
    }

    /**
     * Get the value of _text_article
     */ 
    public function get_text_article()
    {
        return $this->text_article;
    }

    /**
     * Set the value of _text_article
     *
     * @return  self
     */ 
    public function set_text_article($_text_article)
    {
        $this->text_article = $_text_article;

        return $this;
    }

    /**
     * Get the value of _date_article
     */ 
    public function get_date_article()
    {
        return $this->date_article;
    }

    /**
     * Set the value of _date_article
     *
     * @return  self
     */ 
    public function set_date_article($_date_article)
    {
        $this->date_article = $_date_article;

        return $this;
    }

    /**
     * Get the value of _image
     */ 
    public function get_image()
    {
        return $this->image;
    }

    /**
     * Set the value of _image
     *
     * @return  self
     */ 
    public function set_image($_image)
    {
        $this->image = $_image;

        return $this;
    }

    /**
     * Get the value of comment
     */ 
    public function get_comments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */ 
    public function set_comments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get the value of text_article_notags
     */ 
    public function get_text_article_notags()
    {
        return $this->text_article_notags;
    }

    /**
     * Set the value of text_article_notags
     *
     * @return  self
     */ 
    public function set_text_article_notags($text_article_notags)
    {
        $this->text_article_notags = $text_article_notags;

        return $this;
    }
}