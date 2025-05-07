<?php
define('APP_NAME', 'BLOX');

define('DB_DSN', "mysql:host=localhost;dbname=studi_auth_project;charset=utf8");
define('DB_USER', 'studi_auth_project_users');
define('DB_PASS', '1234');

define('BLOG_DB_NAME', 'studi_auth_project_blog');
define('BLOG_DB_DSN', 'mongodb://localhost:27017');

define('VIEW_PATH', dirname(__DIR__) . '/app/views');
define('CONTROLLER_PATH', dirname(__DIR__) . '/app/controllers');
define('MODEL_PATH', dirname(__DIR__) . '/app/models');

define('APP_ENV', 'dev'); // ou 'prod'
define('LOG_PATH', dirname(__DIR__) . '/logs');
