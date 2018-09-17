<?php

require ('config/setup.php');
require_once ('functions/secure_password.php');

// ACCOUNT ACTIVATION

if (isset($_GET['email']) && isset($_GET['hash'])) {
  if ($_GET['hash'] == hash('sha3-512', "little".$_GET['email']."secret")) {
    $sql = "SELECT activated FROM users WHERE email = :email";
    $req = $dbh->prepare($sql);
    $req->bindValue(':email', $_GET['email']);
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);

    // If account was already activated
    if (implode($req) == 1) { ?>
      <div class="error_message">
          <span>This account was already activated, you can log in :)</span>
      </div>
      <?php return;
    }

    // If link is correct & account not activated so far
    else if (implode($req) == 0) {
      $sql = "UPDATE users SET activated = 1 WHERE email = :email";
      $req = $dbh->prepare($sql);
      $req->bindValue(':email', $_GET['email']);
      $req->execute();
      $req = $req->fetch(PDO::FETCH_ASSOC); ?>
      <div class="error_message success_message">
          <span>Your account has now been activated, enjoy your visit !</span>
      </div>
      <?php return;
    }

    // If a user tries to activate account in an improper manner
    else { ?>
      <div class="error_message">
          <span>Woops, it seems like there is an error in the link you have provided, please try again</span>
      </div>
      <?php return;
    }
  }
}

// PASSWORD RESET

if (isset($_GET['action']) && $_GET['action'] == "reset") {
  if (isset($_GET['email']) && isset($_GET['hash'])) {
    $sql = "SELECT password FROM users WHERE email = :email";
    $req = $dbh->prepare($sql);
    $req->bindValue(':email', $_GET['email']);
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);
    $password = implode($req);

  // If both the password and the hash are not empty
    if ($_GET['hash'] && $password == $_GET['hash']) {
      if (!isset($_POST['password1']) || !isset($_POST['password2'])) { ?>
        <div class="error_message success_message">
          <span>You can now choose a new password. Simply write it in the two following inputs</span>
        </div>
        <?php return;
      }
      // If the 2 passwords provided do not match
      else {
        if ($_POST['password1'] != $_POST['password2']) { ?>
          <div class="error_message">
            <span>The passwords you provided do not match. Try again</span>
          </div>
          <?php return;
        }
        // If the 2 passwords match
        else {
          // If the password is not safe enough
          if (secure_password($_POST['password1']) === FALSE) { ?>
            <div class="error_message">
              <span>The password is not safe enough: it must contain at least 1 capital letter, 1 digit and between 8 and 20 characters</span>
            </div>
            <?php return;
          }
          // If the password is safe enough
          else {
            $sql = "UPDATE users SET password = :new_password WHERE email = :usr_email";
            $req = $dbh->prepare($sql);
            $req->bindValue(':new_password', hash('sha3-512', $_POST['password1']));
            $req->bindValue(':usr_email', $_GET['email']);
            $req->execute();
            ?>
            <div class="error_message success_message">
              <span>Your password was changed successfully, you may now <a href="index.php">log in</a></span>
            </div>
            <?php return;
          }
        }
      }
    }

    // If a wrong hash or adress is provided in the link
    else { ?>
      <div class="error_message">
        <span>Woops, it seems like there is an error in the link you have provided, please try again</span>
      </div>
      <?php return;
    }
  }

  // If someone tries to access reset link in a unproper manner
  else { ?>
    <div class="error_message">
      <span>Woops, it seems like there is an error in the link you have provided, please try again</span>
    </div>
    <?php return;
  }
}

// CONNECT TO THE ACCOUNT

if (isset($_POST['connect'])) {
  $login_or_mail = !empty($_POST['login']) ? trim($_POST['login']) : null;
  $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

  //Creates to password hash to compare with login/email
  $passwordHash = hash('sha3-512', $password);

  //Check if login or email exists
  $sql = "SELECT login FROM users WHERE login = :login_or_mail AND
  password = :passwordHash OR email = :login_or_mail AND password = :passwordHash";
  $req = $dbh->prepare($sql);
  $req->bindValue(':login_or_mail', $login_or_mail);
  $req->bindValue(':passwordHash', $passwordHash);
  $req->execute();

  //Gets the number of rows found in order to know if the user exists
  $req = $req->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT activated FROM users WHERE login = :login_or_mail AND
  password = :passwordHash OR email = :login_or_mail AND password = :passwordHash";
  $act = $dbh->prepare($sql);
  $act->bindValue(':login_or_mail', $login_or_mail);
  $act->bindValue(':passwordHash', $passwordHash);
  $act->execute();
  $act = $act->fetch(PDO::FETCH_ASSOC);

  if (!$act) { ?>
    <div class="error_message">
      <span>The user doesn't exist or the credentials are not well spelled</span>
    </div>
    <?php return;
  }
  else if (implode($act) == 0) { ?>
    <div class="error_message">
      <span>Your account hasn't been activated yet, please click on the link you received via email</span>
    </div>
      <?php return;
  }
  else {
    //Fills the SESSION variable to be used to know which user is logged in
    $_SESSION['usr_name'] = implode('', $req); ?>
    <div class="error_message success_message">
      <span>Login successfull</span>
    </div>
    <!-- If right credentials entered, then redirects to user home space -->
    <?php header('Location: home.php');
  }
}

// FORGOTTEN PASSWORD

if (isset($_POST['send_link_password'])) {
  $sql = "SELECT login FROM users WHERE email = :provided_email";
  $req = $dbh->prepare($sql);
  $req->bindValue(':provided_email', $_POST['email']);
  $req->execute();
  $req = $req->fetch(PDO::FETCH_ASSOC);
  if ($req)
    $login = implode($req);

  // If a user registered before with this email
  if (isset($login)) {
    // Gets the users current password hash to send to the mail function
    $sql = "SELECT password FROM users WHERE email = :provided_email";
    $req = $dbh->prepare($sql);
    $req->bindValue(':provided_email', $_POST['email']);
    $req->execute();
    $req = $req->fetch(PDO::FETCH_ASSOC);
    $passhash = implode($req);

    // Sends the mail to the concerned user
    send_mail_forgotten($login, $_POST['email'], $passhash); ?>

    <!-- Displays a text to say the mail was sent -->
    <div class="error_message success_message">
      <span>A reset link for you password was sent to you account</span>
    </div>
  <?php }

  // If no user has this email
  else { ?>
    <div class="error_message">
      <span>No user with this enail was registered before</span>
    </div>
  <?php }
}
?>
