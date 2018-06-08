<?php

require ('config/setup.php');

if (isset($_GET['email']) && isset($_GET['hash']))
{
	if ($_GET['hash'] == hash('whirlpool', 'lasjfdkjshf'))
	{
		$sql = "SELECT activated FROM users WHERE email = :email"; //STEP 1
		$act = $dbh->prepare($sql); //STEP 2
		$act->bindValue(':email', $_GET['email']); //STEP 3
		$act->execute(); //STEP 4
		$act = $act->fetch(PDO::FETCH_ASSOC);
		if (implode($act) == 1)
		{
?>
			<div class="error_message">
			  <span>This account was already activated, you can log in :)</span>
			</div>
<?php
			return;
		}
		else if (implode($act) == 0)
		{
			$sql = "UPDATE users SET activated = 1 WHERE email = :email"; //STEP 1
			$act = $dbh->prepare($sql); //STEP 2
			$act->bindValue(':email', $_GET['email']); //STEP 3
			$act->execute(); //STEP 4
			$act = $act->fetch(PDO::FETCH_ASSOC);
?>
			<div class="error_message success_message">
			  <span>Your account has now been activated, enjoy your visit !</span>
			</div>
<?php
			return;
		}
		else
		{
?>
			<div class="error_message">
			  <span>Woops, it seems like there is an error in the link you have provided, please try again</span>
			</div>
<?php
		return;
		}
	}
}

if (isset($_POST['connect']))
{
	$login_or_mail = !empty($_POST['login']) ? trim($_POST['login']) : null;
	$password = !empty($_POST['password']) ? trim($_POST['password']) : null;

    //Creates to password hash to compare with login/email
	$passwordHash = hash('whirlpool', $password);

    //Check if the login or email exists
	$sql = "SELECT login FROM users WHERE login = :login_or_mail AND password = :passwordHash OR email = :login_or_mail AND password = :passwordHash"; //STEP 1
	$req = $dbh->prepare($sql); //STEP 2
	$req->bindValue(':login_or_mail', $login_or_mail); //STEP 3
	$req->bindValue(':passwordHash', $passwordHash);
	$req->execute(); //STEP 4

    //Gets the number of rows found in order to know if the user exists
	$req = $req->fetch(PDO::FETCH_ASSOC);
	$sql = "SELECT activated FROM users WHERE login = :login_or_mail AND password = :passwordHash OR email = :login_or_mail AND password = :passwordHash"; //STEP 1
	$act = $dbh->prepare($sql); //STEP 2
	$act->bindValue(':login_or_mail', $login_or_mail); //STEP 3
	$act->bindValue(':passwordHash', $passwordHash);
	$act->execute(); //STEP 4
	$act = $act->fetch(PDO::FETCH_ASSOC);

	if (!$req)
	{
?>
		<div class="error_message">
		  <span>Incorrect username or password</span>
		</div>
<?php
		return;
    }
	else if (!implode($act))
	{
?>
		<div class="error_message">
		  <span>Your account hasn't been activated yet, please click on the link you received via email</span>
		</div>
<?php
		return;
	}
	else
	{

      //Fills the SESSION variable to be used to know which user is logged in
		$_SESSION['usr_name'] = implode('', $req);
?>
		<div class="error_message success_message">
		  <span>Login successful</span>
		</div>
<?php
      //If right credentials entered, then redirects to user home space
//		if (!headers_sent())
//			header('Location: home.php');
		echo '<script type="text/javascript">location.replace("home.php");</script>';
		exit();
	}
}
?>
