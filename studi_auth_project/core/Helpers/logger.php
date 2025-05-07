<?php

function log_db_error(Exception $e): void
{
    $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
    $message .= $e->getFile() . ':' . $e->getLine() . "\n";
    file_put_contents(__DIR__ . '/../../logs/db_errors.log', $message, FILE_APPEND);
}

function error_log_to_file(string $file, string $message): void
{
    $fullMessage = '[' . date('Y-m-d H:i:s') . "] $message\n";
    file_put_contents(LOG_PATH . "/$file", $fullMessage, FILE_APPEND);
}
