<?php

session_start();
require_once '../config/database.php';
require('get_id.php');

if (!isset($_SESSION['usr_name']) || $_SESSION['usr_name'] == '') {
  //If no user is logged in, then redirects to index.php
  header('Location: ../index.php');
  return;
}

$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
$dbh->exec($sql);

function merge_images($dest_name, $src_name) {
  $dest = imagecreatefrompng($dest_name);
  $src = imagecreatefrompng($src_name);
  // Settings about transparency
  imagealphablending($dest, false);
  imagesavealpha($dest, true);
  // Merging pictures
  imagecopymerge($dest, $src, 0, 0, 0, 0, 400, 300, 100);
  // Replacing existing picture
  imagepng($dest, $dest_name);
  // Destroying copies
  imagedestroy($dest);
  imagedestroy($src);
  return;
}

if (isset($_POST['img'])) {
  // Checks if the image sent is empty or not
  if (($img = $_POST['img']) === "") {
    header("Location: ../new_pic.php");
    return;
  }
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  $file = 'image-'.time().'.png';
  file_put_contents("../img/". $file, $data);

  merge_images("../img/". $file, "../img/filters/" . $_POST['selected_filter']);

  $picture_id = $file;
  $user = ft_get_id($_SESSION['usr_name'], $dbh);
  $sql = "INSERT INTO camagru.pictures (user, picture_id) VALUES (:user, :picture_id)";
  $req = $dbh->prepare($sql);
  $req->bindValue('user', strip_tags($user));
  $req->bindValue('picture_id', $picture_id);
  $req->execute();

  header('Location: ../new_pic.php');
}

?>
