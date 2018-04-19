<?php
define('DB_USER', 'root');
define('DB_PASSWORD', 'coucou');
define('DB_HOST', 'localhost');
define('DB_DATABASE', 'db_camagru');

$pdoOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);
$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE,
    DB_USER,
    DB_PASSWORD,
    $pdoOptions
);
?>
