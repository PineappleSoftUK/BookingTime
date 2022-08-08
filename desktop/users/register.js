/*
User sign up
*/

// trigger when registration form is submitted
$(document).on('submit', '#sign_up_form', function(){

  // get form data
  var sign_up_form=$(this);
  var form_data=JSON.stringify($(this).serializeObject());

  // submit form data to api
  $.ajax({
    url: apiPath + "api/users/create_user.php",
    type : "POST",
    contentType : 'application/json',
    data : form_data,
    success : function(result) {
      // successful sign up, report response and clear inputs
      localStorage.setItem('alert_type', 'success');
      localStorage.setItem('alert_text', 'Registration was successful, welcome!');
      window.location.href = "index.html";
    },
    error: function(xhr, resp, text) {
      //responseAlert('error', 'Registration failed with the folllowing error: ' + xhr.responseJSON.message);
      console.log(xhr, resp, text);
    }
  });
  return false;
});
