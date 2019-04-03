<?php

class Post
{
    private $id;
    private $title_post;
    private $text_post;
    private $text_post_notags;
    private $date_post;
    private $categorie;
    private $resolve;
    private $id_member_FK;
    private $comments;
    private $member;


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
    public function set_id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of _title_post
     */ 
    public function get_title_post()
    {
        return $this->title_post;
    }

    /**
     * Set the value of _title_post
     *
     * @return  self
     */ 
    public function set_title_post($title_post)
    {
        $this->title_post = $title_post;

        return $this;
    }

    /**
     * Get the value of _text_post
     */ 
    public function get_text_post()
    {
        return $this->text_post;
    }

    /**
     * Set the value of _text_post
     *
     * @return  self
     */ 
    public function set_text_post($text_post)
    {
        $this->text_post = $text_post;

        return $this;
    }

    /**
     * Get the value of _date_post
     */ 
    public function get_date_post()
    {
        return $this->date_post;
    }

    /**
     * Set the value of _date_post
     *
     * @return  self
     */ 
    public function set_date_post($date_post)
    {
        $this->date_post = $date_post;

        return $this;
    }

    /**
     * Get the value of _categorie
     */ 
    public function get_categorie()
    {
        return $this->categorie;
    }

    /**
     * Set the value of _categorie
     *
     * @return  self
     */ 
    public function set_categorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get the value of _resolve
     */ 
    public function get_resolve()
    {
        return $this->resolve;
    }

    /**
     * Set the value of _resolve
     *
     * @return  self
     */ 
    public function set_resolve($resolve)
    {
        $this->resolve = $resolve;

        return $this;
    }

    /**
     * Get the value of _id_member_FK
     */ 
    public function get_id_member_FK()
    {
        return $this->id_member_FK;
    }

    /**
     * Set the value of _id_member_FK
     *
     * @return  self
     */ 
    public function set_id_member_FK($id_member_FK)
    {
        $this->id_member_FK = $id_member_FK;

        return $this;
    }

    /**
     * Get the value of comments
     */ 
    public function get_comments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     *
     * @return  self
     */ 
    public function set_comments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get the value of member
     */ 
    public function get_member()
    {
        return $this->member;
    }

    /**
     * Set the value of member
     *
     * @return  self
     */ 
    public function set_member($member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get the value of text_post_notags
     */ 
    public function get_text_post_notags()
    {
        return $this->text_post_notags;
    }

    /**
     * Set the value of text_post_notags
     *
     * @return  self
     */ 
    public function set_text_post_notags($text_post_notags)
    {
        $this->text_post_notags = $text_post_notags;

        return $this;
    }
}