<?php

namespace StudiKasus\PHP\MVC\App;

class Router
{
    private static array $routes = [];

    public static function add(string $methodRequest, string $path, string $controller, string $function):void
    {
        self::$routes[] = [
            "requestMethod" => $methodRequest,
            "path"          => $path,
            "controller"    => $controller,
            "function"      => $function
        ];
    }

    public static function run():void
    {
        $requestMethod = "";
        if (isset($_SERVER["REQUEST_METHOD"])){
            $requestMethod = $_SERVER["REQUEST_METHOD"];
        }
        $path = "/";
        if (isset($_SERVER["PATH_INFO"])){
            $path = $_SERVER["PATH_INFO"];
        }

        foreach (self::$routes as $route){
            // menggunakan regex untuk mengambil path variable di params
            $pattern = "#^" . $route["path"] . "$#";
            if ($requestMethod == $route["requestMethod"] && preg_match($pattern,$path, $matches)){
                $function = $route["function"];
                $controller = new $route["controller"];
//                $controller->$function();
                array_shift($matches);
                call_user_func_array([$controller,$function], $matches);
                return;
            }
        }
    }
}