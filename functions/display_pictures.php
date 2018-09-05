<?php

require('config/database.php');
include('functions/manage_likes.php');
include('functions/manage_comments.php');
$con = mysqli_connect("localhost","root","coucou","camagru");

$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
$dbh->exec($sql);

// Count all pictures in database
$sql = 'SELECT * FROM camagru.pictures';
$req = mysqli_query($con, $sql) or die('There was the problem with your request');
$count_start = mysqli_num_rows($req);

if (!isset($_GET['page'])) {
  $i = 1;
}
else {
  $i = $_GET['page'];
}

echo "<div id=\"main_div\">";

// If number of pictures is > 5
if ($count_start > 5) {
  $sql = 'SELECT * FROM camagru.pictures LIMIT ' . 5 * $i;
  $req = mysqli_query($con, $sql) or die('There was the problem with your request');
  $count = mysqli_num_rows($req);
  while ($row = mysqli_fetch_array($req, MYSQLI_ASSOC)) {
    echo "<div id=\"indiv_image\"><div>";
    echo "<img src=\"img/" . $row['picture_id'] . "\" alt=\"Picture of " . $row['user'] . "\" />";
    echo "</div><div><div>";
    echo "Likes: ";
    display_likes($row['picture_id']);
    echo "\n";
    if (isset($_SESSION['usr_name'])) {
      echo "<form method=\"POST\" action=\"functions/manage_likes.php\">";
          echo "<input type=\"hidden\" name=\"picture_id\" value=\"" . $row['picture_id'] . "\"></input>";
          echo "<input type=\"hidden\" name=\"usr_name\" value=\"" . $_SESSION['usr_name'] . "\"></input>";
          echo "<input type=\"submit\" name=\"like\" value=\"Like\"></input>";
          echo "<input type=\"submit\" name=\"unlike\" value=\"Unlike\"></input>";
        echo "</form>";
      }
    echo "</div><div>";
    if (isset($_SESSION['usr_name'])) {
    echo "Comments:";

      echo "<form method=\"POST\" action=\"functions/manage_comments.php\">";
          echo "<input type=\"hidden\" name=\"picture_id\" value=\"" . $row['picture_id'] . "\"></input>";
          echo "<input type=\"hidden\" name=\"usr_name\" value=\"" . $_SESSION['usr_name'] . "\"></input>";
          echo "<input type=\"text\" name=\"new_comment\" placeholder=\"Enter your comment here\" required></input>";
          echo "<input type=\"submit\" name=\"sent_comment\" value=\"Submit comment\"></input>";
        echo "</form>";
    }
    echo "\n";
    echo "<div id=\"comments_section\">";
    display_comments($row['picture_id']);
    echo "</div></div></div>";
  };
}

$sql = 'SELECT * FROM camagru.pictures';
$req = mysqli_query($con, $sql) or die('There was the problem with your request');
$count = mysqli_num_rows($req);

// If number of pictures is <= 5
if ($count <= 5) {
  while ($row = mysqli_fetch_array($req, MYSQLI_ASSOC)) {
  $i = 1;
  echo "<div id=\"indiv_image\"><div>";
  echo "<img src=\"img/" . $row['picture_id'] . "\" alt=\"Picture of " . $row['user'] . "\" />";
  echo "</div><div id=\"pic_infos\"><div>";
  echo "Likes: ";
    display_likes($row['picture_id']);
    echo "\n";
    if (isset($_SESSION['usr_name'])) {
      echo "<form method=\"POST\" action=\"functions/manage_likes.php\">";
        echo "<input type=\"hidden\" name=\"picture_id\" value=\"" . $row['picture_id'] . "\"></input>";
        echo "<input type=\"hidden\" name=\"usr_name\" value=\"" . $_SESSION['usr_name'] . "\"></input>";
        echo "<input type=\"submit\" name=\"like\" value=\"Like\"></input>";
        echo "<input type=\"submit\" name=\"unlike\" value=\"Unlike\"></input>";
      echo "</form>";
    }
  echo "</div><div>";
  echo "Comments:";
    if (isset($_SESSION['usr_name'])) {
      echo "<form method=\"POST\" action=\"functions/manage_comments.php\">";
        echo "<input type=\"hidden\" name=\"picture_id\" value=\"" . $row['picture_id'] . "\"></input>";
        echo "<input type=\"hidden\" name=\"usr_name\" value=\"" . $_SESSION['usr_name'] . "\"></input>";
        echo "<input type=\"text\" name=\"new_comment\" placeholder=\"Enter your comment here\"></input>";
        echo "<input type=\"submit\" name=\"sent_comment\" value=\"Submit comment\"></input>";
      echo "</form>";
    }
    echo "\n";
    echo "<div id=\"comments_section\">";
    display_comments($row['picture_id']);
  echo "</div></div></div>";
};
}

echo "</div>";
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
