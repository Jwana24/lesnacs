<?php

class AdminSecurityController extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);

        if(!$this->is_granted([]))
        {
            header('Location:http://lesnacs.fr/accueil/');
        }
    }

    // Members list
    public function list()
    {
        $titlePage = $this->translation('Liste des membres');
        $memberManager = new MemberManager();
        $members = $memberManager->list();

        ob_start();
        require '../View/Admin/security/listMember.php';
        echo ob_get_clean();
    }
}