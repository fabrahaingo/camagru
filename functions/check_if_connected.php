<?php

session_start();

if (!isset($_SESSION['usr_name'])) {
  //If no user is logged in, then redirects to index.php
  header('Location: index.php');
}
else {
  return;
}

?>
