/*
Bookings, create a booking
*/

// validate jwt to verify access
var jwt = getCookie('jwt');
$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {

  // Start to build the form
  var selectedDate = new Date();

  // get available timeslots for selected date
  var create_booking_html=`

      <!-- Go back button -->
      <button id='go-home-button' class='styledButton greyBtn' onclick="booking.href='index.html';">
        &lt; Go Back
      </button>
      <!-- 'create booking' html form -->
      <form id='create-booking-form' action='#' method='post' border='0'>

        <label for="create-form-name">Name</label>
        <input type='text' name='name' id="create-form-name" required />

        <input type="hidden" id="status" name="status" value="Live">

        <button type='submit'>Create</button>

      </form>`;

  // inject html to 'page-content' of our app
  $("#content").html(create_booking_html);

})
// show login page on error
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.booking.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
});


// will run if create booking form was submitted
$(document).on('submit', '#create-booking-form', function(){
  // get form data
  var form_data=JSON.stringify($(this).serializeObject());

  // submit form data to api
  $.ajax({
    url: apiPath + "api/booking/create.php",
    type : "POST",
    contentType : 'application/json',
    //send jwt header
    headers: {
      Authorization: 'Bearer ' + getCookie('jwt')
    },
    data : form_data,
    success : function(result) {
      // booking was created, go back to bookings list
      var alertMessage = encodeURIComponent("Booking successfully added");
      window.booking.href = "index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text) {
      // show error to console
      var alertMessage = encodeURIComponent("Create booking failed: " + xhr.responseJSON.message);
      window.booking.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
  });
  return false;
});
