<?php

session_start();

if (!isset($_SESSION['usr_name'])) {
  echo ("Please fill the login form in order to access this page.");
  header('Location: index.php');
}
else {
  return;
}

?>
