<!DOCTYPE html>
<?php require "functions/get_email.php" ?>
<div id="user_infos">
  <div class="option_modify">

    <!-- USERNAME SECTION -->
    <h1>Username</h1>
    <h3>Current Username: <?php echo ($_SESSION['usr_name']); ?> </h3>
    <p>If you wish to change it, please write your new username and confirm with your password:<br>
      <?php include "./functions/change_username.php"; ?>
      <form action="profile.php" method="POST">
        <input type="text" name="new_username" value="" placeholder="New username"></input><br>
        <input type="password" name="password" value="" placeholder="Password"></input><br>
        <input type="submit"></input>
      </form>
    </p>
  </div>
  <div class="option_modify">

    <!-- EMAIL SECTION -->
    <h1>Email</h1>
    <h3>Current Email: <?php echo (ft_get_email($_SESSION['usr_name'])); ?> </h3>
    <p>If you wish to change it, please write your new email adress and confirm with your password:<br>
      <?php include "./functions/change_email.php"; ?>
      <form action="profile.php" method="POST">
        <input type="email" name="new_email" value="" placeholder="New email adress"></input><br>
        <input type="password" name="password" value="" placeholder="Password"></input><br>
        <input type="submit"></input>
      </form>
    </p>
  </div>
  <div class="option_modify">

    <!-- PASSWORD SECTION -->
    <h1>Password</h1>
    <br>
    <p>If you wish to change your password, please enter a new one (two times for security reasons) then confirm with your current one:<br>
      <?php include "./functions/change_password.php"; ?>
      <form action="profile.php" method="POST">
        <input type="password" name="new_password" value="" placeholder="Your new password" pattern="(?=^.{8,15}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$"></input><br>
        <input type="password" name="new_password2" value="" placeholder="One last time..."></input><br>
        <input type="password" name="password" value="" placeholder="Current password"></input></p>
        <input type="submit"></input>
      </form>
  </div>
  <div class="option_modify">

    <!-- PREFERENCES SECTION -->
    <h1>Account Preferences</h1>
    <h3>Current mail notifications status:  </h3>
    <p>If you wish to change it, please check (or uncheck) accordingly the checkbox below:<br><br>
      <?php include "./functions/change_notification.php"; ?>
      <form action="profile.php" method="POST">
        <input type="checkbox" id="check_notif" name="notif"></input>
        <label for="check_notif">Do you wish to receive emails for each comment ?</label></p>
        <input type="submit" name="notif_status"></input>
      </form>
  </div>
</div>
