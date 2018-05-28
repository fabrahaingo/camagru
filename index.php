<!DOCTYPE html>
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
    else {
        include "login_page.php";
    }
    ?>
</body>
</html>
