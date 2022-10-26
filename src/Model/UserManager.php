<?php

namespace App\Model;

class UserManager extends AbstractManager{
    public const TABLE = 'user';

    public function selectOneByEmail(string $email): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function insertUser(array $user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (email, password, pseudo, firstname, lastname) VALUES (:email, :password, :pseudo, :firstname, :lastname)");
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('pseudo', $user['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}