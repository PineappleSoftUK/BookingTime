/*
This is the js file to support the client booking page.
*/


/*

Update asset list

Updates the assets drop-down with assets from the database/system, based on
selected location.

*/
function updateAssetList() {
  var locationSelected = document.getElementById("locationsSelect").value;

  function getAssets(locationSelected) {
    if (locationSelected == "") {
      document.getElementById("message").textContent = "Error: no location selected";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

          //Clear asset drop down list
          var select = document.getElementById("assetsSelect");
          var selectLength = select.options.length;
          for (i = selectLength-1; i >= 0; i--) {
            select.options[i] = null;
          }

          //Add assets to drop down list
          //The array is parsed JSON that was encoded by the php call
          var responseArray = JSON.parse(this.responseText);
          var responseArrayLength = responseArray.length;

          for (var i = 0; i < responseArrayLength; i++) {
            var assetName = responseArray[i]['name'];

            var option = document.createElement("option");
            option.text = assetName;
            select.add(option);
          }
        }
      };
      xmlhttp.open("GET","system_calls.php?loc="+locationSelected,true);
      xmlhttp.send();
    }
  }

  getAssets(locationSelected);

}
