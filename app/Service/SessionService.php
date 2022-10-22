<?php

namespace StudiKasus\PHP\MVC\Service;

use StudiKasus\PHP\MVC\Domain\Session;
use StudiKasus\PHP\MVC\Domain\User;

interface SessionService
{
    public function create(string $userId):Session;
    public function destroy():void;
    public function current():?User;
}