<!DOCTYPE html>

<?php include('functions/merge_images.php'); ?>
<div id="camera_wrapper">

    <!-- Live camera + canvas to be modified -->
    <video id="video" width="400" height="300" autoplay>Video stream not available</video>
    <canvas style="display: none;" id="canvas" width="400" height="300"></canvas>

    <!-- Filters -->
    <div id="filters">
      <div class="filter-selector">
        <input checked="checked" id="facebook" type="radio" name="selected_filter" value="facebook" />
        <label class="filter facebook" for="facebook"></label>
        <input id="youtube" type="radio" name="selected_filter" value="youtube" />
        <label class="filter youtube"for="youtube"></label>
      </div>
    </div>

    <!-- Capture button -->
    <a href="#" id="capture" onclick="getDataURL()">Take photo</a>

    <!-- Result of take_photo.js -->
    <label>Your picture</label>
    <img id="photo" src="http://placekitten.com/g/400/300" alt="Photo of you" />

    <form action="functions/post_pics.php" method="POST">
      <input type="hidden" name="img" id="sendpic" value="">
      <input type="submit" value="SAVE" onclick="getDataURL()">
    </form>

    <script src="js/take_photo.js"></script>

</div>
