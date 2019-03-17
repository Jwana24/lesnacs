<?php

class Controller
{
    protected $router;
    protected $user;

    public function __construct($router)
    {
        $this->router = $router;
        $this->user = $_SESSION['user'] ?? NULL;
    }

    public function is_granted($role)
    {
        return ($this->user != NULL && $this->user->get_role() == $role) ? true : false;
    }

    public function cookie_exist($cookie)
    {
        return (isset($_COOKIE[$cookie])) ? true : false;
    }
}