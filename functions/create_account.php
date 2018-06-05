<?php

require ('config/setup.php');
require ('functions/mail.php');

if(isset($_POST['register'])) {

    $login = !empty($_POST['login']) ? trim($_POST['login']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password1 = !empty($_POST['password1']) ? trim($_POST['password1']) : null;
    $password2 = !empty($_POST['password2']) ? trim($_POST['password2']) : null;

    if ($password1 != $password2) {
        ?>
        <div class="error_message">
            <span>The passwords do not match, please try again</span>
        </div>
        <?php
        return;
    }

    //TO ADD: Error checking (username characters, password length...)

    //Check if the login is already taken
    $sql = "SELECT COUNT(*) AS num FROM users WHERE login = :login OR email = :email"; //STEP 1
    $req = $dbh->prepare($sql); //STEP 2
    $req->bindValue(':login', $login); //STEP 3
    $req->bindValue(':email', $email);
    $req->execute(); //STEP 4

    //Gets the number of rows found in order to know if the user exists
    $row = $req->fetch(PDO::FETCH_ASSOC);

    if ($row['num'] > 0) {
        ?>
        <div class="error_message">
            <span>The account exists already, please login</span>
        </div>
        <?php
        return;
    }

    $passwordHash = hash('sha3-512', $password1);

    $sql = "INSERT INTO users (login, email, password) VALUES (:login, :email, :password)"; //STEP 1
    $req = $dbh->prepare($sql); //STEP 2
    $req->bindValue(':login', $login); //STEP 3
    $req->bindValue(':email', $email);
    $req->bindValue(':password', $passwordHash);
    $result = $req->execute(); //STEP 4

    //If execution succeeds
    if($result) {
        send_mail($login, $email);
        ?>
        <div class="error_message success_message">
            <span>The account has been created, welcome ! 🤗</span>
        </div>
        <?php
    }
    else {
        ?>
        <div class="error_message">
            <span>The account couldn't be created 😞</span>
        </div>
        <?php
    }
}
?>
