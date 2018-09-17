<?php

require('config/database.php');

if (isset($_POST['notif_status'])) {
    $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
    $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
    $dbh->exec($sql);

    if ($_POST['notif']) {
      //Updates comment_mail to 1
      $sql = "UPDATE camagru.users SET comment_mail = 1 WHERE login = :username";
      $req = $dbh->prepare($sql);
      $req->bindValue(':username', $_SESSION['usr_name']);
      $req->execute();
    }
    else {
      //Updates comment_mail to 0
      $sql = "UPDATE camagru.users SET comment_mail = 0 WHERE login = :username";
      $req = $dbh->prepare($sql);
      $req->bindValue(':username', $_SESSION['usr_name']);
      $req->execute();
    }
}

?>
