<?php

class Comment
{
    private $id;
    private $text_comment;
    private $date_comment;
    private $id_member_FK;
    private $id_article_FK;
    private $id_post_FK;
    private $id_parent;
    private $member;
    private $responses;


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
     * Get the value of _text_comment
     */ 
    public function get_text_comment()
    {
        return $this->text_comment;
    }

    /**
     * Set the value of _text_comment
     *
     * @return  self
     */ 
    public function set_text_comment($_text_comment)
    {
        $this->text_comment = $_text_comment;

        return $this;
    }

    /**
     * Get the value of _date_comment
     */ 
    public function get_date_comment()
    {
        return $this->date_comment;
    }

    /**
     * Set the value of _date_comment
     *
     * @return  self
     */ 
    public function set_date_comment($_date_comment)
    {
        $this->date_comment = $_date_comment;

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
    public function set_id_member_FK($_id_member_FK)
    {
        $this->id_member_FK = $_id_member_FK;

        return $this;
    }

    /**
     * Get the value of _id_article_FK
     */ 
    public function get_id_article_FK()
    {
        return $this->id_article_FK;
    }

    /**
     * Set the value of _id_article_FK
     *
     * @return  self
     */ 
    public function set_id_article_FK($_id_article_FK)
    {
        $this->id_article_FK = $_id_article_FK;

        return $this;
    }

    /**
     * Get the value of _id_post_FK
     */ 
    public function get_id_post_FK()
    {
        return $this->id_post_FK;
    }

    /**
     * Set the value of _id_post_FK
     *
     * @return  self
     */ 
    public function set_id_post_FK($_id_post_FK)
    {
        $this->id_post_FK = $_id_post_FK;

        return $this;
    }

    /**
     * Get the value of _id_parent
     */ 
    public function get_id_parent()
    {
        return $this->id_parent;
    }

    /**
     * Set the value of _id_parent
     *
     * @return  self
     */ 
    public function set_id_parent($_id_parent)
    {
        $this->id_parent = $_id_parent;

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
     * Get the value of responses
     */ 
    public function get_responses()
    {
        return $this->responses;
    }

    /**
     * Set the value of responses
     *
     * @return  self
     */ 
    public function set_responses($responses)
    {
        $this->responses = $responses;

        return $this;
    }
}