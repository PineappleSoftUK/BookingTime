/*
Assets, delete a asset
*/

// get asset id
var url = new URL(window.location.href);
var id = decodeURIComponent(url.searchParams.get("id"));

// validate jwt to verify access
var jwt = getCookie('jwt');

$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
  // Build the page
  var delete_asset_html=`
      <p>Are you sure you want to delete this?</p>
      <p><i>For information, to preserve the integrity of the system, items cannot be deleted, instead the item's status is changed</i></p>
      <button id='go-home-button' class='styledButton greyBtn' onclick="location.href='index.html';">
        &lt; No, Go Back
      </button>
      <button id='confirm-delete-asset-button' data-id='` + id + `' class='styledButton dangerBtn'>
        Yes, Delete Forever
      </button>

      `;
  // inject html to 'page-content'
  $("#content").html(delete_asset_html);

})
// show login page on error
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.location.href = "../users/index.html?alert_type=error&alert_text=" + alertMessage;
});

// will run if the confirm delete button was clicked
$(document).on('click', '#confirm-delete-asset-button', function(){
  // get asset id
  var id = $(this).attr('data-id');
  var form_data = JSON.stringify({ id: id });

  // submit form data to api
  $.ajax({
    url: apiPath + "api/asset/delete.php",
    type : "POST",
    contentType : 'application/json',
    //send jwt header
    headers: {
     Authorization: 'Bearer ' + getCookie('jwt')
    },
    data : form_data,
    success : function(result) {
     // asset was deleted, go back to assets list
     var alertMessage = encodeURIComponent("Asset successfully marked as deleted");
     window.location.href = "index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text) {
     // show error to console
     var alertMessage = encodeURIComponent("Delete asset failed: " + xhr.responseJSON.message);
     window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
 });
   return false;
});
