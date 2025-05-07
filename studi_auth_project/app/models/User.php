<?php

class User
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;

    public static function findByUsername(string $username): ?self
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public static function findByEmail(string $email): ?self
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public static function findById(string $id): ?self
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public function verifyPassword(string $inputPassword): bool
    {
        return password_verify($inputPassword, $this->password);
    }

    public static function create(string $username, string $email, string $password): bool
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $password]);
    }

    public static function exists(string $usernameOrEmail): bool
    {
        return self::findByUsername($usernameOrEmail) !== null || self::findByEmail($usernameOrEmail) !== null;
    }

    public function setPassword(string $newPassword): self
    {
        $this->password = password_hash($newPassword, PASSWORD_BCRYPT);
        return $this;
    }

    public function save(): bool
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([$this->username, $this->email, $this->password, $this->id]);
    }

    public function delete(): bool
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
