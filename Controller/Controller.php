<?php

class Controller
{
    protected $router;
    protected $member;
    protected $lang;

    public function __construct($router)
    {
        $this->router = $router;
        $this->member = isset($_SESSION['member']) ? unserialize($_SESSION['member']) : NULL;
        $_SESSION['success'] = $_SESSION['success'] ?? '';
        $_SESSION['error'] = $_SESSION['error'] ?? [];
        $this->defaultLang();
    }
    
    public function tokenSession()
    {
        if($this->member != NULL)
        {
            $memberManager = new MemberManager();
            $this->member->set_token_session(password_hash(uniqid(), PASSWORD_BCRYPT));
            $memberManager->edit($this->member);
            $_SESSION['member'] = serialize($this->member);
        }
    }

    public function asset($path)
    {
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/'.$path;
    }

    public function is_granted(array $role)
    {
        if($this->member != NULL)
        {
            return (in_array($this->member->get_roles(), $role) || $this->member->get_roles() === 'ROLE_ADMIN') ? true : false;
        }
        else
        {
            return false;
        }
    }

    public function cookie_exist($cookie)
    {
        return (isset($_COOKIE[$cookie])) ? true : false;
    }

    public function voter($subject)
    {
        if($this->member != NULL)
        {
            return $this->member->get_id() === $subject->get_member()->get_id() || $this->member->get_roles() === 'ROLE_ADMIN';
        }
        else
        {
            return false;
        }
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

    public function translation($trans)
    {
        require '../languages.php';
        return $languages[$this->lang][$trans] ?? $trans;
    }

    public function defaultLang()
    {
        if($this->member != NULL)
        {
            $this->lang = $this->member->get_locale() ?? 'fr';
        }
        else
        {
            $this->lang = 'fr';
        }
    }

    public function splitText($text, $nbWord)
    {
        $split = explode(' ', $text, $nbWord+1);
        array_splice($split, $nbWord, 1);
        return join(' ', $split);
    }
}