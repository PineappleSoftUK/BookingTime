/*
Locations, create a location
*/

// validate jwt to verify access
var jwt = getCookie('jwt');
$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {

  // Build the form
  var create_location_html=`

      <!-- Go back button -->
      <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
        &lt; Go Back
      </button>
      <!-- 'create location' html form -->
      <form id='create-location-form' action='#' method='post' border='0'>

        <label for="create-form-name">Name</label>
        <input type='text' name='name' id="create-form-name" required />

        <input type="hidden" id="status" name="status" value="Live">

        <button type='submit'>Create</button>

      </form>`;

  // inject html to 'page-content' of our app
  $("#content").html(create_location_html);

})
// show login page on error
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.location.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
});


// will run if create location form was submitted
$(document).on('submit', '#create-location-form', function(){
  // get form data
  var form_data=JSON.stringify($(this).serializeObject());

  // submit form data to api
  $.ajax({
    url: apiPath + "api/location/create.php",
    type : "POST",
    contentType : 'application/json',
    //send jwt header
    headers: {
      Authorization: 'Bearer ' + getCookie('jwt')
    },
    data : form_data,
    success : function(result) {
      // location was created, go back to locations list
      var alertMessage = encodeURIComponent("Location successfully added");
      window.location.href = "index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text) {
      // show error to console
      var alertMessage = encodeURIComponent("Create location failed: " + xhr.responseJSON.message);
      window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
  });
  return false;
});
