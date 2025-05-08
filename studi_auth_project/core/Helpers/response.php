<?php

function redirect(string $url)
{
    header("Location:" . BASE_URL . $url);
    exit;
}

function displayError(string $message)
{
    echo "<div class='text-danger'>$message</div>";
}

function displaySuccess(string $message)
{
    echo "<div class='text-success'>$message</div>";
}

function setResponseMessage(string $type, string $message): void
{
    $_SESSION[$type] = $message;
}

function displayResponse()
{
    if (isset($_SESSION['error'])) {
        displayError($_SESSION['error']);
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        displaySuccess($_SESSION['success']);
        unset($_SESSION['success']);
    }
}
