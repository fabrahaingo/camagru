<?php

function display_likes($picture_id) {
  require('config/database.php');
  $con = mysqli_connect("localhost","root","coucou","camagru");
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "SELECT COUNT(*) AS num FROM camagru.likes WHERE picture_id = :nr_pic";
  $req = $dbh->prepare($sql);
  $req->bindValue(':nr_pic', strip_tags(mysqli_real_escape_string($con, $picture_id)));
  $req->execute();
  $req = $req->fetch(PDO::FETCH_ASSOC);
  echo $req['num'];
}

if (isset($_POST['like']) || isset($_POST['unlike'])) {
  require('../config/database.php');
  $con = mysqli_connect("localhost","root","coucou","camagru");
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);
echo "Coucou";
  if (isset($_POST['like'])) {
    $sql = "SELECT COUNT(*) AS already_liked FROM camagru.likes WHERE user = :usr_name AND picture_id = :picture_id";
    $req = $dbh->prepare($sql);
    $req->bindValue(':usr_name', strip_tags(mysqli_real_escape_string($con, $_POST['usr_name'])));
    $req->bindValue('picture_id', mysqli_real_escape_string($con, $_POST['picture_id']));
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);
    if ($req['already_liked']) {
      header('Location: ../index.php');
    }
    else {
      $sql = "INSERT INTO camagru.likes (user, picture_id) VALUES (:usr_name, :picture_id)";
      $req = $dbh->prepare($sql);
      $req->bindValue('usr_name', strip_tags(mysqli_real_escape_string($con, $_POST['usr_name'])));
      $req->bindValue('picture_id', mysqli_real_escape_string($con, $_POST['picture_id']));
      $req->execute();
      header('Location: ../index.php');
    }
  }
  if (isset($_POST['unlike'])) {
    $sql = "SELECT COUNT(*) AS already_liked FROM camagru.likes WHERE user = :usr_name";
    $req = $dbh->prepare($sql);
    $req->bindValue(':usr_name', strip_tags(mysqli_real_escape_string($con, $_POST['usr_name'])));
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);
    if (!$req['already_liked']) {
      header('Location: ../index.php');
    }
    else {
      $sql = "DELETE FROM camagru.likes WHERE user = :usr_name AND picture_id = :picture_id LIMIT 1";
      $req = $dbh->prepare($sql);
      $req->bindValue('usr_name', strip_tags(mysqli_real_escape_string($con, $_POST['usr_name'])));
      $req->bindValue('picture_id', mysqli_real_escape_string($con, $_POST['picture_id']));
      $req->execute();
      header('Location: ../index.php');
    }
  }
}

?>
