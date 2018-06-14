<?php

if (isset($_POST['liked'])) {
  require('../config/database.php');
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "SELECT user FROM camagru.likes WHERE user = :usr_name AND picture_id = :picture";
  $req = $dbh->prepare($sql);
  $req->bindValue('usr_name', $_POST['usr_name']);
  $req->bindValue('picture', $_POST['photo_id']);
  $req->execute();
  $req = $req->fetch(PDO::FETCH_ASSOC);
  if ($req != 0) {
    header('Location: ../index.php');
    return;
  }
  else {
    $sql = "INSERT INTO camagru.likes (user, picture_id) VALUES (:usr_name, :picture)";
    $req = $dbh->prepare($sql);
    $req->bindValue('usr_name', $_POST['usr_name']);
    $req->bindValue('picture', $_POST['photo_id']);
    $req->execute();
    header('Location: ../index.php');
  }
}

if (isset($_POST['unliked'])) {
  require('../config/database.php');
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "SELECT user FROM camagru.likes WHERE user = :usr_name AND picture_id = :picture";
  $req = $dbh->prepare($sql);
  $req->bindValue('usr_name', $_POST['usr_name']);
  $req->bindValue('picture', $_POST['photo_id']);
  $req->execute();
  $req = $req->fetch(PDO::FETCH_ASSOC);
  if ($req === 1) {
    header('Location: ../index.php');
    return;
  }
  else {
    $sql = "DELETE FROM camagru.likes WHERE user = :usr_name AND picture_id = :picture LIMIT 1";
    $req = $dbh->prepare($sql);
    $req->bindValue('usr_name', $_POST['usr_name']);
    $req->bindValue('picture', $_POST['photo_id']);
    $req->execute();
    header('Location: ../index.php');
  }
}

?>
