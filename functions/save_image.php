<?php

// $con = mysqli_connect("localhost","root","coucou","camagru");
//
// $max_id = mysql_query("SELECT max(id) FROM pictures");
// if (!$max_id) {
//   $max_id = 1;
// }
// echo $max_id;

// Defines name of file + its path
$filename = "picture_" . 3 . ".png";
$filepath = '/img/';

move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);

echo $filepath.$filename;

// // Input values in database
// $sql = "INSERT INTO pictures (login, pic_id) VALUES (:login, :pic_id)";
// $req = $dbh->prepare($sql);
// $req->bindValue(':login', mysqli_real_escape_string($_SESSION['usr_name']));
// $req->bindValue(':pic_id', $filename);
// $result = $req->execute();

?>
