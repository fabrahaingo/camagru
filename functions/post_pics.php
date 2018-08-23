<?php

session_start();
require_once '../config/database.php';
$con = mysqli_connect("localhost","root","coucou","camagru");

$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
$dbh->exec($sql);

function merge_images($dest_name, $src_name) {
  $dest = imagecreatefrompng($dest_name);
  $src = imagecreatefrompng($src_name);

  imagealphablending($dest, false);
  imagesavealpha($dest, true);

  imagecopymerge($dest, $src, 0, 0, 0, 0, 400, 300, 100);

  header('Content-Type: image/png');
  imagepng($dest, $dest_name);

  imagedestroy($dest);
  imagedestroy($src);
  return;
}

if (isset($_POST['img'])) {
  $img = $_POST['img'];
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  $file = '../img/image-'.time().'.png';
  file_put_contents($file, $data);

  merge_images($file, "../img/filters/facebook-logo.png");

  $picture_id = 'image-'.time().'.png';
  $user = $_SESSION['usr_name'];
  // $sql = "INSERT INTO camagru.pictures (user, picture_id) VALUES (:user, :picture_id)";
  // $req = $dbh->prepare($sql);
  // $req->bindValue('user', strip_tags(mysqli_real_escape_string($con, $user)));
  // $req->bindValue('picture_id', mysqli_real_escape_string($con, $picture_id));
  // $req->execute();

  header('Location: ../new_pic.php');
}

?>
