<?php

//Selects the first image of the list to display
$i = 1;
$pic_path = "img/picture_1.png";
//While the image name exists
while (file_exists($pic_path)) {
    ?>
    <div class="indiv_gallery">
      <img src="<?php echo($pic_path); ?>">
    </div>
    <?php
    $i = $i + 1;
    //Updates the path before executing the loop again
    $pic_path = "img/picture_" . $i . ".png";
}
return;

?>
