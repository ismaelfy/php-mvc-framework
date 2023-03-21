<?php
// config.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'whatsapp');
define('DB_USER', 'root');
define('DB_PASS', '');

function connect()
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
