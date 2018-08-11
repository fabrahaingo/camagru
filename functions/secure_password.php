<?php
function secure_password($password) {
  if (preg_match('/(?=^.{8,15}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/', $password)) {
    return (TRUE);
  }
  else {
    return (FALSE);
  }
}
?>
