<?php

class Like
{
    private $_id = '';
    private $_id_member_FK = '';
    private $_id_article_FK = '';

    /**
     * Get the value of _id
     */ 
    public function get_id()
    {
        return $this->_id;
    }

    /**
     * Set the value of _id
     *
     * @return  self
     */ 
    public function set_id($_id)
    {
        $this->_id = $_id;

        return $this;
    }

    /**
     * Get the value of _id_member_FK
     */ 
    public function get_id_member_FK()
    {
        return $this->_id_member_FK;
    }

    /**
     * Set the value of _id_member_FK
     *
     * @return  self
     */ 
    public function set_id_member_FK($_id_member_FK)
    {
        $this->_id_member_FK = $_id_member_FK;

        return $this;
    }

    /**
     * Get the value of _id_article_FK
     */ 
    public function get_id_article_FK()
    {
        return $this->_id_article_FK;
    }

    /**
     * Set the value of _id_article_FK
     *
     * @return  self
     */ 
    public function set_id_article_FK($_id_article_FK)
    {
        $this->_id_article_FK = $_id_article_FK;

        return $this;
    }
}