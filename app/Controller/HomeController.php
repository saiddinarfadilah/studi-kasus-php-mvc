<?php

namespace StudiKasus\PHP\MVC\Controller;

use StudiKasus\PHP\MVC\App\View;

class HomeController
{
    public function dashboard():void
    {
        $model = [
            "title" => "dashboard",
            "content" => "Welcome xxx"
        ];

        View::render("User/index", $model);
    }
}