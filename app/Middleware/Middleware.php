<?php

namespace StudiKasus\PHP\MVC\Middleware;

interface Middleware
{
    function before():void;
}