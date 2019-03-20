<?php

session_start();

function classLoader($class)
{
    if(strpos($class, 'Controller') !== false)
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
$router = new AltoRouter();

// Create route mapping
$router->map('GET|POST', '/accueil/', 'DefaultController#index', 'accueil');
$router->map('GET|POST', '/article/', 'ArticleController#list', 'article_list');
$router->map('GET|POST', '/ajout-article/', 'ArticleController#add', 'add_article');
$router->map('GET|POST', '/article/[i:id]/', 'ArticleController#get', 'article_show');
$router->map('GET|POST', '/forum/', 'PostController#list', 'post_list');
$router->map('GET|POST', '/ajout-post/', 'PostController#add', 'add_post');
$router->map('GET|POST', '/forum/[i:id]/', 'PostController#get', 'post_show');
$router->map('GET|POST', '/mentionslegales/', 'DefaultController#mentionsLegales', 'mentionslegales');
$router->map('GET|POST', '/recherche/', 'SearchController#search', 'recherche');
$router->map('GET|POST', '/connexion/', 'MemberController#connection', 'connexion');
$router->map('GET|POST', '/inscription/', 'MemberController#add', 'inscription');
$router->map('GET|POST', '/motdepasseoublie/', 'MemberController#lostPassword', 'motdepasseoublie');
$router->map('GET|POST', '/profil/[i:id]/', 'MemberController#show', 'member_show');
$router->map('GET|POST', '/admin/', 'SecurityController#list', 'admin');

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
    echo '404 error';
}