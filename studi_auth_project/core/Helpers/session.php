<?php

function secureSessionStart()
{
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    ini_set('session.use_only_cookies', 1);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id(true);
        $_SESSION['initiated'] = true;
    }
}

function destroySession()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }
}
