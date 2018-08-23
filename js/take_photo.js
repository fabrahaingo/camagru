(function() {
  var video = document.querySelector("#video"),
      canvas = document.getElementById('canvas'),
      context = canvas.getContext('2d'),
      photo = document.getElementById('photo'),
      vendorUrl = window.URL || window.webkitURL;

  navigator.getMedia =  navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mozGetUserMedia ||
                        navigator.msGetUserMedia;

  if (navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({video: true, audio: false})
    .then(function(stream) {
      video.srcObject = stream;
    })
    .catch(function(err0r) {
      console.log("Something went wrong!");
    });
  }

  document.getElementById('capture').addEventListener('click', function() {
    context.drawImage(video, 0, 0, 400, 300);
    photo.setAttribute('src', canvas.toDataURL('image/png'));
  });

  // Send image data to server
  xhr = new XMLHttpRequest();
  xhr.open("POST", "img/test.png", true);
  if (canvas === null)
    xhr.send();
  else {
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.canvas;
  }
})();

// On click, sends canvas datas to hidden input
function  getDataURL() {
  var dataURL = canvas.toDataURL('image/png');
  document.getElementById('sendpic').value = dataURL;
}
