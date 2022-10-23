<?php

namespace StudiKasus\PHP\MVC\Service;

use PHPUnit\Framework\TestCase;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Domain\User;
use StudiKasus\PHP\MVC\Exception\ValidationException;
use StudiKasus\PHP\MVC\Model\UserLoginRequest;
use StudiKasus\PHP\MVC\Model\UserRegisterRequest;
use StudiKasus\PHP\MVC\Model\UserUpdateProfileRequest;
use StudiKasus\PHP\MVC\Repository\SessionRepositoryImpl;
use StudiKasus\PHP\MVC\Repository\UserRepository;

class UserServiceTest extends TestCase
{
    private UserRepository $userRepository;
    private UserService $userService;
    private SessionRepositoryImpl $sessionRepositoryImpl;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userService = new UserService($this->userRepository);
        $this->sessionRepositoryImpl = new SessionRepositoryImpl(Database::getConnection());

        $this->sessionRepositoryImpl->deleteAll();

        $this->userRepository->deleteAll();
    }

    public function testRegister()
    {
        $request = new UserRegisterRequest();
        $request->setId("said");
        $request->setUsername("Said");
        $request->setPassword("rahasia");

        $response = $this->userService->register($request);

        self::assertEquals($request->getId(), $response->user->getId());
        self::assertEquals($request->getUsername(), $response->user->getUsername());
        self::assertNotEquals($request->getPassword(), $response->user->getPassword());

        self::assertTrue(password_verify($request->getPassword(), $response->user->getPassword()));
    }

    public function testRegisterDuplicate()
    {
        $user = new User();
        $user->setId("said");
        $user->setUsername("Said");
        $user->setPassword("rahasia");
        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->setId("said");
        $request->setUsername("Said");
        $request->setPassword("rahasia");

        $this->userService->register($request);
    }

    public function testRegisterFail()
    {
        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->setId("");
        $request->setUsername("Said");
        $request->setPassword("rahasia");

        $this->userService->register($request);
    }

    public function testLoginNotFound()
    {
        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->setId("said");
        $request->setPassword("rahasia");

        $this->userService->login($request);
    }

    public function testLoginSuccess()
    {
        $user = new User();
        $user->setId("said");
        $user->setUsername("Said");
        $user->setPassword(password_hash("rahasia", PASSWORD_BCRYPT));

        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->setId("said");
        $request->setPassword("rahasia");

        $response = $this->userService->login($request);

        self::assertEquals($request->getId(), $response->user->getId());
        self::assertTrue(password_verify($request->getPassword(), $response->user->getPassword()));
    }

    public function testLoginWrongPassword()
    {
        $user = new User();
        $user->setId("said");
        $user->setPassword(password_hash("rahasia", PASSWORD_BCRYPT));

        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->setId("said");
        $request->setPassword("rahasiaaaaa");

        $this->userService->login($request);

    }

    public function testUpdateProfileSuccess()
    {
        $user = new User();
        $user->setId("said");
        $user->setUsername("Said");
        $user->setPassword(password_hash("rahasia", PASSWORD_BCRYPT));
        $this->userRepository->save($user);

        $request = new UserUpdateProfileRequest();
        $request->setId("said");
        $request->setUserName("Saidupdate");

        $this->userService->updateProfile($request);

        $result = $this->userRepository->findById($user->getId());

        self::assertEquals($request->getUserName(), $result->getUsername());

    }
}
