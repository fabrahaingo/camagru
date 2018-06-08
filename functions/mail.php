<?php
function send_mail($login, $mail)
{
	$to = $mail;
	$subject = 'Confirm your Camagru accout, '.$login;
	$message = '

    '.$login.',

    To access your account, just follow to link below:

    http://localhost:8080/index.php?email='.$mail.'&hash='.hash('whirlpool', 'lasjfdkjshf');
	$headers = 'From:noreply@camagru.com' . "\r\n";
	mail($to, $subject, $message, $headers); // Send the email
}
?>
