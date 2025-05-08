<?php

function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function isAdmin(): bool
{
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

function isAuthorOf(string $articleAuthorId): bool
{
    return isLoggedIn() && $_SESSION['user']['id'] === $articleAuthorId;
}

function requireLogin()
{
    if (!isLoggedIn()) {
        redirect('/login');
    }
}

function redirectIfLoggedIn()
{
    if (isLoggedIn()) {
        redirect('articles');
    }
}
