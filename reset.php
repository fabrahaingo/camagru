<!DOCTYPE html>
<div id="general_login">
  <a href="index.php">
    <div id="empty_header">
      <span>Camagru</span>
    </div>
  </a>
  <div id="login_div">
    <div id="login_space">
      <div id="login_form">
        <?php include "./functions/login.php"; ?>
        <form method="POST">
          <input type="password" name="password1" value="" placeholder="Enter your new password"
            pattern="(?=^.{8,15}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$" autofocus required></input>
          <input type="password" name="password2" value="" placeholder="Confirm it"
            pattern="(?=^.{8,15}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$" required></input>
          <div id="login_links">
            <a href="index.php">Log in</a>
            <a href="index.php?action=register">Register</a>
          </div>
          <button type="submit" name="reset">RESET PASSWORD</button>
        </form>
      </div>
    </div>
  </div>
  <div id="scroll_to_see">
    <span>&darr; &nbsp; &nbsp; &nbsp; Scroll down to see the gallery &nbsp; &nbsp; &nbsp; &darr;</span>
  </div>
</div>
