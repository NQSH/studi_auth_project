<?php

class User
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;

    public static function connect(string $identifier, string $password): ?self
    {
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::findByEmail($identifier);
        } else {
            $user = User::findByUsername($identifier);
        }

        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            throw new Exception("Nom d'utilisateur ou mot de passe incorrect.");
        }
    }

    public static function findByUsername(string $username): ?self
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([cleanInput($username)]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public static function findByEmail(string $email): ?self
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([cleanInput($email)]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public static function findById(string $id): ?self
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([cleanInput($id)]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public function verifyPassword(string $inputPassword): bool
    {
        return password_verify($inputPassword, $this->password);
    }

    public static function create(string $username, string $email, string $password,): bool
    {
        if (User::exists($username) || User::exists($email)) {
            throw new Exception("Nom d'utilisateur ou e-mail déjà utilisé.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $db = Database::getPDOConnection();
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword]);
    }

    public static function exists(string $identifier): bool
    {
        return self::findByUsername($identifier) !== null || self::findByEmail($identifier) !== null || self::findById($identifier) !== null;
    }

    public function update(string $username, string $email, string $password): void
    {
        $this->username = $username;
        $this->email = $email;
        if (!empty($password)) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->save();
    }

    private function save(): bool
    {
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([$this->username, $this->email, $this->password, $this->id]);
    }

    public function delete(): bool
    {
        Article::deleteByAuthor($this->id);
        $db = Database::getPDOConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    public static function validatePasswords(string $password, string $confirmPassword): bool
    {
        if ($password !== $confirmPassword) {
            throw new Exception("Les mots de passe ne correspondent pas.");
        }

        return true;
    }

    public static function isAvailable(string $username, string $email, self $currentUser): bool
    {
        if (($username !== $currentUser->username && User::exists($username)) || ($email !== $currentUser->email && User::exists($email))) {
            throw new Exception("Nom d'utilisateur ou e-mail déjà utilisé.");
        }

        return true;
    }
}
