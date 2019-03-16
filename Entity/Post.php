<?php

class Post
{
    private $_id = '';
    private $_title_post = '';
    private $_text_post = '';
    private $_date_post = '';
    private $_categorie = '';
    private $_resolve = '';
    private $_id_member_FK = '';


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
     * Get the value of _title_post
     */ 
    public function get_title_post()
    {
        return $this->_title_post;
    }

    /**
     * Set the value of _title_post
     *
     * @return  self
     */ 
    public function set_title_post($_title_post)
    {
        $this->_title_post = $_title_post;

        return $this;
    }

    /**
     * Get the value of _text_post
     */ 
    public function get_text_post()
    {
        return $this->_text_post;
    }

    /**
     * Set the value of _text_post
     *
     * @return  self
     */ 
    public function set_text_post($_text_post)
    {
        $this->_text_post = $_text_post;

        return $this;
    }

    /**
     * Get the value of _date_post
     */ 
    public function get_date_post()
    {
        return $this->_date_post;
    }

    /**
     * Set the value of _date_post
     *
     * @return  self
     */ 
    public function set_date_post($_date_post)
    {
        $this->_date_post = $_date_post;

        return $this;
    }

    /**
     * Get the value of _categorie
     */ 
    public function get_categorie()
    {
        return $this->_categorie;
    }

    /**
     * Set the value of _categorie
     *
     * @return  self
     */ 
    public function set_categorie($_categorie)
    {
        $this->_categorie = $_categorie;

        return $this;
    }

    /**
     * Get the value of _resolve
     */ 
    public function get_resolve()
    {
        return $this->_resolve;
    }

    /**
     * Set the value of _resolve
     *
     * @return  self
     */ 
    public function set_resolve($_resolve)
    {
        $this->_resolve = $_resolve;

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
}