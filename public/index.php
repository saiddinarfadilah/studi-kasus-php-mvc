<?php

require_once __DIR__ . "/../vendor/autoload.php";

use StudiKasus\PHP\MVC\App\Router;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Controller\HomeController;
use StudiKasus\PHP\MVC\Controller\ProductController;
use StudiKasus\PHP\MVC\Controller\UserController;
use StudiKasus\PHP\MVC\Middleware\MustLoginMiddleware;
use StudiKasus\PHP\MVC\Middleware\MustNotLoginMiddleware;


Database::getConnection("dev");

Router::add("GET","/",HomeController::class, "dashboard", []);

Router::add("GET","/users/login",UserController::class, "formLogin", [MustNotLoginMiddleware::class]);
Router::add("POST","/users/login",UserController::class, "postLogin", [MustNotLoginMiddleware::class]);
Router::add("GET","/users/logout",UserController::class, "logout", [MustLoginMiddleware::class]);

Router::add("GET","/users/register",UserController::class, "formRegister", [MustNotLoginMiddleware::class]);
Router::add("POST","/users/register",UserController::class, "postRegister", [MustNotLoginMiddleware::class]);

Router::add("GET","/users/profile",UserController::class, "formUpdateProfile", [MustLoginMiddleware::class]);
Router::add("POST","/users/profile",UserController::class, "postUpdateProfile", [MustLoginMiddleware::class]);

Router::add("GET","/categories/([0-9a-zA-Z]*)",ProductController::class, "categories");

Router::run();

