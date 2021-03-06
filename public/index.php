<?php

session_start();

function classLoader($class)
{
    if(strpos($class, 'Admin') !== false)
    {
        require '../Controller/Admin/'.$class.'.php';
    }
    elseif(strpos($class, 'Controller') !== false)
    {
        require '../Controller/'.$class.'.php';
    }
    elseif(strpos($class, 'Manager') !== false)
    {
        require '../Model/'.$class.'.php';
    }
    else
    {
        require '../Entity/'.$class.'.php';
    }
}
spl_autoload_register('classLoader');

require '../AltoRouter.php';
require '../vendor/autoload.php';
$router = new AltoRouter();

// Create route mapping
// article route
$router->map('GET|POST', '/article/', 'ArticleController#list', 'article_list');
$router->map('GET|POST', '/ajout-article/', 'AdminArticleController#add', 'add_article');
$router->map('GET|POST', '/article/[i:id]/', 'ArticleController#show', 'article_show');
$router->map('GET|POST', '/article/edition/[i:id]/', 'AdminArticleController#edit', 'edit_article');
$router->map('GET|POST', '/article/suppression/', 'AdminArticleController#delete', 'delete_article');
// forum route
$router->map('GET|POST', '/forum/', 'PostController#list', 'post_list');
$router->map('GET|POST', '/ajout-post/', 'PostController#add', 'add_post');
$router->map('GET|POST', '/forum/[i:id]/', 'PostController#show', 'post_show');
$router->map('GET|POST', '/post/edition/[i:id]/', 'PostController#edit', 'edit_post');
$router->map('GET|POST', '/post/suppression/', 'PostController#delete', 'delete_post');
// comment route
$router->map('GET|POST', '/commentaire/edition/[i:id]/', 'CommentController#edit', 'edit_comment');
$router->map('GET|POST', '/commentaire/suppression/', 'CommentController#delete', 'delete_comment');
// general route
$router->map('GET|POST', '/accueil/', 'DefaultController#index', 'accueil');
$router->map('GET|POST', '/mentionslegales/', 'DefaultController#mentionsLegales', 'mentionslegales');
$router->map('GET|POST', '/recherche/', 'SearchController#search', 'recherche');
$router->map('GET|POST', '/langue/[a:lang]/', 'TranslateController#edit', 'translation');
// member route
$router->map('GET|POST', '/connexion/', 'MemberController#login', 'connexion');
$router->map('GET|POST', '/deconnexion/', 'MemberController#logout', 'deconnexion');
$router->map('GET|POST', '/inscription/', 'MemberController#add', 'inscription');
$router->map('GET|POST', '/motdepasseoublie/', 'MemberController#lostPassword', 'motdepasseoublie');
$router->map('GET|POST', '/reinitialisermotdepasse/[i:id]/[a:token]/', 'MemberController#resetPassword', 'reset_password');
$router->map('GET|POST', '/profil/[i:id]/', 'MemberController#show', 'member_show');
$router->map('GET|POST', '/profil/edition/[i:id]/', 'MemberController#edit', 'edit_member');
$router->map('GET|POST', '/profil/suppression/', 'MemberController#delete', 'delete_member');
$router->map('GET|POST', '/admin/liste-membres/', 'AdminSecurityController#list', 'member_list');

$route = $router->match();

if($route)
{
    $target = explode('#', $route['target']);
    $routeController = $target[0];
    $routeAction = $target[1];
    $routeParams = $route['params'];

    $controller = new $routeController($router);
    $controller->$routeAction($routeParams);
}
else
{
    header('Location:'.$router->generate('accueil'));
}