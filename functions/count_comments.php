<?php

require ('mail.php');
$con = mysqli_connect("localhost","root","coucou","camagru");

// if no user is connected, doesn't do anything
if (!isset($_POST['usr_name']) || $_POST['usr_name'] == "") {
  header('Location: ../index.php');
}

else if (isset($_POST['send_comment']) && isset($_POST['usr_name'])) {
  require('../config/database.php');
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "INSERT INTO camagru.comments (user, picture_id, comment) VALUES (:usr_name, :picture, :comment_content)";
  $req = $dbh->prepare($sql);
  $req->bindValue('usr_name', strip_tags(mysqli_real_escape_string($con, $_POST['usr_name'])));
  $req->bindValue('picture', mysqli_real_escape_string($con, $_POST['photo_id']));
  $req->bindValue('comment_content', strip_tags(mysqli_real_escape_string($con, $_POST['comment'])));
  $req->execute();

  // STEP 1 : get user to which belongs the picture
  $sql = "SELECT user FROM camagru.pictures WHERE picture_id = :pic";
  $req = $dbh->prepare($sql);
  $req->bindValue(':pic', mysqli_real_escape_string($con, $_POST['photo_id']));
  $req->execute();
  $req = $req->fetch(PDO::FETCH_ASSOC);
  $login = implode($req);

  // STEP 2 : get 'comment_mail' value of user
  $sql = "SELECT comment_mail FROM camagru.users WHERE login = :user";
  $req = $dbh->prepare($sql);
  $req->bindValue(':user', strip_tags(mysqli_real_escape_string($con, $_POST['usr_name'])));
  $req->execute();
  $req = $req->fetch(PDO::FETCH_ASSOC);
  $comment_mail = implode($req);

  if ($comment_mail == 1 && $login != $_POST['usr_name']) {
    // STEP 3 : get email of user
    $sql = "SELECT email FROM camagru.users WHERE login = :user";
    $req = $dbh->prepare($sql);
    $req->bindValue(':user', $login);
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);
    $mail = implode($req);

    // STEP 4 : sent email
    send_mail_notification($login, $mail);
  }

  header('Location: ../index.php');
}

?>
