/*
This is the js file to support the client booking page.
*/


/*

Update asset list

Updates the assets drop-down with assets from the database/system, based on
selected location.

*/
function updateAssetList() {
  var locationSelected = document.getElementById("locations").value;

  function getAssets(locationSelected) {
    if (locationSelected == "") {
      document.getElementById("message").textContent = "Error: no location selected";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("message").textContent = this.responseText;
        }
      };
      xmlhttp.open("GET","system_calls.php?loc="+locationSelected,true);
      xmlhttp.send();
    }
  }

  getAssets(locationSelected);

}
