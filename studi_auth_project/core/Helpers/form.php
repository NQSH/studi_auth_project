<?php

function old(string $key, $default = ''): string
{
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : $default;
}

function generate_csrf_token(): void
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    echo "<input type='hidden' name='csrf_token' value=" . $_SESSION['csrf_token'] . ">";
}

function check_csrf_token(): void
{
    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        render('error', 'Erreur', ['error' => 'Token CSRF invalide.']);
        exit;
    }
}
