<?php

namespace StudiKasus\PHP\MVC\Service;

use StudiKasus\PHP\MVC\Domain\Session;
use StudiKasus\PHP\MVC\Domain\User;
use StudiKasus\PHP\MVC\Repository\SessionRepository;
use StudiKasus\PHP\MVC\Repository\UserRepository;

class SessionServiceImpl implements SessionService
{
    public static string $COOKIE_NAME = "PHP-SESSION";
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }
    public function create(string $userId): Session
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId($userId);

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->getId(), time() + (60*60*24*30), "/");
        return $session;
    }

    public function destroy(): void
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? "";
        $this->sessionRepository->deleteById($sessionId);
        setcookie(self::$COOKIE_NAME, "",1,"/");
    }

    public function current(): ?User
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? "";
        $session = $this->sessionRepository->findById($sessionId);
        if ($sessionId == null){
            return null;
        }

        return $this->userRepository->findById($session->getUserId());
    }
}