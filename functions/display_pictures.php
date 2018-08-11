<?php

require('config/database.php');
$con = mysqli_connect("localhost","root","coucou","camagru");

$dbh = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$dbh->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
$dbh->exec($sql);

//Selects the first image of the list to display
$i = 1;
$pic_path = "img/picture_1.png";

//While the image name exists
while (file_exists($pic_path)) {
    ?>
    <div class="indiv_gallery">
      <img src="<?php echo($pic_path); ?>">
      <form action="functions/count_like.php" method="POST">
        <input type="hidden" value="<?php echo $_SESSION['usr_name']; ?>" name="usr_name">
        <input type="hidden" value="<?php echo $i; ?>" name="photo_id">
        <input type="submit" value="Like" name="liked">
      </form>
      <form action="functions/count_like.php" method="POST">
        <input type="hidden" value="<?php echo $_SESSION['usr_name']; ?>" name="usr_name">
        <input type="hidden" value="<?php echo $i; ?>" name="photo_id">
        <input type="submit" value="Unlike" name="unliked">
      </form>
      <!-- REMOVE CSS STYLE HERE -->
      <span style="background: yellow">
        Likes:
        <?php
          $sql = "SELECT COUNT(*) AS num FROM camagru.likes WHERE picture_id = :nr_pic";
          $req = $dbh->prepare($sql);
          $req->bindValue(':nr_pic', $i);
          $req->execute();
          $req = $req->fetch(PDO::FETCH_ASSOC);
          echo $req['num'];
        ?>
      </span>
      <form action="functions/count_comments.php" method="POST">
        <input type="hidden" value="<?php echo $_SESSION['usr_name']; ?>" name="usr_name">
        <input type="hidden" value="<?php echo $i; ?>" name="photo_id">
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
          $req->bindValue('picture', $i);
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
    $pic_path = "img/picture_" . $i . ".png";
}
return;

?>
