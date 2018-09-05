<!DOCTYPE html>
<?php require "functions/get_email.php" ?>
<div id="user_infos">
  <div class="option_modify">

    <!-- USERNAME SECTION -->
    <strong>Username</strong>
    <em>Current Username: <?php echo ($_SESSION['usr_name']); ?> </em>
    <p>If you wish to change it, please write your new username and confirm with your password:</p>
    <?php include "./functions/change_username.php"; ?>
    <form action="profile.php" method="POST">
      <input type="text" name="new_username" value="" placeholder="New username"></input><br>
      <input type="password" name="password" value="" placeholder="Password"></input><br>
      <input type="submit" value="CHANGE USERNAME"></input>
    </form>
  </div>
  <div class="option_modify">

    <!-- EMAIL SECTION -->
    <strong>Email</strong>
    <em>Current Email: <?php echo (ft_get_email($_SESSION['usr_name'])); ?> </em>
    <p>If you wish to change it, please write your new email adress and confirm with your password:</p>
    <?php include "./functions/change_email.php"; ?>
    <form action="profile.php" method="POST">
      <input type="email" name="new_email" value="" placeholder="New email adress"></input><br>
      <input type="password" name="password" value="" placeholder="Password"></input><br>
      <input type="submit" value="CHANGE EMAIL"></input>
    </form>
  </div>
  <div class="option_modify">

    <!-- PASSWORD SECTION -->
    <strong>Password</strong>
    <p>If you wish to change your password, please enter a new one (two times for security reasons) then confirm with your current one:</p>
      <?php include "./functions/change_password.php"; ?>
      <form action="profile.php" method="POST">
        <input type="password" name="new_password" value="" placeholder="Your new password" pattern="(?=^.{8,15}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$"></input><br>
        <input type="password" name="new_password2" value="" placeholder="One last time..."></input><br>
        <input type="password" name="password" value="" placeholder="Current password"></input><br>
        <input type="submit" value="CHANGE PASSWORD"></input>
      </form>
  </div>
  <div class="option_modify">

    <!-- PREFERENCES SECTION -->
    <strong>Account Preferences</strong>
    <em>Current mail notifications status: </em>
    <p>If you wish to change it, please check (or uncheck) accordingly the checkbox below:</p>
      <?php include "./functions/change_notification.php"; ?>
      <form action="profile.php" method="POST">
        <input type="checkbox" id="check_notif" name="notif"></input>
        <label for="check_notif">Do you wish to receive emails for each comment ?</label>
        <input type="submit" name="notif_status" value="CHANGE NOTIFICATIONS"></input>
      </form>
  </div>
</div>
