<?php

namespace StudiKasus\PHP\MVC\Controller;

use PHPUnit\Framework\TestCase;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Domain\Session;
use StudiKasus\PHP\MVC\Domain\User;
use StudiKasus\PHP\MVC\Repository\SessionRepositoryImpl;
use StudiKasus\PHP\MVC\Repository\UserRepository;
use StudiKasus\PHP\MVC\Service\SessionServiceImpl;

class HomeControllerTest extends TestCase
{
    private UserRepository $userRepository;
    private SessionRepositoryImpl $sessionRepositoryImpl;
    private HomeController $homeController;

    protected function setUp(): void
    {
        $this->homeController = new HomeController();
        $this->sessionRepositoryImpl = new SessionRepositoryImpl(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepositoryImpl->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testUserLogin()
    {
        $user = new User();
        $user->setId("said");
        $user->setUsername("Said");
        $user->setPassword("rahasia");
        $this->userRepository->save($user);

        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("said");
        $this->sessionRepositoryImpl->save($session);

        $_COOKIE[SessionServiceImpl::$COOKIE_NAME] = $session->getId();

        $this->homeController->dashboard();

        $this->expectOutputRegex("[Dashboard]");

    }
}
