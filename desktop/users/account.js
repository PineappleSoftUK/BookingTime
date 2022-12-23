/*
Account maintenance
*/

// Validate jwt to verify access then render the page, or direct to login and report error
var jwt = getCookie('jwt');
$.post(apiPath + "api/users/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
  // if logged in, write and populate the form

  var html = `
          <h2>Update Account</h2>
          <form id='update_account_form'>
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control" name="firstname" id="firstname" required value="` + result.data.firstname + `" />

            <label for="lastname">Lastname</label>
            <input type="text" class="form-control" name="lastname" id="lastname" required value="` + result.data.lastname + `" />

            <input type="hidden" class="form-control" name="email" id="email" required value="` + result.data.email + `" />

            <label for="password">Password</label>
            <input type="password" name="password" id="password" />

            <button type='submit'>Save Changes</button>
          </form>
      `;

  $('#content').html(html);
})
// on error/fail, alert user
.fail(function(result){
  var alertMessage = encodeURIComponent("Please login to access this page");
  window.location.href = "../index.html?alert_type=error&alert_text=" + alertMessage;
});


// trigger when 'update account' form is submitted
$(document).on('submit', '#update_account_form', function(){
  // get form data
  var update_account_form=$(this);
  var form_data=JSON.stringify(update_account_form.serializeObject());

  // submit form data to api
  $.ajax({
    url: apiPath + "api/users/update_user.php",
    type : "POST",
    contentType : 'application/json',
    //send jwt header
    headers: {
      Authorization: 'Bearer ' + getCookie('jwt')
    },
    data : form_data,
    success : function(result) {

      // tell the user account was updated
      var alertMessage = encodeURIComponent("Account info updated successfully");
      window.location.href = "account.html?alert_type=success&alert_text=" + alertMessage;

      // store new jwt to coookie
      setCookie("jwt", result.jwt, 1);
    },

    // show error message to user
    error: function(xhr, resp, text){
      console.log(xhr, resp, text);
      if(xhr.responseJSON.message=="Unable to update user."){
        var alertMessage = encodeURIComponent("Unable to update account info");
        window.location.href = "account.html?alert_type=error&alert_text=" + alertMessage;
      }

      else if(xhr.responseJSON.message=="Access denied."){
        var alertMessage = encodeURIComponent("Please login to access this page");
        window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
      }
    }
  });
  return false;
});
