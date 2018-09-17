<?php

require('config/database.php');

if (isset($_POST['new_username'])) {
    $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
    $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
    $dbh->exec($sql);

    //TO ADD: Check user inputs

    $username = !empty($_POST['new_username']) ? strip_tags(trim($_POST['new_username'])) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordHash = hash('sha3-512', $password);

    //Checks if username already taken
    $sql = "SELECT login FROM camagru.users WHERE login = :username";
    $req = $dbh->prepare($sql);
    $req->bindValue(':username', $username);
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);

    if ($req) {
      ?>
      <div class="error_message">
        This username does already exist, please choose another one
      </div>
      <?php
      return;
    }

    //Checks if right password
    $sql = "SELECT login FROM camagru.users WHERE login = :username AND password = :password";
    $req = $dbh->prepare($sql);
    $req->bindValue(':username', $_SESSION['usr_name']);
    $req->bindValue(':password', $passwordHash);
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);

    if (!$req) {
      ?>
      <div class="error_message">
        Wrong password, please try again
      </div>
      <?php
      return;
    }
    else {
      echo ($req);
      //Updates login if right password is given
      $sql = "UPDATE camagru.users SET login = :new_username WHERE login = :username";
      $req = $dbh->prepare($sql);
      $req->bindValue(':username', $_SESSION['usr_name']);
      $req->bindValue(':new_username', $username);
      $req->execute();
      $_SESSION['usr_name'] = $username;
      header('Location: '.$_SERVER['REQUEST_URI']);
    }
}


?>
