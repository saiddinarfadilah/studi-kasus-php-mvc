<?php

namespace StudiKasus\PHP\MVC\Repository;

use PHPUnit\Framework\TestCase;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Domain\Session;
use StudiKasus\PHP\MVC\Domain\User;

class SessionRepositoryImplTest extends TestCase
{
    private UserRepository $userRepository;
    private SessionRepositoryImpl $sessionRepositoryImpl;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepositoryImpl = new SessionRepositoryImpl(Database::getConnection());

        $this->sessionRepositoryImpl->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->setId("said");
        $user->setUsername("Said");
        $user->setPassword("rahasia");
        $this->userRepository->save($user);
    }

    public function testSaveSuccess()
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("said");
        $this->sessionRepositoryImpl->save($session);

        $result = $this->sessionRepositoryImpl->findById($session->getId());

        self::assertEquals($session->getId(), $result->getId());
        self::assertEquals($session->getUserId(), $result->getUserId());

    }

    public function testDeleteByIdSuccess()
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("said");
        $this->sessionRepositoryImpl->save($session);

        $this->sessionRepositoryImpl->deleteById($session->getId());

        $result = $this->sessionRepositoryImpl->findById($session->getId());

        self::assertNull($result);
    }

    public function testFindIdNotFound()
    {
        $result = $this->sessionRepositoryImpl->findById("");

        self::assertNull($result);
    }
}
