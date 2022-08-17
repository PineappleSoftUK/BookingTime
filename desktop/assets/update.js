/*
Assets, update a asset
*/

// get asset id
var url = new URL(window.location.href);
var id = decodeURIComponent(url.searchParams.get("id"));

// validate jwt to verify access
var jwt = getCookie('jwt');
$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {

  // read one record based on given asset id
  $.getJSON(apiPath + "api/asset/read_one.php?id=" + id, function(data){

    // values will populate the form
    var name = data.name;
    var location = data.location;
    var capacity = data.capacity;
    var timeslots = data.timeslots;
    var status = data.status;

    $.getJSON(apiPath + "api/location/read.php", function(data){

      // build locations list
      var categories_options_html=`<select name='location'>`;
      $.each(data.records, function(key, val){
        //pre-select option is category id is the same
        if(val.id==location){ categories_options_html+=`<option value='` + val.id + `' selected>` + val.name + `</option>`; }

        else{ categories_options_html+=`<option value='` + val.id + `'>` + val.name + `</option>`; }
      });

      categories_options_html+=`</select>`;

      // Build the form
      var update_asset_html=`

          <!-- Go back button -->
          <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
            &lt; Go Back
          </button>
          <!-- 'update asset' html form -->
          <form id='update-asset-form' action='#' method='post' border='0'>

            <label for="update-form-category">Location</label>
            ` + categories_options_html + `

            <label for="update-form-name">Name</label>
            <input type='text' name='name' id="update-form-name" value="` + name + `" required />

            <label for="update-form-capacity">Capacity</label>
            <input type='number' min='1' name='capacity' id="update-form-capacity" value="` + capacity + `" required />

            <label for="update-form-timeslots">Timeslots</label>
            <input type='text' name='timeslots' id="update-form-timeslots" value="` + timeslots + `" required />

            <input type="hidden" id="status" name="status" value="Live">

            <!-- hidden 'location id' to identify which record to delete -->
            <input value=\"` + id + `\" name='id' type='hidden' />

            <button type='submit'>Save Changes</button>

          </form>`;

      // inject html to 'page-content'
      $("#content").html(update_asset_html);
    });

  });
})
// show login page on error
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.location.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
});

// will run if 'update asset' form was submitted
$(document).on('submit', '#update-asset-form', function(){
  // get form data
  var form_data=JSON.stringify($(this).serializeObject());
  // submit form data to api
  $.ajax({
    url: apiPath + "api/asset/update.php",
    type : "POST",
    contentType : 'application/json',
    //send jwt header
    headers: {
      Authorization: 'Bearer ' + getCookie('jwt')
    },
    data : form_data,
    success : function(result) {
      // asset was updated, go back to assets list
      var alertMessage = encodeURIComponent("Asset successfully updated");
      window.location.href = "index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text) {
      // show error to console
      var alertMessage = encodeURIComponent("Update asset failed: " + xhr.responseJSON.message);
      window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
  });

    return false;
});
