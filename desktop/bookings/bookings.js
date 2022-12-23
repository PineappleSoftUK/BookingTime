/*
Bookings, home page
*/

// get list of bookings from the API
$.getJSON(apiPath + "api/booking/read.php", function(data){
  // html for listing bookings
  var read_bookings_html=`
      <!-- when clicked, it will load the create booking form -->
      <button id='create-booking-button' class='styledButton createBtn' onclick="location.href='create.html';">
        &plus; Create Booking
      </button>
      <!-- start items list -->
      <div id='item-list' class='item-list'>

      `;

  // loop through returned list of data
  $.each(data.records, function(key, val) {
    // creating new div/row per record and assign id
    read_bookings_html+=`
            <div id='list-item' class='list-item' data-id='` + val.id + `'>
              <p>
                <span class='list-item-name'=>` + val.id + " (Asset: " + val.asset + `)</span>
                <span class='list-item-attributes'>Status: ` + val.status + `</span>
                <span class='list-item-attributes'>Created: ` + val.created + `</span>
              </p>
            </div>`;
  });

  // end items list
  read_bookings_html+=`</div>`;

  // inject to 'page-content' of our app
  $("#content").html(read_bookings_html);
});

/*
When record is clicked, display details 'read-one'
*/
$(document).on('click', '#list-item', function(){
  var id = $(this).attr('data-id');
  // read booking record based on given ID
  $.getJSON(apiPath + "api/booking/read_one.php?id=" + id, function(data){

    //Check if modifed in order to display correct date
    var modified = data.modified;
    if (!data.modified) {
      modified = "Never modified";
    }

    var read_one_booking_html=`
        <!-- Go back button -->
        <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
          &lt; Go Back
        </button>
        <!-- Update button -->
        <button id='update-booking-button' class='styledButton greyBtn' onclick="location.href='update.html?id=` + data.id + `';">
          Update Booking
        </button>
        <!-- Delete button -->
        <button id='delete-booking-button' class='styledButton greyBtn'  onclick="location.href='delete.html?id=` + data.id + `';">
          Delete Booking
        </button>
        <p>Booking ID: ` + data.id + `</p>
        <p>Client: ` + data.client + `</p>
        <p>Asset: ` + data.asset + `</p>
        <p>Status: ` + data.status + `</p>
        <p>Created: ` + data.created + `</p>
        <p>Modified: ` + modified + `</p>
        `
    // inject html to 'page-content' of our app
    $("#content").html(read_one_booking_html);
  });

  $.getJSON(apiPath + "api/timeslot/read_booking.php?id=" + id, function(data){

    var read_one_booking_timelslots_html=`
        <p><b>Timeslots</b></p>
        <!-- start items list -->
        <div id='item-list-timslots' class='item-list'>
        `

    // loop through returned list of data
    $.each(data.records, function(key, val) {
      // creating new div/row per record and assign id
      read_one_booking_timelslots_html+=`
        <div id='list-item-timeslot' class='list-item' data-id='` + val.id + `'>
          <p>
            <span class='list-item-name'=>` + val.timeslotDate + " - " + val.timeslotTime + `</span>
            <span class='list-item-attributes'>Status: ` + val.status + `</span>
            <span class='list-item-attributes'>Created: ` + val.created + `</span>
          </p>
        </div>`;
    });

    // end items list
    read_one_booking_timelslots_html+=`</div>`;

    // inject html to 'page-content' of our app
    $("#content").append(read_one_booking_timelslots_html);
  });
});
