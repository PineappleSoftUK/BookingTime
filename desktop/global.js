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

// remove any prompt messages
function clearResponse(){
    $('#response').html('');
}

//Function to populate alert message box
function responseAlert() {
  clearResponse();
  var alertType = localStorage.getItem('alert_type');
  var alertText = localStorage.getItem('alert_text');

  if(alertType!=undefined && alertType!=null){
    var html = `<div class='alert ` + alertType + `'><span class='closebtn' onclick='clearResponse();'>&times;</span>` + alertText + `</div>`;
    $('#response').html(html);

    localStorage.removeItem('alert_type');
    localStorage.removeItem('alert_text');
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
