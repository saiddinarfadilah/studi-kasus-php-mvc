<?php
namespace StudiKasus\PHP\MVC\App{
    function header(string $value){
        echo $value;
    }
}
namespace StudiKasus\PHP\MVC\Controller{
    use PHPUnit\Framework\TestCase;
    use StudiKasus\PHP\MVC\Config\Database;
    use StudiKasus\PHP\MVC\Domain\User;
    use StudiKasus\PHP\MVC\Repository\UserRepository;

    class UserControllerTest extends TestCase
    {
        private UserController $userController;
        private UserRepository $userRepository;

        protected function setUp(): void
        {
            $this->userRepository = new UserRepository(Database::getConnection());
            $this->userController = new UserController();
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
        }
    }
}


