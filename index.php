<!DOCTYPE html>
<?php
    session_start();
?>
<html>
<head>
    <meta charset="utf-8" >
    <?php include "./stylesheets/styles.php" ?>
</head>
<body>
  <?php
  if (isset($_SESSION['usr_name'])) {
    header('Location: home.php');
  }
  else if (isset($_GET['action']) && $_GET['action'] == "register") {
    include "register.php";
  }
  else if (isset($_GET['action']) && $_GET['action'] == "forgot") {
    include "forgot_pwd.php";
  }
  else if (isset($_GET['action']) && $_GET['action'] == "reset") {
    include "reset.php";
  }
  else {
    include "login_page.php";
  }
  include "gallery.php";
  include "footer.php";
  ?>
</body>
</html>
