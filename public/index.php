<?php

require_once __DIR__ . "/../vendor/autoload.php";

use StudiKasus\PHP\MVC\App\Router;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Controller\HomeController;
use StudiKasus\PHP\MVC\Controller\ProductController;
use StudiKasus\PHP\MVC\Controller\UserController;


Database::getConnection("dev");

Router::add("GET","/",HomeController::class, "dashboard");

Router::add("GET","/users/login",UserController::class, "formLogin");
Router::add("POST","/users/login",UserController::class, "postLogin");

Router::add("GET","/users/register",UserController::class, "formRegister");
Router::add("POST","/users/register",UserController::class, "postRegister");

Router::add("GET","/categories/([0-9a-zA-Z]*)",ProductController::class, "categories");

Router::run();

