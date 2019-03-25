<?php

class Controller
{
    protected $router;
    protected $member;

    public function __construct($router)
    {
        $this->router = $router;
        $this->member = isset($_SESSION['member']) ? unserialize($_SESSION['member']) : NULL;
        $_SESSION['success'] = $_SESSION['success'] ?? '';
        $_SESSION['error'] = $_SESSION['error'] ?? [];
    }
    
    public function tokenSession()
    {
        if($this->member != NULL)
        {
            $memberManager = new MemberManager();
            $this->member->set_token_session(password_hash(uniqid(), PASSWORD_BCRYPT));
            $memberManager->edit($this->member);
        }
    }

    public function is_granted(array $role)
    {
        return ($this->member != NULL && in_array($this->member->get_roles(), $role)) ? true : false;
    }

    public function cookie_exist($cookie)
    {
        return (isset($_COOKIE[$cookie])) ? true : false;
    }

    public function voter($subject)
    {
        return $this->member->get_id() === $subject->get_id_member_FK() || $this->member->get_roles()[0] === 'ROLE_ADMIN';
    }

    public function addMessages($message, $type)
    {
        if($type == 'success')
        {
            $_SESSION['success'] = $message;
        }
        else if($type == 'error')
        {
            $_SESSION['error'][] = $message;
        }
    }

    public function getMessage($type)
    {
        if($type == 'success')
        {
            $success = $_SESSION['success'];
            $_SESSION['success'] = '';
            return $success;
        }
        else if($type == 'error')
        {
            $error = $_SESSION['error'];
            $_SESSION['error'] = [];
            return $error;
        }
    }
}