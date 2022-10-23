<?php
namespace StudiKasus\PHP\MVC\Service{
    function setcookie(string $name, string $value){
        echo "$name: $value";
    }
}

namespace StudiKasus\PHP\MVC\App{
    function header(string $value){
        echo $value;
    }
}