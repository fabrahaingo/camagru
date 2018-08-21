<!DOCTYPE html>

<?php include('functions/merge_images.php'); ?>
<div id="camera_wrapper">

    <!-- Live camera -->
    <video id="video" width="200" height="150">Video stream not available</video>

    <!-- Filters -->
    <div id="filters">
      <button><img src="img/facebook-logo.png" /></button>
      <button><img src="img/youtube-logo.png" /></button>
    </div>

    <!-- Capture button -->
    <a href="#" id="capture"><button onclick="send_data()">Take photo</button></a>

    <!-- Result of take_photo.js -->
    <canvas style="display: none;" id="canvas" width="200" height="150"></canvas>
    <img id="photo" src="http://placekitten.com/g/200/150" alt="Photo of you" />
    <form method="POST" name="hidden_form">
      <input name="hidden_data" id="hidden_data" type="hidden" />
    </form>
    <script src="js/take_photo.js"></script>

</div>
