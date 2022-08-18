/*
Assets, home page
*/

// get list of assets from the API
$.getJSON(apiPath + "api/asset/read.php", function(data){
  // html for listing assets
  var read_assets_html=`
      <!-- when clicked, it will load the create asset form -->
      <button id='create-asset-button' class='styledButton createBtn' onclick="location.href='create.html';">
        &plus; Create Asset
      </button>
      <!-- start items list -->
      <div id='item-list' class='item-list'>

      `;

  // loop through returned list of data
  $.each(data.records, function(key, val) {
    // creating new div/row per record and assign id
    read_assets_html+=`
            <div id='list-item' class='list-item' data-id='` + val.id + `'>
              <p>
                <span class='list-item-name'=>` + val.name + `</span>
                <span class='list-item-attributes'>Status: ` + val.status + `</span>
                <span class='list-item-attributes'>Created: ` + val.created + `</span>
              </p>
            </div>`;
  });

  // end items list
  read_assets_html+=`</div>`;

  // inject to 'page-content' of our app
  $("#content").html(read_assets_html);
});

/*
When record is clicked, display details 'read-one'
*/
$(document).on('click', '#list-item', function(){
  var id = $(this).attr('data-id');
  // read asset record based on given ID
  $.getJSON(apiPath + "api/asset/read_one.php?id=" + id, function(data){

    //Check if modifed in order to display correct date
    var modified = data.modified;
    if (typeof data.modified === 'undefined') {
      modified = "Never modified"
    }

    var read_one_asset_html=`
        <!-- Go back button -->
        <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
          &lt; Go Back
        </button>
        <!-- Update button -->
        <button id='update-asset-button' class='styledButton greyBtn' onclick="location.href='update.html?id=` + data.id + `';">
          Update Asset
        </button>
        <!-- Delete button -->
        <button id='delete-asset-button' class='styledButton greyBtn'  onclick="location.href='delete.html?id=` + data.id + `';">
          Delete Asset
        </button>
        <p>Asset ID: ` + data.id + `</p>
        <p>Name: ` + data.name + `</p>
        <p>Location: ` + data.location + `</p>
        <p>Status: ` + data.status + `</p>
        <p>Created: ` + data.created + `</p>
        <p>Modified: ` + modified + `</p>
        <p>Timeslots: ` + data.timeslots + `</p>
        `
    // inject html to 'page-content'
    $("#content").html(read_one_asset_html);
  });
});
