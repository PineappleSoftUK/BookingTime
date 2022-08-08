/*
User log out
*/

// remove any old jwt cookie
setCookie("jwt", "", 1);

localStorage.setItem('alert_type', 'success');
localStorage.setItem('alert_text', 'Log out successful');
window.location.href = "index.html";
