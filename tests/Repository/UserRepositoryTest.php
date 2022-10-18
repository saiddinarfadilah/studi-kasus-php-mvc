<?php

namespace StudiKasus\PHP\MVC\Repository;

use PHPUnit\Framework\TestCase;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Domain\User;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $user = new User();
        $user->setId("said");
        $user->setUsername("Said");
        $user->setPassword("rahasia");

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->getId());

        self::assertEquals($user->getId(), $result->getId());
        self::assertEquals($user->getUsername(), $result->getUsername());
        self::assertEquals($user->getPassword(), $result->getPassword());
    }

    public function testFindIdNotFound()
    {
       $user =  $this->userRepository->findById("notfound");

       self::assertNull($user);
    }
}
