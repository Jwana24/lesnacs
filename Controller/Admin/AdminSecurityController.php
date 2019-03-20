<?php

class AdminSecurityController extends Controller
{
    // Members list
    public function list()
    {
        $memberManager = new MemberManager();
        $members = $memberManager->list();

        ob_start();
        require '../View/Admin/security/listMember.php';
        echo ob_get_clean();
    }
}