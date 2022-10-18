<?php

namespace StudiKasus\PHP\MVC\Repository;

use StudiKasus\PHP\MVC\Domain\User;

class UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user):User
    {
        $sql = "INSERT INTO users(id, username, password) VALUES (?,?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$user->getId(), $user->getUsername(),$user->getPassword()]);
        return $user;
    }

    public function findById(string $id):?User
    {
        $sql = "SELECT id, username, password FROM users WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);

        if ($row = $statement->fetch()){
            $user = new User();
            $user->setId($row["id"]);
            $user->setUsername($row["username"]);
            $user->setPassword($row["password"]);
            return $user;
        } else {
            return null;
        }
    }

    public function deleteAll():void
    {
        $sql = "DELETE FROM users";
        $this->connection->exec($sql);
    }
}