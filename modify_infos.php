<!DOCTYPE html>
<?php require "functions/get_email.php" ?>
<div id="user_infos">
  <div>
    <h1>Username</h1>
    <h3>Current Username: <?php echo ($_SESSION['usr_name']); ?> </h3>
    <p>If you wish to change it, please write your new username and confirm with your password:<br>
      <form action="functions/change_username.php" method="POST">
        <input type="text" name="new_username" value="" placeholder="New username"></input><br>
        <input type="password" name="password" value="" placeholder="Password"></input>
        <input type="submit"></input>
      </form>
    </p>
  </div>
  <div>
    <h1>Email</h1>
    <h3>Current Email: <?php echo (ft_get_email($_SESSION['usr_name'])); ?> </h3>
    <p>If you wish to change it, please write your new email adress and confirm with your password:<br>
      <form action="change_username.php" method="POST">
        <input type="text" value="" placeholder="New email adress"></input><br>
        <input type="password" value="" placeholder="Password"></input>
      </form>
    </p>
  </div>
  <div>
    <h1>Password</h1>
    <br>
    <p>If you wish to change your password, please enter a new one (two times for security reasons) then confirm with your current one:<br>
      <input type="password" value="" placeholder="Your new password"></input><br>
      <input type="password" value="" placeholder="One last time..."></input><br>
      <input type="password" value="" placeholder="Current password"></input></p>
  </div>
  <div>
    <h1>Account Preferences</h1>
    <h3>Current mail notifications status:  </h3>
    <p>If you wish to change it, please check (or uncheck) accordingly the checkbox below:<br><br>
      <input type="checkbox" id="check_notif" value=""></input>
      <label for="check_notif">Do you wish to receive emails for each comment ?</label></p>
  </div>
</div>
