<?php

class DefaultController extends Controller
{
    public function index()
    {
        $titlePage = 'Le site LesNACs';
        $articleManager = new ArticleManager();
        $articles = $articleManager->showLast();
        ob_start();
        require '../View/general/homepage.php';
        echo ob_get_clean();
    }

    public function mentionsLegales()
    {
        // We create a cookie bandeau bound to the legacy notices's page, when the visitor go to this page, the cookie are accepted for 1 year
        setcookie('cookie-bandeauCookie', 'myseconddata', time() + 32140800, "/");

        ob_start();
        require '../View/general/legalnotices.php';
        echo ob_get_clean();
    }

}