<?php

// We create a class "membre" with all the informations which we have need compared to our fields in the database
class Member
{
    private $_id = '';
    private $_last_name = '';
    private $_first_name = '';
    private $_username = '';
    private $_password = '';
    private $_mail = '';
    private $_roles = '';
    private $_avatar = '';
    private $_token_session = '';
    private $_token_password = '';
    private $_date_inscription = '';
    private $_description = '';
    private $_locale = '';



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
     * Get the value of _last_name
     */ 
    public function get_last_name()
    {
        return $this->_last_name;
    }

    /**
     * Set the value of _last_name
     *
     * @return  self
     */ 
    public function set_last_name($_last_name)
    {
        $this->_last_name = $_last_name;

        return $this;
    }

    /**
     * Get the value of _first_name
     */ 
    public function get_first_name()
    {
        return $this->_first_name;
    }

    /**
     * Set the value of _first_name
     *
     * @return  self
     */ 
    public function set_first_name($_first_name)
    {
        $this->_first_name = $_first_name;

        return $this;
    }

    /**
     * Get the value of _username
     */ 
    public function get_username()
    {
        return $this->_username;
    }

    /**
     * Set the value of _username
     *
     * @return  self
     */ 
    public function set_username($_username)
    {
        $this->_username = $_username;

        return $this;
    }

    /**
     * Get the value of _password
     */ 
    public function get_password()
    {
        return $this->_password;
    }

    /**
     * Set the value of _password
     *
     * @return  self
     */ 
    public function set_password($_password)
    {
        $this->_password = $_password;

        return $this;
    }

    /**
     * Get the value of _mail
     */ 
    public function get_mail()
    {
        return $this->_mail;
    }

    /**
     * Set the value of _mail
     *
     * @return  self
     */ 
    public function set_mail($_mail)
    {
        $this->_mail = $_mail;

        return $this;
    }

    /**
     * Get the value of _roles
     */ 
    public function get_roles()
    {
        return $this->_roles;
    }

    /**
     * Set the value of _roles
     *
     * @return  self
     */ 
    public function set_roles($_roles)
    {
        $this->_roles = $_roles;

        return $this;
    }

    /**
     * Get the value of _avatar
     */ 
    public function get_avatar()
    {
        return $this->_avatar;
    }

    /**
     * Set the value of _avatar
     *
     * @return  self
     */ 
    public function set_avatar($_avatar)
    {
        $this->_avatar = $_avatar;

        return $this;
    }

    /**
     * Get the value of _token_session
     */ 
    public function get_token_session()
    {
        return $this->_token_session;
    }

    /**
     * Set the value of _token_session
     *
     * @return  self
     */ 
    public function set_token_session($_token_session)
    {
        $this->_token_session = $_token_session;

        return $this;
    }

    /**
     * Get the value of _token_password
     */ 
    public function get_token_password()
    {
        return $this->_token_password;
    }

    /**
     * Set the value of _token_password
     *
     * @return  self
     */ 
    public function set_token_password($_token_password)
    {
        $this->_token_password = $_token_password;

        return $this;
    }

    /**
     * Get the value of _date_inscription
     */ 
    public function get_date_inscription()
    {
        return $this->_date_inscription;
    }

    /**
     * Set the value of _date_inscription
     *
     * @return  self
     */ 
    public function set_date_inscription($_date_inscription)
    {
        $this->_date_inscription = $_date_inscription;

        return $this;
    }

    /**
     * Get the value of _description
     */ 
    public function get_description()
    {
        return $this->_description;
    }

    /**
     * Set the value of _description
     *
     * @return  self
     */ 
    public function set_description($_description)
    {
        $this->_description = $_description;

        return $this;
    }

    /**
     * Get the value of _locale
     */ 
    public function get_locale()
    {
        return $this->_locale;
    }

    /**
     * Set the value of _locale
     *
     * @return  self
     */ 
    public function set_locale($_locale)
    {
        $this->_locale = $_locale;

        return $this;
    }
}