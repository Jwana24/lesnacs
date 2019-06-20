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
    
    // If the member exist, updating the token in the database and in the session
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

    // generate an url with the "http" and the root of the path
    public function asset($path)
    {
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/'.$path;
    }

    // Create authorization for an access (ex. edit article for admin)
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

    // checking the membership of an object to a member (ex: a comment by a member)
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

    // Stock messages in the session
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

    // Create an extract to a long text (ex: card articles on the homepage)
    public function splitText($text, $nbWord)
    {
        $split = explode(' ', strip_tags($text), $nbWord+1);
        array_splice($split, $nbWord, 1);
        return join(' ', $split).'...';
    }
}