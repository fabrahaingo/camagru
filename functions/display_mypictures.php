<?php

require('config/database.php');
require('functions/get_id.php');

$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "CREATE DATABASE IF NOT EXISTS camagru";
$dbh->exec($sql);

// Count all pictures in database
$sql = 'SELECT COUNT(*) FROM camagru.pictures WHERE user = "' . ft_get_id($_SESSION['usr_name'], $dbh) . '"';
$req = $dbh->prepare($sql);
$req->execute();
// Gets the number of rows found
$count_start = $req->fetch(PDO::FETCH_ASSOC);
if ($count_start) {
  $count_start = array_values($count_start)[0];
}
if (!$req)
  return;
else if (!($count_start))
  return;

if (!isset($_GET['page'])) {
  $i = 1;
}
else {
  $i = $_GET['page'];
}

echo "<table>";
echo "<tr><th>My Pictures</th></tr>";

// If number of pictures is > 5
if ($count_start > 5) {
  $sql = 'SELECT * FROM camagru.pictures WHERE user = "' . ft_get_id($_SESSION['usr_name'], $dbh) . "\" LIMIT " . 5 * $i;
  $req = $dbh->prepare($sql);
  $req->execute();
  while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr><td>";
    echo "<img src=\"img/" . $row['picture_id'] . "\" alt=\"Picture of " . $row['user'] . "\" />";
    echo "</td><td>";
    echo "Do you want to delete it ?";
    echo "\n";
    if (isset($_SESSION['usr_name'])) {
      echo "<form method=\"POST\" action=\"functions/delete_picture.php\">";
          echo "<input type=\"hidden\" name=\"picture_id\" value=\"" . $row['picture_id'] . "\"></input>";
          echo "<input type=\"hidden\" name=\"usr_name\" value=\"" . ft_get_id($_SESSION['usr_name'], $dbh) . "\"></input>";
          echo "<input type=\"submit\" name=\"like\" value=\"Yes I do\"></input>";
        echo "</form>";
      }
    echo "</td></tr>";
  };
}

$sql = 'SELECT COUNT(*) FROM camagru.pictures WHERE user = "' . ft_get_id($_SESSION['usr_name'], $dbh) . "\"";
$req = $dbh->prepare($sql);
$req->execute();
// Gets the number of rows found
$count = $req->fetch(PDO::FETCH_ASSOC);
if ($count) {
  $count = array_values($count)[0];
}

// If number of pictures is <= 5
if ($count <= 5) {
  $sql = 'SELECT * FROM camagru.pictures WHERE user = "' . ft_get_id($_SESSION['usr_name'], $dbh) . "\"";
  $req = $dbh->prepare($sql);
  $req->execute();
  while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $i = 1;
    echo "<tr><td>";
    echo "<img src=\"img/" . $row['picture_id'] . "\" alt=\"Picture of " . $row['user'] . "\" />";
    echo "</td><td>";
    echo "Do you want to delete it ?";
    echo "\n";
    if (isset($_SESSION['usr_name'])) {
      echo "<form method=\"POST\" action=\"functions/delete_picture.php\">";
          echo "<input type=\"hidden\" name=\"picture_id\" value=\"" . $row['picture_id'] . "\"></input>";
          echo "<input type=\"hidden\" name=\"usr_name\" value=\"" . ft_get_id($_SESSION['usr_name'], $dbh) . "\"></input>";
          echo "<input type=\"submit\" name=\"like\" value=\"Yes I do\"></input>";
        echo "</form>";
      }
    echo "</td></tr>";
  };
}

echo "</table>";
if (isset($_SESSION['usr_name'])) {
  if ($count_start > $i * 5)
  echo "<a id=\"show_more\" href=\"home.php?page=" . ($i + 1) . "\">Show more</a>";
}
else {
  if ($count_start > $i * 5)
  echo "<a id=\"show_more\" href=\"index.php?page=" . ($i + 1) . "\">Show more</a>";
}
$i = $i + 1;
return;

?>
