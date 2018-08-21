<?php
function merge_images($dest_name, $src_name) {
  $dest = imagecreatefrompng($dest_name);
  $src = imagecreatefrompng($src_name);

  imagealphablending($dest, false);
  imagesavealpha($dest, true);

  imagecopymerge($dest, $src, 0, 0, 0, 0, 0, 0, 100);
  header('Content-Type: image/png');
  imagepng($dest);

  imagedestroy($dest);
  imagedestroy($src);
}
?>
