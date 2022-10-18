<?php

namespace StudiKasus\PHP\MVC\Config;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private static ?\PDO $pdo = null;
    public function testGetConnection()
    {
        $conn = Database::getConnection();

        self::assertNotNull($conn);
    }

    public function testGetConnectionSingleton()
    {
        $conn1 = Database::getConnection();
        $conn2 = Database::getConnection();

        self::assertSame($conn1,$conn2);
    }
}
