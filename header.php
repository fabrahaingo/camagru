<!DOCTYPE html>
<header>
  <div id="header_name">
    <a href="index.php">Camagru</a>
  </div>
  <div id="header_menu">
    <div>
      <a href="home.php">Gallery</a>
    </div>
    <div>
      <a href="new_pic.php">New Picture</a>
    </div>
    <div>
      <a href="profile.php">My Profile</a>
    </div>
    <div>
      <a href="functions/logout.php">Logout out of
        <?php echo $_SESSION['usr_name'] ?>
      </a>
    </div>
  </div>
</header>
