<?php

require('config/database.php');

if (isset($_POST['new_username'])) {
    $dbh = new PDO('mysql:host=127.0.0.1', $DB_USER, $DB_PASSWORD);
    $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
    $dbh->exec($sql);

    //TO ADD: Check user inputs

    $username = !empty($_POST['new_username']) ? trim($_POST['new_username']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordHash = hash('whirlpool', $password);

    //Checks if username already taken
    $sql = "SELECT login FROM camagru.users WHERE login = :username"; //STEP 1
    $req = $dbh->prepare($sql); //STEP 2
    $req->bindValue(':username', $username); //STEP 3
    $req->execute(); //STEP 4
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
    $sql = "SELECT login FROM camagru.users WHERE login = :username AND password = :password"; //STEP 1
    $req = $dbh->prepare($sql); //STEP 2
    $req->bindValue(':username', $_SESSION['usr_name']); //STEP 3
    $req->bindValue(':password', $passwordHash);
    $req->execute(); //STEP 4
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
      $sql = "UPDATE camagru.users SET login = :new_username WHERE login = :username"; //STEP 1
      $req = $dbh->prepare($sql); //STEP 2
      $req->bindValue(':username', $_SESSION['usr_name']); //STEP 3
      $req->bindValue(':new_username', $username);
      $req->execute(); //STEP 4
      $_SESSION['usr_name'] = $username;
      header('Location: '.$_SERVER['REQUEST_URI']);
    }
}


?>
