<?php

// We create a class "membre" with all the informations which we have need compared to our fields in the database
class Member
{
    private $id;
    private $last_name;
    private $first_name;
    private $username;
    private $password;
    private $mail;
    private $roles;
    private $avatar;
    private $token_session;
    private $token_password;
    private $date_inscription;
    private $description;
    private $locale;



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
     * Get the value of _last_name
     */ 
    public function get_last_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of _last_name
     *
     * @return  self
     */ 
    public function set_last_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of _first_name
     */ 
    public function get_first_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of _first_name
     *
     * @return  self
     */ 
    public function set_first_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of _username
     */ 
    public function get_username()
    {
        return $this->username;
    }

    /**
     * Set the value of _username
     *
     * @return  self
     */ 
    public function set_username($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of _password
     */ 
    public function get_password()
    {
        return $this->password;
    }

    /**
     * Set the value of _password
     *
     * @return  self
     */ 
    public function set_password($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of _mail
     */ 
    public function get_mail()
    {
        return $this->mail;
    }

    /**
     * Set the value of _mail
     *
     * @return  self
     */ 
    public function set_mail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of _roles
     */ 
    public function get_roles()
    {
        return $this->roles;
    }

    /**
     * Set the value of _roles
     *
     * @return  self
     */ 
    public function set_roles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the value of _avatar
     */ 
    public function get_avatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of _avatar
     *
     * @return  self
     */ 
    public function set_avatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of _token_session
     */ 
    public function get_token_session()
    {
        return $this->token_session;
    }

    /**
     * Set the value of _token_session
     *
     * @return  self
     */ 
    public function set_token_session($token_session)
    {
        $this->token_session = $token_session;

        return $this;
    }

    /**
     * Get the value of _token_password
     */ 
    public function get_token_password()
    {
        return $this->token_password;
    }

    /**
     * Set the value of _token_password
     *
     * @return  self
     */ 
    public function set_token_password($token_password)
    {
        $this->token_password = $token_password;

        return $this;
    }

    /**
     * Get the value of _date_inscription
     */ 
    public function get_date_inscription()
    {
        return $this->date_inscription;
    }

    /**
     * Set the value of _date_inscription
     *
     * @return  self
     */ 
    public function set_date_inscription($date_inscription)
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * Get the value of _description
     */ 
    public function get_description()
    {
        return $this->description;
    }

    /**
     * Set the value of _description
     *
     * @return  self
     */ 
    public function set_description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of _locale
     */ 
    public function get_locale()
    {
        return $this->locale;
    }

    /**
     * Set the value of _locale
     *
     * @return  self
     */ 
    public function set_locale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
}