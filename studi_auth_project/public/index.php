<?php

require_once '../config/config.php';
require_once '../core/bootstrap.php';

$router = new Router();

// Auth
$router->get('/login', 'AuthController@login', 'Connexion');
$router->post('/login', 'AuthController@login', 'Connexion');
$router->get('/signup', 'AuthController@signup', 'Créer un compte');
$router->post('/signup', 'AuthController@signup', 'Créer un compte');
$router->get('/logout', 'AuthController@logout');

// Home
$router->get('/', function () {
    redirectIfLoggedIn();
    render('home');
});

// Articles
$router->get('/articles', 'ArticleController@index', 'Articles');
$router->get('/articles/{id}', 'ArticleController@show', 'Détails de l\'article');
$router->get('/articles/author/{id}', 'ArticleController@showAuthor', 'Articles de l\'auteur');
$router->post('/articles', 'ArticleController@create');
$router->get('/articles/edit/{id}', 'ArticleController@edit', 'Modifier l\'article');
$router->post('/articles/edit/{id}', 'ArticleController@edit', 'Modifier l\'article');
$router->get('/articles/delete/{id}', 'ArticleController@delete');

// User
$router->get('/user', 'UserController@show', 'Profil');
$router->get('/user/edit', 'UserController@edit', 'Modifier le profil');
$router->post('/user/edit', 'UserController@edit', 'Modifier le profil');
$router->get('/user/delete', 'UserController@delete');

$router->run();
