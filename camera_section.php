<!DOCTYPE html>

<div id="camera_wrapper">

    <!-- Live camera + canvas to be modified -->
    <div id="coucoutest">
      <video id="video" width="400" height="300" autoplay></video>
      <form id="upload-form" style="display: none;">
        Select an image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload" onchange="check()">
      </form>
    </div>
    <canvas style="display: none;" id="canvas" width="400" height="300"></canvas>

    <!-- Filters -->
    <form action="functions/post_pics.php" id="final_submit" method="POST">
      <div id="filters">
        <div class="filter-selector">
          <input checked="checked" id="facebook" type="radio" name="selected_filter" value="facebook-logo.png" />
          <label class="filter facebook" for="facebook"></label>
          <input id="whatsapp" type="radio" name="selected_filter" value="whatsapp-logo.png" />
          <label class="filter whatsapp"for="whatsapp"></label>
        </div>
      </div>

      <!-- Capture button -->
      <a href="#" id="capture" onclick="getDataURL();check();">Take photo</a>

      <!-- Result of take_photo.js -->
      <label>Your picture</label>
      <img id="photo" src="http://placekitten.com/g/400/300" alt="Photo of you" />

      <input type="hidden" name="img" id="sendpic" value="">
      <input id="save_picture" type="submit" value="SAVE" onclick="getDataURL()" disabled>
    </form>

    <script src="js/take_photo.js"></script>

</div>
<div id="mypictures">
  <?php include ("functions/display_mypictures.php"); ?>
</div>
<script type="text/javascript">
Object.defineProperty(HTMLMediaElement.prototype, 'playing', {
    get: function(){
        return !!(this.currentTime > 0 && !this.paused && !this.ended && this.readyState > 2);
    }
})
setTimeout(function() {
if(document.querySelector('video').playing){
  document.getElementById("capture").style.visibility = "visible";
};
}, 2000);
function check() {
  setTimeout(function() {
    var src_value = document.getElementById("photo").src;
    if (src_value == "http://placekitten.com/g/400/300")
      document.getElementById("save_picture").disabled = true;
    else {
      document.getElementById("save_picture").disabled = false;
    }
  }, 500);
}
</script>
