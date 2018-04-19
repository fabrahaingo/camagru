<?php

session_start();
require 'db_connect.php';

if(isset($_POST['register'])){

    $login = !empty($_POST['login']) ? trim($_POST['login']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password1 = !empty($_POST['password1']) ? trim($_POST['password1']) : null;
    $password2 = !empty($_POST['password2']) ? trim($_POST['password2']) : null;

    if ($password1 != $password2) {
        die('Les mots de passe renseignés ne sont pas les mêmes.')
    }
    //TO ADD: Error checking (username characters, password length...)

    $sql = "SELECT COUNT(login, email) AS num FROM user_accounts WHERE login = :login OR email = :email"; //STEP 1
    $stmt = $pdo->prepare($sql); //STEP 2
    $stmt->bindValue(':login', $login); //STEP 3
    $stmt->bindValue(':email', $email);
    $stmt->execute(); //STEP 4

    //Gets the number of rows found in order to know if the user exists
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //TO ADD - Handling method of this error
    if($row['num'] > 0){
        die('Cet identifiant/email existe déjà !');
    }

    $passwordHash = hash('sha3-512', $password1);

    $sql = "INSERT INTO user_accounts (login, email, password) VALUES (:username, :email, :password)"; //STEP 1
    $stmt = $pdo->prepare($sql); //STEP 2
    $stmt->bindValue(':username', $username); //STEP 3
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
    $result = $stmt->execute(); //STEP 4

    //If execution succeeds
    if($result){
        echo 'Votre compte a été enregistré, bienvenue parmi nous !';
    }
    else {
        die('Le compte n\'a pas pu être créé.');
    }

}

?>
