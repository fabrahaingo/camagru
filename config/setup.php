<?php

// IMPORTING DATABASE INFOS
require ('database.php');

// DATABASE INITIALIZATION
try {
	$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
	$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
	$dbh->exec($sql);
}
catch (PDOexception $e) {
	echo "Connection failed: " . $e->getMessage();
}

// CLEANING ANY REMANING DATABASES
$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$sql = 'DROP TABLE IF EXISTS ’users’, ’activation’, ’comments’, ’likes’, ’pictures’';
$req = $dbh->prepare($sql);
$sql = $req->execute();

// CREATION OF USERS TABLE
$sql = "CREATE TABLE IF NOT EXISTS users (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`login` varchar(50) NOT NULL,
	`email` varchar(254) NOT NULL,
	`password` varchar(128) NOT NULL,
	`activated` int(11) NOT NULL DEFAULT 0,
	`comment_mail` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$req = $dbh->prepare($sql);
$sql = $req->execute();

// CREATION OF COMMENTS TABLE
$sql = "CREATE TABLE IF NOT EXISTS comments (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user` varchar(50) NOT NULL,
	`picture_id` varchar(50) NOT NULL,
	`comment` text NOT NULL,
	`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$req = $dbh->prepare($sql);
$sql = $req->execute();

// CREATION OF LIKES TABLE
$sql = "CREATE TABLE IF NOT EXISTS likes (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user` varchar(50) NOT NULL,
	`picture_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$req = $dbh->prepare($sql);
$sql = $req->execute();

// CREATION OF PICTURES TABLE
$sql = "CREATE TABLE IF NOT EXISTS pictures (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user` varchar(50) NOT NULL,
	`picture_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$req = $dbh->prepare($sql);
$sql = $req->execute();
