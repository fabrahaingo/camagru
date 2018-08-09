<?php

if (!isset($_SESSION['usr_name'])) {
  header('Location: ../index.php');
}

else if (isset($_POST['send_comment']) && isset($_SESSION['usr_name'])) {
  require('../config/database.php');
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "INSERT INTO camagru.comments (user, picture_id, comment) VALUES (:usr_name, :picture, :comment_content)";
  $req = $dbh->prepare($sql);
  $req->bindValue('usr_name', $_POST['usr_name']);
  $req->bindValue('picture', $_POST['photo_id']);
  $req->bindValue('comment_content', $_POST['comment']);
  $req->execute();
  header('Location: ../index.php');
}

?>
