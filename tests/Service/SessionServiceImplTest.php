<?php

namespace StudiKasus\PHP\MVC\Service;
require_once __DIR__ . "/../Helper/helper.php";

use PHPUnit\Framework\TestCase;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Domain\Session;
use StudiKasus\PHP\MVC\Domain\User;
use StudiKasus\PHP\MVC\Repository\SessionRepositoryImpl;
use StudiKasus\PHP\MVC\Repository\UserRepository;

class SessionServiceImplTest extends TestCase
{
    private SessionRepositoryImpl $sessionRepositoryImpl;
    private SessionServiceImpl $sessionServiceImpl;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepositoryImpl = new SessionRepositoryImpl(Database::getConnection());
        $this->sessionServiceImpl = new SessionServiceImpl($this->sessionRepositoryImpl, $this->userRepository);

        $this->sessionRepositoryImpl->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->setId("said");
        $user->setUsername("Said");
        $user->setPassword("rahasia");
        $this->userRepository->save($user);
    }

    public function testCreate()
    {
        $session = $this->sessionServiceImpl->create("said");
        $result = $this->sessionRepositoryImpl->findById($session->getId());

        self::expectOutputRegex("[PHP-SESSION: {$session->getId()}]");
        self::assertEquals($session->getUserId(), $result->getUserId());
    }

    public function testDestroy()
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("said");
        $this->sessionRepositoryImpl->save($session);

        $_COOKIE[SessionServiceImpl::$COOKIE_NAME] = $session->getId();

        $this->sessionServiceImpl->destroy();
        $result = $this->sessionRepositoryImpl->findById($session->getId());

        $this->expectOutputRegex("[PHP-SESSION: ]");
        self::assertNull($result);
    }

    public function testCurrent()
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("said");

        $this->sessionRepositoryImpl->save($session);
        $_COOKIE[SessionServiceImpl::$COOKIE_NAME] = $session->getId();

        $user = $this->sessionServiceImpl->current();

        self::assertEquals($session->getUserId(), $user->getId());
    }
}
