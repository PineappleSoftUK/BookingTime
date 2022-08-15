/*
Locations, delete a location
*/

// get location id
var url = new URL(window.location.href);
var id = decodeURIComponent(url.searchParams.get("id"));

// validate jwt to verify access
var jwt = getCookie('jwt');

$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
  // Build the page
  var delete_location_html=`
      <p>Are you sure you want to delete this?</p>
      <p><i>For information, to preserve the integrity of the system, items cannot be deleted, instead the item's status is changed</i></p>
      <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
        &lt; No, Go Back
      </button>
      <button id='confirm-delete-location-button' data-id='` + id + `' class='styledButton dangerBtn'>
        Yes, Delete Forever
      </button>

      `;
  // inject html to 'page-content' of our app
  $("#content").html(delete_location_html);

})
// show login page on error
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.location.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
});

// will run if the confirm delete button was clicked
$(document).on('click', '#confirm-delete-location-button', function(){
  // get location id
  var id = $(this).attr('data-id');
  var form_data = JSON.stringify({ id: id });

  // submit form data to api
  $.ajax({
    url: apiPath + "api/location/delete.php",
    type : "POST",
    contentType : 'application/json',
    //send jwt header
    headers: {
     Authorization: 'Bearer ' + getCookie('jwt')
    },
    data : form_data,
    success : function(result) {
     // location was deleted, go back to locations list
     var alertMessage = encodeURIComponent("Location successfully marked as deleted");
     window.location.href = "index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text) {
     // show error to console
     var alertMessage = encodeURIComponent("Delete location failed: " + xhr.responseJSON.message);
     window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
 });
   return false;
});
