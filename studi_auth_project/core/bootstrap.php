<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Router.php';

foreach (glob(__DIR__ . "/Helpers/*.php") as $helperFile) {
    require_once $helperFile;
}

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'on') {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

secureSessionStart();

require_once __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(function ($class) {
    $paths = [
        '../app/models/',
        '../app/controllers/',
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

error_reporting(E_ALL);
ini_set('display_errors', APP_ENV === 'dev' ? '1' : '0');

set_error_handler('handlePhpError');
set_exception_handler('handleException');

function handlePhpError(int $errno, string $errstr, string $errfile, int $errline): void
{
    $message = "[PHP Error] $errstr in $errfile on line $errline";

    error_log_to_file('php_errors.log', $message);

    if (APP_ENV === 'dev') {
        echo "<pre>$message</pre>";
    }
}

function handleException(Throwable $e): void
{
    $message = "[Exception] " . $e->getMessage() . ' in ' .
        $e->getFile() . ' on line ' . $e->getLine();

    error_log_to_file('exceptions.log', $message);

    if (APP_ENV === 'dev') {
        echo "<pre>$message\n" . $e->getTraceAsString() . "</pre>";
    } else {
        renderError(null);
    }
}
