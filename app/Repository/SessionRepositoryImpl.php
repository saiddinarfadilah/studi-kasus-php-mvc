<?php

namespace StudiKasus\PHP\MVC\Repository;

use StudiKasus\PHP\MVC\Domain\Session;

class SessionRepositoryImpl implements SessionRepository
{
    private \PDO $connection;
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session): Session
    {
        $sql = "INSERT INTO sessions(id, user_id) VALUES (?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$session->getId(), $session->getUserId()]);

        return $session;
    }

    public function findById(string $id): ?Session
    {
        $sql = "SELECT id, user_id FROM sessions WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);

        if ($row = $statement->fetch()){
            $session = new Session();
            $session->setId($row["id"]);
            $session->setUserId($row["user_id"]);
            return $session;
        } else {
            return null;
        }
    }

    public function deleteById(string $id): void
    {
       $sql = "DELETE FROM sessions WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $sql = "DELETE FROM sessions";
        $this->connection->exec($sql);
    }
}