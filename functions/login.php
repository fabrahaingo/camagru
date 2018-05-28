<?php

session_start();
require ('config/setup.php');

if (isset($_POST['connect'])) {
    $login_or_mail = !empty($_POST['login']) ? trim($_POST['login']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

    //Creates to password hash to compare with login/email
    $passwordHash = hash('sha3-512', $password);

    //Check if the login or email exists
    $sql = "SELECT COUNT(*) AS num FROM users WHERE login = :login_or_mail AND password = :passwordHash OR email = :login_or_mail AND password = :passwordHash"; //STEP 1
    $req = $dbh->prepare($sql); //STEP 2
    $req->bindValue(':login_or_mail', $login_or_mail); //STEP 3
    $req->bindValue(':passwordHash', $passwordHash);
    $req->execute(); //STEP 4

    //Gets the number of rows found in order to know if the user exists
    $row = $req->fetch(PDO::FETCH_ASSOC);

    if (!$row['num']) {
      ?>
      <div class="error_message">
          <span>The user doesn't exist or the credentials are not well spelled</span>
        </div>
        <?php
        return;
    }
    else {
      //Fills the SESSION variable to be used to know which user is logged in
      $_SESSION['usr_name'] = $login_or_mail;
      ?>
      <div class="error_message success_message">
        <span>Login successfull</span>
      </div>
      <?php
      //If right credentials entered, then redirects to user home space
      header('Location: home.php');
    }
}
?>
