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
                <span class='list-item-category'>&lt` + val.status + `&gt</span>
                <span class='list-item-attributes'>Buy: &pound` + val.category + `</span>
              </p>
            </div>`;
  });

  // end items list
  read_locations_html+=`</div>`;

  // inject to 'page-content' of our app
  $("#content").html(read_locations_html);
});
