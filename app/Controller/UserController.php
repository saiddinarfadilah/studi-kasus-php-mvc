<?php

namespace StudiKasus\PHP\MVC\Controller;

use StudiKasus\PHP\MVC\App\View;
use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Exception\ValidationException;
use StudiKasus\PHP\MVC\Model\UserLoginRequest;
use StudiKasus\PHP\MVC\Model\UserRegisterRequest;
use StudiKasus\PHP\MVC\Repository\UserRepository;
use StudiKasus\PHP\MVC\Service\UserService;

class UserController
{
    private UserRepository $userRepository;
    private UserService $userService;

    public function __construct()
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userService = new UserService($this->userRepository);
    }

    public function formRegister():void
    {
        $model = [
            "title" => "Register new user"
        ];
        View::render("User/register", $model);
    }

    public function postRegister():void
    {
        $request = new UserRegisterRequest();
        $request->setId($_POST["id"]);
        $request->setUsername($_POST["username"]);
        $request->setPassword($_POST["password"]);
        try {
            $this->userService->register($request);
            View::redirect("/users/login");
        } catch (ValidationException $exception){
            View::render("User/register", [
                "title" => "Register new user",
                "error" => $exception->getMessage()
            ]);
        }
    }

    public function formLogin():void
    {
        $model = [
            "title" => "Login",
        ];

        View::render("User/login", $model);
    }

    public function postLogin():void
    {
        $request = new UserLoginRequest();
        $request->setId($_POST["id"]);
        $request->setPassword($_POST["password"]);
        try {
            $this->userService->login($request);
            View::redirect("/");
        } catch (ValidationException $exception){
            View::render("User/login", [
                "title" => "Login",
                "error" => $exception->getMessage()
            ]);
        }
    }
}