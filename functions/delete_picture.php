<?php

require('../config/database.php');

$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
$dbh->exec($sql);

function delete_likes($dbh, $picture_id) {
  $sql = "DELETE FROM camagru.likes WHERE picture_id = :picture_id";
  $req = $dbh->prepare($sql);
  $req->bindValue('picture_id', $picture_id);
  $req->execute();
}

function delete_comments($dbh, $picture_id) {
  $sql = "DELETE FROM camagru.comments WHERE picture_id = :picture_id";
  $req = $dbh->prepare($sql);
  $req->bindValue('picture_id', $picture_id);
  $req->execute();
}

function delete_picture($dbh, $picture_id) {
  $sql = "DELETE FROM camagru.pictures WHERE picture_id = :picture_id";
  $req = $dbh->prepare($sql);
  $req->bindValue('picture_id', $picture_id);
  $req->execute();
}

delete_likes($dbh, $_POST['picture_id']);
delete_comments($dbh, $_POST['picture_id']);
delete_picture($dbh, $_POST['picture_id']);
unlink( "../img/" . $_POST['picture_id'] );
header('Location: ../new_pic.php');
return;

?>
