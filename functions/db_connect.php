<?php
define('DB_USER', 'root');
define('DB_PASSWORD', 'password');
define('DB_HOST', '127.0.0.1');
define('DB_DATABASE', 'db_camagru');

$pdoOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);
try
{
	$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE,
    DB_USER,
	  DB_PASSWORD,
	$pdoOptions);
}
catch (PDOException $e)
{
	echo "Error: ".$e->getMessage();
}
?>
