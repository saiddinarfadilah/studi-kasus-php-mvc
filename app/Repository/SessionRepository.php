<?php

namespace StudiKasus\PHP\MVC\Repository;

use StudiKasus\PHP\MVC\Domain\Session;

interface SessionRepository
{
    public function save(Session $session):Session;
    public function findById(string $id):?Session;
    public function deleteById(string $id):void;
    public function deleteAll():void;
}