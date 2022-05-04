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
use Slim\Factory\AppFactory;

//create new App object
$app = AppFactory::create();
$app->addBodyParsingMiddleware(); // $_POST

//middleware session
$app->add(new SessionMiddleware());

// middleware log all actions
$app->add(new LogMiddleware());

//render controllers
$app->get('/', new IndexController());
$app->get('/login', new LoginController());
$app->get('/add-user', new AddUserController());
$app->get('/activity', new ActivityController());
$app->get('/users-list', new UsersListController());

//action controllers
$app->post('/login-post', LoginController::class . ':loginPost');
$app->post('/add-user-post', AddUserController::class . ':addUser');
$app->post('/block-user', UsersListController::class . ':blockUnblockUser');
$app->get('/logout', LoginController::class . ':logOut');

//start app
$app->run();