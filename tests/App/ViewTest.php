<?php

namespace StudiKasus\PHP\MVC\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{

    public function testRender()
    {
        $model = [
            "title" => "Login",
        ];

        View::render("User/login", $model);

        $this->expectOutputRegex("[Login]");
        $this->expectOutputRegex("[html]");
        $this->expectOutputRegex("[body]");
        $this->expectOutputRegex("[Email]");
        $this->expectOutputRegex("[Password]");
        $this->expectOutputRegex("[Sign in]");
//        $this->expectOutputRegex("[Nothing]");
    }
}
