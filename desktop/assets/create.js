/*
Assets, create a asset
*/

// validate jwt to verify access
var jwt = getCookie('jwt');
$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
  $.getJSON(apiPath + "api/location/read.php", function(data){

    // build locations list
    var categories_options_html=`<select name='location'>`;
    $.each(data.records, function(key, val){
      categories_options_html+=`<option value='` + val.id + `'>` + val.name + `</option>`;
    });

    categories_options_html+=`</select>`;

    // Build the form
    var create_asset_html=`

        <!-- Go back button -->
        <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
          &lt; Go Back
        </button>
        <!-- 'create asset' html form -->
        <form id='create-asset-form' action='#' method='post' border='0'>

          <label for="create-form-category">Location</label>
          ` + categories_options_html + `

          <label for="create-form-name">Name</label>
          <input type='text' name='name' id="create-form-name" required />

          <label for="create-form-capacity">Capacity</label>
          <input type='number' min='1' name='capacity' id="create-form-capacity" required />

          <label for="create-form-timeslots">Timeslots</label>
          <input type='text' name='timeslots' id="create-form-timeslots" required />

          <input type="hidden" id="status" name="status" value="Live">

          <button type='submit'>Save Changes</button>

        </form>`;

    // inject html to 'page-content'
    $("#content").html(create_asset_html);
  });
})
// show login page on error
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.location.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
});


// will run if create asset form was submitted
$(document).on('submit', '#create-asset-form', function(){
  // get form data
  var form_data=JSON.stringify($(this).serializeObject());

  // submit form data to api
  $.ajax({
    url: apiPath + "api/asset/create.php",
    type : "POST",
    contentType : 'application/json',
    //send jwt header
    headers: {
      Authorization: 'Bearer ' + getCookie('jwt')
    },
    data : form_data,
    success : function(result) {
      // asset was created, go back to assets list
      var alertMessage = encodeURIComponent("Asset successfully added");
      window.location.href = "index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text) {
      // show error to console
      var alertMessage = encodeURIComponent("Create asset failed: " + xhr.responseJSON.message);
      window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
  });
  return false;
});
