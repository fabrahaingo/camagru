<!DOCTYPE html>
<div id="user_infos">
  <div>
    <h1>Username</h1>
    <h3>Current Username: <?php echo ($_SESSION['usr_name']); ?> </h3>
    <p>If you wish to change it, please write your new username and confirm with your password:<br>
      <input type="text" value="" placeholder="New username"></input><br>
      <input type="password" value="" placeholder="Password"></input></p>
  </div>
  <div>
    <h1>Email</h1>
    <h3>Current Email:  </h3>
    <p>If you wish to change it, please write your new email adress and confirm with your password:<br>
      <input type="text" value="" placeholder="New email adress"></input><br>
      <input type="password" value="" placeholder="Password"></input></p>
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
      <label for="check_notif">Souhaitez-vous vous abonner à la newsletter ?</label></p>
  </div>
</div>
