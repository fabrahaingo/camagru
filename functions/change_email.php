<?php

require('config/database.php');

if (isset($_POST['new_email'])) {
    $dbh = new PDO('mysql:host=127.0.0.1', $DB_USER, $DB_PASSWORD);
    $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
    $dbh->exec($sql);

    //TO ADD: Check user inputs

    $email = !empty($_POST['new_email']) ? trim($_POST['new_email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordHash = hash('whirlpool', $password);

    //Checks if email already used
    $sql = "SELECT login FROM camagru.users WHERE email = :email"; //STEP 1
    $req = $dbh->prepare($sql); //STEP 2
    $req->bindValue(':email', $email); //STEP 3
    $req->execute(); //STEP 4
    $req = $req->fetch(PDO::FETCH_ASSOC);

    if ($req) {
      ?>
      <div class="error_message">
        This email is already in use, please choose another one
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
      $sql = "UPDATE camagru.users SET email = :new_email WHERE login = :username"; //STEP 1
      $req = $dbh->prepare($sql); //STEP 2
      $req->bindValue(':username', $_SESSION['usr_name']); //STEP 3
      $req->bindValue(':new_email', $email);
      $req->execute(); //STEP 4
      header('Location: '.$_SERVER['REQUEST_URI']);
    }
}


?>
