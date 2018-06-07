<?php

function send_mail($login, $mail) {
  $to      = $mail;
  $subject = 'Camagru | Verification';
  $message = '

  Thanks for signing up to Camagru, '.$login.'!
  Your account has been created, but in order to access it, you still have to access it via the following link !

  http://localhost:8080/camagru/index.php?email='.$mail.'&hash='.hash('whirlpool', "little secret").'

  ';

  $headers = 'From:noreply@camagru.com' . "\r\n";
  mail($to, $subject, $message, $headers); // Send the email
}

?>
