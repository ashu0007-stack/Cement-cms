<?php
declare(strict_types=1);

define('APP_NAME', 'CemCore Industries');
define('BASE_URL', 'http://localhost:8000');
define('DB_HOST', 'ls-61d590314b90cb93b6085521388172c0d5ab44f5.cr46cq0m4spt.ap-south-1.rds.amazonaws.com');
define('DB_NAME', 'cement_cms');
define('DB_USER', 'dbmasteruser');
define('DB_PASS', 'Deltaforce_44');
define('UPLOAD_DIR', dirname(__DIR__) . '/public/uploads/');
define('UPLOAD_URL', BASE_URL . '/public/uploads/');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
    ]);
}

