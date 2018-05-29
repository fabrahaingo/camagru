<?php

session_start();
require('../config/database.php');
$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
$dbh->exec($sql);

//TO ADD: Check user inputs

$username = !empty($_POST['new_username']) ? trim($_POST['new_username']) : null;
$password = !empty($_POST['password']) ? trim($_POST['password']) : null;
$passwordHash = hash('sha3-512', $password);

//Checks if username already taken
$sql = "SELECT COUNT(*) AS num FROM camagru.users WHERE login = :username"; //STEP 1
$req = $dbh->prepare($sql); //STEP 2
$req->bindValue(':username', $username); //STEP 3
$req->execute(); //STEP 4

$req = $req->fetch(PDO::FETCH_ASSOC);
if ($req > 0) {
  ?>
  <div>
    This username does already exist, please choose another one
  </div>
  <?php
  // header('Location: ../profile.php');
}

//Checks if right password
$sql = "SELECT COUNT(*) AS num FROM camagru.users WHERE login = :username AND password = :password"; //STEP 1
$req = $dbh->prepare($sql); //STEP 2
$req->bindValue(':username', $_SESSION['usr_name']); //STEP 3
$req->bindValue(':password', $passwordHash);
$req->execute(); //STEP 4

if (!$req) {
  ?>
  <div>
    Wrong password, please try again
  </div>
  <?php
  // header('Location: ../profile.php');
}
else {
  //Updates login if right password is given
  $sql = "UPDATE camagru.users SET login = :new_username WHERE login = :username"; //STEP 1
  $req = $dbh->prepare($sql); //STEP 2
  $req->bindValue(':username', $_SESSION['usr_name']); //STEP 3
  $req->bindValue(':new_username', $username);
  $req->execute(); //STEP 4
  // header('Location: ../profile.php');
}


?>
