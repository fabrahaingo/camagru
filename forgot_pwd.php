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
        <?php include "./functions/create_account.php"; ?>
        <?php include "./functions/login.php"; ?>
        <form action="index.php" method="POST">
          <input type="email" name="email" value="" placeholder="Email of your account" autofocus required></input>
          <div id="login_links">
            <a href="index.php">Log in</a>
            <a href="index.php?action=register">Register</a>
          </div>
          <button type="submit" name="connect">SEND RESET LINK</button>
        </form>
      </div>
    </div>
  </div>
  <div id="scroll_to_see">
    <span>&darr; &nbsp; &nbsp; &nbsp; Scroll down to see the gallery &nbsp; &nbsp; &nbsp; &darr;</span>
  </div>
</div>
