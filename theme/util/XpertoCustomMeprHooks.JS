function appendHtml() {
  var classs = document.getElementsByClassName('mp-form-row mepr_custom_field mepr_mepr_profile_picture');
  var div = document.getElementById('mepr_profile_picture');
  
  if (classs.length > 0) { // Check if the collection has elements
    var lastElement = classs[classs.length - 1]; // Get the last element in the collection
    var html = `<span style="display:block; font-size: 10pt; margin-top: 5pt;">Maximum File Size Upload: 2MB</span>`; // Prepare the HTML code

    lastElement.insertAdjacentHTML('beforeend', html); // Insert the HTML after the last element
  }

  var classs = document.getElementsByClassName('mp-form-row mepr_custom_field mepr_mepr_profile_banner');
  var div = document.getElementById('mepr_profile_banner');
  
  if (classs.length > 0) { // Check if the collection has elements
    var lastElement = classs[classs.length - 1]; // Get the last element in the collection
    var html = `<span style="display:block; font-size: 10pt; margin-top: 5pt;">Maximum File Size Upload: 2MB</span>`; // Prepare the HTML code

    lastElement.insertAdjacentHTML('beforeend', html); // Insert the HTML after the last element
  }
}




window.onload = appendHtml;