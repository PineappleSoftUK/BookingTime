/*
User log out
*/

// remove any old jwt cookie
setCookie("jwt", "", 1);

var alertMessage = encodeURIComponent("Log out successful");
window.location.href = "index.html?alert_type=success&alert_text=" + alertMessage;
