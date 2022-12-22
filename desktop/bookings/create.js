/*
Bookings, create a booking
*/

// validate jwt to verify access
var jwt = getCookie('jwt');
$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt }))
  .done(function(result) {

    getLocations(); //Calls below function to populate location drop-down then render page.

    //Populate locations drop-down:
    function getLocations() {
      var locations_options_html=`<select name='location' id='create-form-location' onchange='getLocations()'>`;
      $.getJSON(apiPath + "api/location/read.php", function(data){
        $.each(data.records, function(key, val){
          locations_options_html+=`<option value='` + val.id + `'>` + val.name + `</option>`;
        });
        locations_options_html+=`</select>`;
        getAssets(locations_options_html);
      });
    }

    function getAssets(locations_options_html) {
      var assets_options_html=`<select name='asset' id='create-form-asset' onchange='showTimeslots()'>`;
      $.getJSON(apiPath + "api/asset/read.php", function(data){
        $.each(data.records, function(key, val){
          assets_options_html+=`<option value='` + val.id + `'>` + val.name + `</option>`;
        });
        assets_options_html+=`</select>`;
        renderPage(locations_options_html, assets_options_html);
      });
    }

    function renderPage(locations, assets) {

      //Make the html page...
      var create_booking_html=`

          <!-- Go back button -->
          <button id='go-home-button' class='styledButton greyBtn' onclick="booking.href='index.html';">
            &lt; Go Back
          </button>
          <!-- 'create booking' html form -->
          <form id='create-booking-form' action='#' method='post' border='0'>

            <label for="create-form-location">Select Location</label>
            ` + locations + `

            <label for="create-form-asset">Select Asset</label>
            ` + assets + `

            <input type="hidden" id="status" name="status" value="Live">

            <label for="create-form-date">Choose a date to view available timeslots</label>
            <input type='date' name='date' id="create-form-date" required onchange="showTimeslots()"/>

            <br><br>

            <div id="timeslotsContainer">
              <!--JS will populate checkboxes here-->
            </div>

            <button type='submit'>Create</button>

          </form>`;

      // inject html to 'page-content' of our app
      $("#content").html(create_booking_html);
    }
  })
  // show login page on error
  .fail(function(result){
    var alertMessage = encodeURIComponent("Please login to access this page");
    window.location.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
  });

//Function to Add timeslot checkboxes to form based on selected date
function showTimeslots() {
  // get available timeslots for selected date
  var asset = $('#create-form-asset :selected').val();
  var date = $('#create-form-date').val();

  // Clean the date (make it object)
  var selectedDate = new Date(date);

  $.getJSON(apiPath + "api/timeslot/read_available.php?id=" + asset + "&date=" + selectedDate.toISOString())
    .done(function(result) {
      $("#timeslotsContainer").empty();
      if(result.length == 0) {
        $('#timeslotsContainer').append('<p>There are no bookings available for this date</p>');
      } else {
        $.each(result, function(key, val) {
          $('#timeslotsContainer')
          .append('<input class ="" type="radio" name="" value="' + val + '">')
          .append('<label for="">' + val + '</label></div>')
          .append('<br>');
        })
      }
    })
    .fail(function(xhr, resp, text) {
      var alertMessage = encodeURIComponent("Create booking failed: " + xhr.responseJSON.message);
      window.location.href = "create.html?alert_type=error&alert_text=" + alertMessage;
    });
}

// This will run if create booking form was submitted, to submit the form data
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
