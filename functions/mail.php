<?php

function send_mail_confirmation($login, $mail) {
  $to      = $mail;
  $subject = 'Camagru | Verification';
  $message = '

  Thanks for signing up to Camagru, '.$login.'!
  Your account has been created, but in order to access it, you still have to access it via the following link !

  http://localhost:8080/camagru/index.php?email='.$mail.'&hash='.hash('sha3-512', "little secret").'

  ';
  $headers = 'From: noreply@camagru.com' . "\r\n";
  mail($to, $subject, $message, $headers);
}

function send_mail_notification($login, $mail) {
  $to      = $mail;
  $subject = 'Camagru | New Comment';
  $message = '

  Hey, '.$login.'!
  Someone just commented your picture. Go check it out now on your favourite website !

  http://localhost:8080/camagru/index.php

  ';
  $headers = 'From: noreply@camagru.com' . "\r\n";
  mail($to, $subject, $message, $headers);
}

function send_mail_forgotten($login, $mail, $passhash) {
  $to      = $mail;
  $subject = 'Camagru | Forgotten Password';
  $message = '

  Hey, '.$login.'!
  Looks like you\'ve forgotten your password... But don\'t worry, everything is under control:
  1) Simply click on the link below.

  http://localhost:8080/camagru/index.php?action=reset&email='.$mail.'&hash='.$passhash.'

  2) On the page you\'ll be taken to, you\'ll be able to reset you password so you can access you account again :)

  Yours, sincerely.

  ';
  $headers = 'From: noreply@camagru.com' . "\r\n";
  mail($to, $subject, $message, $headers);
}

?>
