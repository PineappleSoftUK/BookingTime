/*
User log in
*/

// trigger when login form is submitted
$(document).on('submit', '#login_form', function(){
  // remove any old jwt cookie
  setCookie("jwt", "", 1);

  // get form data
  var login_form=$(this);
  var form_data=JSON.stringify(login_form.serializeObject());

  // submit form data to api
  $.ajax({
    url: apiPath + "api/users/login.php",
    type : "POST",
    contentType : 'application/json',
    data : form_data,
    success : function(result){

      // store jwt as cookie
      setCookie("jwt", result.jwt, 1);

      // show home page & alert successful login
      var alertMessage = encodeURIComponent("Log in was successful, welcome!");
      window.location.href = "../index.html?alert_type=success&alert_text=" + alertMessage;
    },
    error: function(xhr, resp, text){
      // alert login failed & empty the input boxes
      var alertMessage = encodeURIComponent("Login failed. Email or password may be incorrect.");
      window.location.href = "index.html?alert_type=error&alert_text=" + alertMessage;
    }
  });
return false;
});
