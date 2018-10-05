<?php

function ft_get_email($login) {
  require('config/database.php');
  $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "SELECT email FROM camagru.users WHERE login = :login";
  $req = $dbh->prepare($sql);
  $req->bindValue(':login', $login);
  $req->execute();

  $email = $req->fetch(PDO::FETCH_ASSOC);
  return implode($email);
}

?>
