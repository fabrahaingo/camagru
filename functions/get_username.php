<?php

function ft_get_username($user_id, $dbh) {
  $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $dbh->exec($sql);

  $sql = "SELECT login FROM camagru.users WHERE id = :user_id";
  $req = $dbh->prepare($sql);
  $req->bindValue(':user_id', $user_id);
  $req->execute();

  $username = $req->fetch(PDO::FETCH_ASSOC);
  return implode($username);
}

?>
