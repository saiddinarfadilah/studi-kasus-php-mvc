<?php

namespace StudiKasus\PHP\MVC\Middleware;

use StudiKasus\PHP\MVC\App\View;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Repository\SessionRepositoryImpl;
use StudiKasus\PHP\MVC\Repository\UserRepository;
use StudiKasus\PHP\MVC\Service\SessionServiceImpl;

class MustNotLoginMiddleware implements Middleware
{
    private SessionServiceImpl $sessionServiceImpl;
    public function __construct()
    {
        $userRepository = new UserRepository(Database::getConnection());
        $sessionRepository = new SessionRepositoryImpl(Database::getConnection());
        $this->sessionServiceImpl = new SessionServiceImpl($sessionRepository, $userRepository);
    }

    public function before(): void
    {
        $user = $this->sessionServiceImpl->current();
        if ($user != null){
            View::redirect("/");
        }
    }
}