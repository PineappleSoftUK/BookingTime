/*
Bookings, create a booking
*/

// validate jwt to verify access
var jwt = getCookie('jwt');
$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {

  //Function to Add timeslot checkboxes to form based on selected date
  function showTimeslots(asset, date) {
    // Clean date
    var selectedDate = new Date(date);

    $.getJSON(apiPath + "api/timeslot/read_available.php?id=" + asset + "&date=" + selectedDate.toISOString())
      .done(function(result) {

        $.each(result, function(key, val) {
          $('#timeslotsContainer')
          .append('<input class ="" type="checkbox" name="" value="' + val + '">')
          .append('<label for="">' + val + '</label></div>')
          .append('<br>');
        })

      })
      .fail(function(xhr, resp, text) {
        var alertMessage = encodeURIComponent("Create booking failed: " + xhr.responseJSON.message);
        window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
      });
  }




  // get available timeslots for selected date
  var assetVal = $('#create-form-asset').val();
  var dateVal = $('#create-form-date').val();

  var create_booking_html=`

      <!-- Go back button -->
      <button id='go-home-button' class='styledButton greyBtn' onclick="booking.href='index.html';">
        &lt; Go Back
      </button>
      <!-- 'create booking' html form -->
      <form id='create-booking-form' action='#' method='post' border='0'>

        <label for="create-form-client">Client Name</label>
        <input type='text' name='client' id="create-form-client" required />

        <label for="create-form-asset">Asset</label>
        <input type='text' name='asset' id="create-form-asset" required onchange="showTimeslots(` + assetVal + `, ` + dateVal + `)"/>

        <input type="hidden" id="status" name="status" value="Live">

        <label for="create-form-date">Date</label>
        <input type='date' name='date' id="create-form-date" required />

        <div id="timeslotsContainer">
          <!--JS will populate checkboxes here-->
        </div>

        <button type='submit'>Create</button>

      </form>`;

  // inject html to 'page-content' of our app
  $("#content").html(create_booking_html);

})
// show login page on error
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.location.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
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
      window.location.href = "index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text) {
      // show error to console
      var alertMessage = encodeURIComponent("Create booking failed: " + xhr.responseJSON.message);
      window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
  });
  return false;
});
