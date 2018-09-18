<?php

function display_comments($picture_id) {
  require('config/database.php');
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "SELECT * FROM camagru.comments WHERE picture_id = :picture ORDER BY id DESC";
  $req = $dbh->prepare($sql);
  $req->bindValue('picture', strip_tags($picture_id));
  $req->execute();
  while ($result = $req->fetch(PDO::FETCH_ASSOC)) {
    echo "<div>";
      echo "<span style=\"text-decoration: underline; font-weight: 500;\">";
        echo strip_tags($result['user']);
        echo " on the ";
        echo $result['creation_date'];
      echo " :</span>";
      echo "<br>";
      echo "<span>";
        echo strip_tags($result['comment']);
      echo "</span>";
    echo "</div>";
  }
  return;
}

if (isset($_POST['sent_comment']) && trim($_POST['new_comment']) === "") {
  header('Location: ../index.php');
  return;
}

if (isset($_POST['sent_comment']) && isset($_POST['usr_name'])) {
  require('../config/database.php');
  require('mail.php');
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "INSERT INTO camagru.comments (user, picture_id, comment) VALUES (:usr_name, :picture_id, :new_comment)";
  $req = $dbh->prepare($sql);
  $req->bindValue('usr_name', strip_tags($_POST['usr_name']));
  $req->bindValue('picture_id', $_POST['picture_id']);
  $req->bindValue('new_comment', strip_tags($_POST['new_comment']));
  $req->execute();

  // STEP 1 : get user to which belongs the picture
  $sql = "SELECT user FROM camagru.pictures WHERE picture_id = :picture_id";
  $req = $dbh->prepare($sql);
  $req->bindValue(':picture_id', $_POST['picture_id']);
  $req->execute();
  $req = $req->fetch(PDO::FETCH_ASSOC);
  $login = implode($req);

  // STEP 2 : get 'comment_mail' value of user
  $sql = "SELECT comment_mail FROM camagru.users WHERE login = :user";
  $req = $dbh->prepare($sql);
  $req->bindValue(':user', strip_tags($_POST['usr_name']));
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
