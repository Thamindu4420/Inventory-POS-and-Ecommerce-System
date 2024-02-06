// JavaScript for displaying the selected image in the circle
function displayImage(input) {
    var preview = document.querySelector('#image-preview');
    var file = input.files[0];
    var reader = new FileReader();
  
    reader.onload = function(e) {
      preview.src = e.target.result;
    };
  
    if (file) {
      reader.readAsDataURL(file);
    }
  }





  
  