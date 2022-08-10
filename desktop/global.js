/*
This is a selection of utilities that my be required across the system.

All html pages should load this file.
*/

//Location of API
let apiPath = "http://localhost/";

//Responsive top nav
function expandNav() {
  var x = document.getElementById("topnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

//Change nav if logged in.
function loggedInNav() {
  var jwt = getCookie('jwt');

  if (jwt !== '') {
    $("#logout, #update_account").show();
    $("#login, #sign_up").hide();
  }

}

// remove any prompt messages
function clearResponse(){
    $('#response').html('');
}

//Function to populate alert message box
function responseAlert() {
  clearResponse();

  //Check for alert details from url, if so render alert
  var url = new URL(window.location.href);

  //If found, render the alert
  if(url.searchParams.has('alert_type')){
    var alertType = decodeURIComponent(url.searchParams.get("alert_type"));
    var alertText = decodeURIComponent(url.searchParams.get("alert_text"));

    var html = `<div class='alert ` + alertType + `'><span class='closebtn' onclick='clearResponse();'>&times;</span>` + alertText + `</div>`;
    $('#response').html(html);
  }
}

// function to make form values to json format
$.fn.serializeObject = function()
{
  var o = {};
  var a = this.serializeArray();
  $.each(a, function() {
    if (o[this.name] !== undefined) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
    } else {
      o[this.name] = this.value || '';
    }
  });
  return o;
};

// get or read cookie
function getCookie(cname){
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' '){
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
