<?php

require ('config/database.php');
require_once ('functions/secure_password.php');

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

    if ($new_password !== $new_password2) { ?>
      <div class="error_message">
        Please enter the same password 2 times
      </div>
      <?php return;
    }

    //Checks if right password
    $sql = "SELECT login FROM camagru.users WHERE login = :username AND password = :password";
    $req = $dbh->prepare($sql);
    $req->bindValue(':username', $_SESSION['usr_name']);
    $req->bindValue(':password', $passwordHash);
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);

    if (!$req) { ?>
      <div class="error_message">
        Wrong password, please try again
      </div>
      <?php return;
    }
    else if (!secure_password($new_password)) { ?>
      <div class="error_message">
        The new password is not safe enough: it must contain at least 1 capital letter, 1 digit and between 8 and 20 characters
      </div>
      <?php return;
    }
    else {
      echo ($req);
      //Updates login if right password is given
      $sql = "UPDATE camagru.users SET password = :new_password WHERE login = :username";
      $req = $dbh->prepare($sql);
      $req->bindValue(':username', $_SESSION['usr_name']);
      $req->bindValue(':new_password', $new_passwordHash);
      $req->execute();
      header('Location: '.$_SERVER['REQUEST_URI']);
    }
}


?>
