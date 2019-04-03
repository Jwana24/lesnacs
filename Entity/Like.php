<?php

class Like
{
    private $id;
    private $id_member_FK;
    private $id_article_FK;

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
    public function set_id_article_FK($id_article_FK)
    {
        $this->id_article_FK = $id_article_FK;

        return $this;
    }
}