<?php

namespace StudiKasus\PHP\MVC\Service;

use StudiKasus\PHP\MVC\Config\Database;
use StudiKasus\PHP\MVC\Domain\User;
use StudiKasus\PHP\MVC\Exception\ValidationException;
use StudiKasus\PHP\MVC\Model\UserLoginRequest;
use StudiKasus\PHP\MVC\Model\UserLoginResponse;
use StudiKasus\PHP\MVC\Model\UserRegisterRequest;
use StudiKasus\PHP\MVC\Model\UserRegisterResponse;
use StudiKasus\PHP\MVC\Model\UserUpdateProfileRequest;
use StudiKasus\PHP\MVC\Model\UserUpdateProfileResponse;
use StudiKasus\PHP\MVC\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request):UserRegisterResponse
    {
        $this->validate($request);
        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->getId());
            if ($user != null){
                throw new ValidationException("User already exists");
            }

            $user = new User();
            $user->setId($request->getId());
            $user->setUsername($request->getUsername());
            $user->setPassword(password_hash($request->getPassword(), PASSWORD_BCRYPT));

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();
            return $response;
        } catch (ValidationException $exception){
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validate(UserRegisterRequest $request):void
    {
        if ($request->getId() == null || trim($request->getId() == "")){
            throw new ValidationException("id cannot blank");
        }
    }

    public function login(UserLoginRequest $request):UserLoginResponse
    {
        $this->validateLoginRequest($request);
        $user = $this->userRepository->findById($request->getId());
        if ($user == null){
            throw new ValidationException("id and password is wrong");
        }

        if (password_verify($request->getPassword(), $user->getPassword()))
        {
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        } else {
            throw new ValidationException("id and password is wrong");
        }
    }

    public function validateLoginRequest(UserLoginRequest $request):void
    {
        if ($request->getId() == null || trim($request->getId() == "")){
            throw new ValidationException("id cannot blank");
        }
    }

    public function updateProfile(UserUpdateProfileRequest $request):UserUpdateProfileResponse
    {
        $this->validateUpdateProfileRequest($request);
        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->getId());
            if ($user == null){
                throw new ValidationException("User not found");
            }
            $user->setUsername($request->getUserName());
            $this->userRepository->update($user);

            $response = new UserUpdateProfileResponse();
            $response->user = $user;
            Database::commitTransaction();
            return $response;
        } catch (ValidationException $exception){
            Database::rollbackTransaction();
            throw new $exception;
        }
    }

    private function validateUpdateProfileRequest(UserUpdateProfileRequest $request):void
    {
        if ($request->getUsername() == null || trim($request->getUsername() == "")){
            throw new ValidationException("name cannot blank");
        }
    }
}