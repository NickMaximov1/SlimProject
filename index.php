<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Controller\ActivityController;
use Controller\AddUserController;
use Controller\IndexController;
use Controller\LoginController;
use Controller\UsersListController;
use Middleware\LogMiddleware;
use Middleware\SessionMiddleware;
use Repository\UserRepository;
use Slim\Factory\AppFactory;
//create new App object
$app = AppFactory::create();
$app->addBodyParsingMiddleware(); // $_POST

//middleware session
$app->add(new SessionMiddleware());

// middleware log all actions
$app->add(new LogMiddleware());

//render controllers
$app->get('/', IndexController::class . ':viewIndex');
$app->get('/login', LoginController::class . ':viewLogin');
$app->get('/add-user', AddUserController::class . ':viewLogin');
$app->get('/activity', ActivityController::class . ':viewActivity');
$app->get('/users-list', UsersListController::class . ':viewUsersList');

//action controllers
$app->post('/login-post', LoginController::class . ':loginPost');
$app->post('/add-user-post', AddUserController::class . ':addUser');
$app->post('/block-user', UsersListController::class . ':blockUnblockUser');
$app->get('/logout', LoginController::class . ':logOut');

//start app
$app->run();