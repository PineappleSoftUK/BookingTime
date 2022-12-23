/*
Locations, update a location
*/

// get location id
var url = new URL(window.location.href);
var id = decodeURIComponent(url.searchParams.get("id"));

// validate jwt to verify access
var jwt = getCookie('jwt');
$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {

  // read one record based on given location id
  $.getJSON(apiPath + "api/location/read_one.php?id=" + id, function(data){

    // values will populate the form
    var name = data.name;
    var status = data.status;

    // Build the form
    var update_location_html=`

        <!-- Go back button -->
        <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
          &lt; Go Back
        </button>
        <!-- 'update location' html form -->
        <form id='update-location-form' action='#' method='post' border='0'>

          <label for="update-form-name">Name</label>
          <input type='text' name='name' id="update-form-name" value="` + name + `" required />

          <label for="update-form-status">Status</label>
          <select name='status' id="update-form-status">
            <option selected value="` + status + `">` + status + `</option>
            <option value="Live">Live</option>
            <option value="Deleted">Deleted</option>
          </select>

          <!-- hidden 'location id' to identify which record to update -->
          <input value=\"` + id + `\" name='id' type='hidden' />

          <button type='submit'>Save Changes</button>

        </form>`;

    // inject html to 'page-content' of our app
    $("#content").html(update_location_html);

  });
})
// show login page on error
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.location.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
});

// will run if 'update location' form was submitted
$(document).on('submit', '#update-location-form', function(){
  // get form data
  var form_data=JSON.stringify($(this).serializeObject());

  // submit form data to api
  $.ajax({
    url: apiPath + "api/location/update.php",
    type : "POST",
    contentType : 'application/json',
    //send jwt header
    headers: {
      Authorization: 'Bearer ' + getCookie('jwt')
    },
    data : form_data,
    success : function(result) {
      // location was created, go back to locations list
      var alertMessage = encodeURIComponent("Location successfully updated");
      window.location.href = "index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text) {
      // show error to console
      var alertMessage = encodeURIComponent("Update location failed: " + xhr.responseJSON.message);
      window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
  });

    return false;
});
