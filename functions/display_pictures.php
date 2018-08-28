<?php

require('config/database.php');
include('functions/manage_likes.php');
include('functions/manage_comments.php');
$con = mysqli_connect("localhost","root","coucou","camagru");

$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
$dbh->exec($sql);

//Select all pictures from database
$sql = 'SELECT * FROM camagru.pictures';
$req = mysqli_query($con, $sql) or die('There was the problem with your request');

echo "<table>";
echo "<tr><th>Picture</th><th>Likes</th><th>Comments</th></tr>";

while ($row = mysqli_fetch_array($req, MYSQLI_ASSOC)) {
  echo "<tr><td>";
  echo "<img src=\"img/" . $row['picture_id'] . "\" alt=\"Picture of " . $row['user'] . "\" />";
  echo "</td><td>";
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
  echo "</td><td>";
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
  echo "</td></tr>";
};

echo "</table>";

//While the image name exists
/*while (file_exists($pic_path)) {
    ?>
    <div class="indiv_gallery">
      <img src="<?php echo($pic_path); ?>">
      <form action="functions/count_like.php" method="POST">
        <input type="hidden" value="<?php echo $_SESSION['usr_name']; ?>" name="usr_name">
        <input type="hidden" value="<?php echo $pic_path; ?>" name="photo_id">
        <input type="submit" value="Like" name="liked">
      </form>
      <form action="functions/count_like.php" method="POST">
        <input type="hidden" value="<?php echo $_SESSION['usr_name']; ?>" name="usr_name">
        <input type="hidden" value="<?php echo $pic_path; ?>" name="photo_id">
        <input type="submit" value="Unlike" name="unliked">
      </form>
      <!-- REMOVE CSS STYLE HERE -->
      <span style="background: yellow">
        Likes:
        <?php
          $sql = "SELECT COUNT(*) AS num FROM camagru.likes WHERE picture_id = :nr_pic";
          $req = $dbh->prepare($sql);
          $req->bindValue(':nr_pic', $pic_path);
          $req->execute();
          $req = $req->fetch(PDO::FETCH_ASSOC);
          echo $req['num'];
        ?>
      </span>
      <form action="functions/count_comments.php" method="POST">
        <input type="hidden" value="<?php echo $_SESSION['usr_name']; ?>" name="usr_name">
        <input type="hidden" value="<?php echo $pic_path; ?>" name="photo_id">
        <textarea value="" placeholder="Leave a comment" name="comment"></textarea>
        <br>
        <input type="submit" value="Send" name="send_comment">
      </form>
      <!-- REMOVE CSS STYLE HERE -->
      <span style="background: yellow">
        Comments:
        <?php
          $sql = "SELECT * FROM camagru.comments WHERE picture_id = :picture ORDER BY id DESC";
          $req = $dbh->prepare($sql);
          $req->bindValue('picture', $pic_path);
          $req->execute();
          while ($result = $req->fetch(PDO::FETCH_ASSOC)) {
            ?><div>
              <!-- REMOVE CSS STYLE HERE -->
              <span style="text-decoration: underline; font-weight: 500;">By <?php echo strip_tags($result['user']); ?> on the <?php echo $result['creation_date']; ?> :</span>
              <br>
              <span><?php echo strip_tags($result['comment']); ?></span>
            </div><?php
          }
        ?>
      </span>

    </div>
    <?php
    $i = $i + 1;
    //Updates the path before executing the loop again
    $pic_path = "img/image-" . $pic_path . ".png";
}*/
return;

?>
