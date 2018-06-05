<?php

require('config/database.php');

if (isset($_POST['new_password'])) {
    $dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
    $dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
    $dbh->exec($sql);

    //TO ADD: Check user inputs

    $new_password = !empty($_POST['new_password']) ? trim($_POST['new_password']) : null;
    $new_password2 = !empty($_POST['new_password2']) ? trim($_POST['new_password2']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordHash = hash('sha3-512', $password);
    $new_passwordHash = hash('sha3-512', $new_password);

    if ($new_password !== $new_password2) {
      ?>
      <div class="error_message">
        Please enter the same password 2 times
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
      $sql = "UPDATE camagru.users SET password = :new_password WHERE login = :username"; //STEP 1
      $req = $dbh->prepare($sql); //STEP 2
      $req->bindValue(':username', $_SESSION['usr_name']); //STEP 3
      $req->bindValue(':new_password', $new_passwordHash);
      $req->execute(); //STEP 4
      header('Location: '.$_SERVER['REQUEST_URI']);
    }
}


?>
