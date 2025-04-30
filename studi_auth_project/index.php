<?php

$dsn = 'mysql:host=localhost;dbname=studi_auth_project;charset=utf8mb4';
$username = 'studi_auth_project_users';
$password = '1234';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM users';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        echo 'ID: ' . $user['id'] . '<br>';
        echo 'Username: ' . $user['username'] . '<br>';
        echo 'Email: ' . $user['email'] . '<br>';
        echo '<hr>';
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
