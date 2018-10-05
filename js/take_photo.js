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
      document.getElementById('upload-form').style.display = "block";
      document.getElementById("video").style.display = "none";
      document.getElementById("capture").style.display = "none";
    });
  }

  document.getElementById('capture').addEventListener('click', function() {
    context.drawImage(video, 0, 0, 400, 300);
    photo.setAttribute('src', canvas.toDataURL('image/png'));
  });
})();

// On click, sends canvas datas to hidden input
function  getDataURL() {
  if (document.getElementById("fileToUpload").value === "" && document.getElementById("video").style.display === "none") {
    return false;
  };
  var dataURL = canvas.toDataURL('image/png');
  if (dataURL)
    document.getElementById('sendpic').value = dataURL;
};

// On change of input type="file" element, sends uploaded file to canvas
// before displaying it in preview
var input = document.getElementById('fileToUpload');
input.addEventListener('change', handleFiles);

function handleFiles(e) {

  var files = input.files;
  var context = canvas.getContext('2d');
  if (files[0]) {
    if (files[0].type !== "image/png") {
      context.clearRect(0, 0, 400, 300);
      document.getElementById("fileToUpload").value = "";
      return false;
    }
    if (files[0].size > 1000000) {
      return false;
    };
    var context = document.getElementById('canvas').getContext('2d');
    var img = new Image;
    img.src = URL.createObjectURL(e.target.files[0]);
    img.onload = function() {
      context.drawImage(img, 0, 0, 400, 300);
      photo.setAttribute('src', canvas.toDataURL('image/png'));
    };
  };
};
