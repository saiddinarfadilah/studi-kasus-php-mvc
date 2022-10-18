<?php

function getDatabaseConfig():array
{
    return [
        "database" => [
            "test" => [
                "url"       => "mysql:host=localhost;dbname=sk_php_mvc_test",
                "user"      => "root",
                "password"  => "root",
            ],
            "dev" => [
                "url"       => "mysql:host=localhost;dbname=sk_php_mvc",
                "user"      => "root",
                "password"  => "root",
            ]
        ]
    ];
}
