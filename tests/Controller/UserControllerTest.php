<?php

namespace StudiKasus\PHP\MVC\Controller{
    require_once __DIR__ . "/../Helper/helper.php";
    use PHPUnit\Framework\TestCase;
    use StudiKasus\PHP\MVC\Config\Database;
    use StudiKasus\PHP\MVC\Domain\Session;
    use StudiKasus\PHP\MVC\Domain\User;
    use StudiKasus\PHP\MVC\Repository\SessionRepositoryImpl;
    use StudiKasus\PHP\MVC\Repository\UserRepository;
    use StudiKasus\PHP\MVC\Service\SessionServiceImpl;

    class UserControllerTest extends TestCase
    {
        private UserController $userController;
        private UserRepository $userRepository;
        private SessionRepositoryImpl $sessionRepositoryImpl;

        protected function setUp(): void
        {
            $this->sessionRepositoryImpl = new SessionRepositoryImpl(Database::getConnection());
            $this->userRepository = new UserRepository(Database::getConnection());
            $this->userController = new UserController();
            $this->sessionRepositoryImpl->deleteAll();
            $this->userRepository->deleteAll();
            putenv("mode=test");

        }
        public function testPostRegisterSuccess()
        {
            $_POST["id"] = "said";
            $_POST["username"] = "Said";
            $_POST["password"] = "rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[/users/login]");
        }

        public function testPostLoginSuccess()
        {
            $user = new User();
            $user->setId("said");
            $user->setUsername("Said");
            $user->setPassword(password_hash("rahasia", PASSWORD_BCRYPT));
            $this->userRepository->save($user);

            $_POST["id"] = "said";
            $_POST["password"] = "rahasia";
            $this->userController->postLogin();

            $this->expectOutputRegex("[Location: /]");
            $this->expectOutputRegex("[PHP-SESSION: ]");
        }

        public function testPostUpdateProfileSuccess()
        {
            $user = new User();
            $user->setId("said");
            $user->setUsername("Said");
            $user->setPassword(password_hash("rahasia", PASSWORD_BCRYPT));
            $this->userRepository->save($user);

            $session = new Session();
            $session->setId(uniqid());
            $session->setUserId($user->getId());
            $this->sessionRepositoryImpl->save($session);

            $_COOKIE[SessionServiceImpl::$COOKIE_NAME] = $session->getId();

            $_POST["username"] = "Said Update";
            $this->userController->postUpdateProfile();
            $this->expectOutputRegex("[Location: /]");

            $result = $this->userRepository->findById("said");
            self::assertEquals($_POST["username"], $result->getUsername());
        }
    }
}


