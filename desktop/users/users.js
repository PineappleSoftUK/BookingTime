/*
      USER MANAGMENT UTILITIES
*/
$(document).ready(function(){

  /*
  General
  */

  // function to set cookie
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

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
        window.location.href = "../index.html";
      },
      error: function(xhr, resp, text){
        // alert login failed & empty the input boxes
        responseAlert('error', 'Login failed. Email or password may be incorrect.');
        login_form.find('input').val('');
        console.log(xhr, resp, text);
      }
    });
  return false;
  });
});
