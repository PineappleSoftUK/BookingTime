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
            option.value = responseArray[i]['id'];
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

/*

Populate Timeslots

Callled by the calendar, this will gather form details and ask for an array
of timeslots and then write these as radio elemennts

*/
function populateTimeslots(dateString) {

  //First clear the form:

  //Find any element with the attribute: name="timeslot"
  var timeSlotElements = document.querySelectorAll('[name="timeslot"],[name^="timeslot["]');

  //Loop through and remove the element
  for (var i = 0; i < timeSlotElements.length; i++) {
    timeSlotElements[i].remove();
  }

  var locationSelected = document.getElementById("locationsSelect").value;
  var assetSelected = document.getElementById("assetsSelect").value;

  function getTimeslots(date, location, asset) {
    if (date == "") {
      document.getElementById("message").textContent = "Error: no date selected";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

          //Add timeslots to form as radio buttons.
          //The array is parsed JSON that was encoded by the php call
          var responseArray = JSON.parse(this.responseText);
          var responseArrayLength = responseArray.length;

          var submitButton = document.getElementById("submitBreak");

          for (var i = 0; i < responseArrayLength; i++) {
            var time = responseArray[i]['time'];

            //The radio button
            var inputElement = document.createElement("input");
            inputElement.type = "radio";
            //inputElement.name = "timeslot[" + time + "][]";
            inputElement.name = "timeslotRadio";
            inputElement.value = time;
            inputElement.id = time;
            submitButton.before(form.appendChild(inputElement));

            //The radio label
            var labelElement = document.createElement("LABEL");
            var labelText = document.createTextNode(time);
            labelElement.setAttribute("for", time);
            labelElement.setAttribute("name", "timeslot");
            labelElement.appendChild(labelText);
            submitButton.before(form.appendChild(labelElement));

            //End with a br
            var brElement = document.createElement("br");
            brElement.setAttribute("name", "timeslot");
            submitButton.before(form.appendChild(brElement));
          }
        }
      };
      xmlhttp.open("GET","system_calls.php?date="+date+"&location="+location+"&asset="+asset,true);
      xmlhttp.send();
    }
  }

  getTimeslots(dateString, locationSelected, assetSelected);

  //Set hidden form element for submitting the date
  document.getElementById("dateToSubmit").value = dateString;

}

/*

submitCheck

This performs checks on the form then submits the form if ok or alerts users to errors

*/
function submitCheck() {

  //Set the hidden form elements for submit
  document.getElementById("locationToSubmit").value = document.getElementById("locationsSelect").value;
  document.getElementById("assetToSubmit").value = document.getElementById("assetsSelect").value;

  //document.getElementById("form").submit();
}
