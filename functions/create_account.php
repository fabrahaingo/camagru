<?php

require ('config/setup.php');
require ('functions/mail.php');
require_once ('functions/secure_password.php');

if(isset($_POST['register'])) {

    $login = !empty($_POST['login']) ? strip_tags(trim($_POST['login'])) : null;
    $email = !empty($_POST['email']) ? strip_tags(trim($_POST['email'])) : null;
    $password1 = !empty($_POST['password1']) ? trim($_POST['password1']) : null;
    $password2 = !empty($_POST['password2']) ? trim($_POST['password2']) : null;

    if ($password1 != $password2) { ?>
      <div class="error_message">
        <span>The passwords do not match, please try again</span>
      </div>
      <?php return;
    }

    // Check if login is already taken
    $sql = "SELECT COUNT(*) AS num FROM users WHERE login = :login OR email = :email";
    $req = $dbh->prepare($sql);
    $req->bindValue(':login', $login);
    $req->bindValue(':email', $email);
    $req->execute();

    // Gets the number of rows found in order to know if the user exists
    $row = $req->fetch(PDO::FETCH_ASSOC);

    if ($row['num'] > 0) { ?>
      <div class="error_message">
        <span>The account exists already, please login</span>
      </div>
      <?php return;
    }

    if (!secure_password($password1)) { ?>
      <div class="error_message">
        <span>The password is not safe enough: it must contain at least 1 capital letter, 1 digit and between 8 and 20 characters</span>
      </div>
      <?php return;
    }

    $passwordHash = hash('sha3-512', $password1);

    $sql = "INSERT INTO users (login, email, password) VALUES (:login, :email, :password)";
    $req = $dbh->prepare($sql);
    $req->bindValue(':login', $login);
    $req->bindValue(':email', $email);
    $req->bindValue(':password', $passwordHash);
    $result = $req->execute();

    // If execution succeeds
    if($result) {
      send_mail_confirmation($login, $email); ?>
      <div class="error_message success_message">
        <span>The account has been created, welcome ! 🤗</span>
      </div>
    <?php }
    else { ?>
      <div class="error_message">
        <span>The account couldn't be created 😞</span>
      </div>
    <?php }
  }
?>
