<?php

namespace StudiKasus\PHP\MVC\Controller;

use StudiKasus\PHP\MVC\App\View;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Repository\SessionRepositoryImpl;
use StudiKasus\PHP\MVC\Repository\UserRepository;
use StudiKasus\PHP\MVC\Service\SessionServiceImpl;

class HomeController
{
    private SessionServiceImpl $sessionServiceImpl;

    public function __construct()
    {
        $userRepository = new UserRepository(Database::getConnection());
        $sessionRepository = new SessionRepositoryImpl(Database::getConnection());
        $this->sessionServiceImpl = new SessionServiceImpl($sessionRepository, $userRepository);
    }

    public function dashboard():void
    {
        $user = $this->sessionServiceImpl->current();
        if ($user == null){
            $model = [
                "title" => "login"
            ];
            View::render("User/login",$model);
        } else {
            $model = [
                "title" => "dashboard",
                "user" => [
                    "name" => $user->getUsername()
                ]
            ];

            View::render("User/index", $model);
        }
    }
}