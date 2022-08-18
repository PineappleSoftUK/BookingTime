/*
Locations, home page
*/

// get list of locations from the API
$.getJSON(apiPath + "api/location/read.php", function(data){
  // html for listing locations
  var read_locations_html=`
      <!-- when clicked, it will load the create location form -->
      <button id='create-location-button' class='styledButton createBtn' onclick="location.href='create.html';">
        &plus; Create Location
      </button>
      <!-- start items list -->
      <div id='item-list' class='item-list'>

      `;

  // loop through returned list of data
  $.each(data.records, function(key, val) {
    // creating new div/row per record and assign id
    read_locations_html+=`
            <div id='list-item' class='list-item' data-id='` + val.id + `'>
              <p>
                <span class='list-item-name'=>` + val.name + `</span>
                <span class='list-item-attributes'>Status: ` + val.status + `</span>
                <span class='list-item-attributes'>Created: ` + val.created + `</span>
              </p>
            </div>`;
  });

  // end items list
  read_locations_html+=`</div>`;

  // inject to 'page-content' of our app
  $("#content").html(read_locations_html);
});

/*
When record is clicked, display details 'read-one'
*/
$(document).on('click', '#list-item', function(){
  var id = $(this).attr('data-id');
  // read location record based on given ID
  $.getJSON(apiPath + "api/location/read_one.php?id=" + id, function(data){

    //Check if modifed in order to display correct date
    var modified = data.modified;
    if (!data.modified) {
      modified = "Never modified";
    }

    var read_one_location_html=`
        <!-- Go back button -->
        <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
          &lt; Go Back
        </button>
        <!-- Update button -->
        <button id='update-location-button' class='styledButton greyBtn' onclick="location.href='update.html?id=` + data.id + `';">
          Update Location
        </button>
        <!-- Delete button -->
        <button id='delete-location-button' class='styledButton greyBtn'  onclick="location.href='delete.html?id=` + data.id + `';">
          Delete Location
        </button>
        <p>Location ID: ` + data.id + `</p>
        <p>Name: ` + data.name + `</p>
        <p>Status: ` + data.status + `</p>
        <p>Created: ` + data.created + `</p>
        <p>Modified: ` + modified + `</p>
        `
    // inject html to 'page-content' of our app
    $("#content").html(read_one_location_html);
  });
});
