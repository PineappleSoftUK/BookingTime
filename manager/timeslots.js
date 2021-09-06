/*

Toggle

Toggles all/none

*/
function toggle(source, element) {
  var checkboxes = document.querySelectorAll('[name^="' + element + '"');
  for (var i = 0, n = checkboxes.length; i < n; i++) {
    checkboxes[i].checked = source.checked;
  }
}


/*

TimeString

Returns the current time of the object as a string

*/
class TimeString extends Date {

  //Function to add leading zero's
  pad(num, size) {
    var s = "000000000" + num;
    return s.substr(s.length - size);
  }

  //Function to return the current time of the date object as a string
  timeAsString() {
    var time;
    time = this.pad(this.getHours(), 2) + ":" + this.pad(this.getMinutes(), 2);
    return time;
  }
}


/*

removeTimeslots

Removes any checkboxes generated by js from the form

*/
function removeTimeslots() {

  //Find any element with the attribute: name="timeslot"
  var timeSlotElements = document.querySelectorAll('[name="timeslot"],[name^="timeslot["],[name$="toggleTimeslots"], [name="dayLabel"]');

  //Loop through and remove the element
  for (var i = 0; i < timeSlotElements.length; i++) {
    timeSlotElements[i].remove();
  }
}



/*

allDay

Mask timeslot selection when 'All Day' is checked

*/
function allDay() {

  //First remove any checkboxes generated by js from the form
  removeTimeslots();

  //Disable the input and button
  if (document.getElementById("daily").checked) {

    var timeSlotElements = document.querySelectorAll('[name="timeslotText"]');

    for (var i = 0; i < timeSlotElements.length; i++) {
      timeSlotElements[i].setAttribute("style", "color: #ccc;");
    }

    document.getElementById("timeslotLength").disabled = true;
    document.getElementById("timeslotLengthLabel").setAttribute("style", "color: #ccc;");


    document.getElementById("timeslotStart").disabled = true;
    document.getElementById("timeslotStartLabel").setAttribute("style", "color: #ccc;");

    document.getElementById("showTimeslotsButton").disabled = true;

    document.getElementById("radioYes").disabled = true;
    document.getElementById("radioNo").disabled = true;
    document.getElementById("radioYesLabel").setAttribute("style", "color: #ccc;");
    document.getElementById("radioNoLabel").setAttribute("style", "color: #ccc;");


  } else {
    var timeSlotElements = document.querySelectorAll('[name="timeslotText"]');

    for (var i = 0; i < timeSlotElements.length; i++) {
      timeSlotElements[i].setAttribute("style", "color: black;");
    }

    document.getElementById("timeslotLength").disabled = false;
    document.getElementById("timeslotLengthLabel").setAttribute("style", "color: black;");

    document.getElementById("timeslotStart").disabled = false;
    document.getElementById("timeslotStartLabel").setAttribute("style", "color: black;");

    document.getElementById("showTimeslotsButton").disabled = false;

    document.getElementById("radioYes").disabled = false;
    document.getElementById("radioNo").disabled = false;
    document.getElementById("radioYesLabel").setAttribute("style", "color: black;");
    document.getElementById("radioNoLabel").setAttribute("style", "color: black;");
  }

}


/*

showTimeslots

Add checkboxes to form based on number selected

*/
function showTimeslots() {

  //First remove any checkboxes generated by js from the form
  removeTimeslots();

  //The form
  var form = document.getElementById("form");


  //Get text box value then calculate number of timeslots for the day
  var selection = parseInt(document.getElementById("timeslotLength").value);
  var numberOfTimeslots = 1440 / selection;

  //Set the clock to zero
  var clock = new TimeString();
  clock.setHours(0, parseInt(document.getElementById("timeslotStart").value), 0);

  //If timeslots are the same each day
  if (document.getElementById("radioNo").checked) {

    //Add 'select all/none' toggle
    var day = "week";
    writeToggle(day);

    //Add the checkboxes to the form
    for (var i = 0; i < numberOfTimeslots; i++) {
      writeCheckboxes(form, selection, numberOfTimeslots, clock, day);
    }
  } else {

    //Get days
    var checkboxes = document.querySelectorAll('input[name="days[]"][type=checkbox]:checked')
    var submitButton = document.getElementById("submitBreak");

    for (var j = 0; j < checkboxes.length; j++) { //days
      var dayText = document.createElement("P");
      var textnode = document.createTextNode(checkboxes[j].value);
      dayText.setAttribute("name", "dayLabel");
      dayText.appendChild(textnode);
      submitButton.before(form.appendChild(dayText));

      //Add 'select all/none' toggle
      var day = checkboxes[j].value;
      writeToggle(day);

      for (var k = 0; k < numberOfTimeslots; k++) { //hours
        writeCheckboxes(form, selection, numberOfTimeslots, clock, day);
      }
    }
  }
}


/*

writeToggle

Adds a select all/none checkbox to the form

*/
function writeToggle(day) {

  var submitButton = document.getElementById("submitBreak");

  //Add toggle
  var toggleElement = document.createElement("input");
  toggleElement.type = "checkbox";
  toggleElement.id = day + "_" + "toggleTimeslots";
  toggleElement.name = day + "_" + "toggleTimeslots";
  submitButton.before(form.appendChild(toggleElement));

  var toggleLabelElement = document.createElement("LABEL");
  var toggleLabelText = document.createTextNode("Select All/None");
  toggleLabelElement.setAttribute("for", day + "_" + "toggleTimeslots");
  toggleLabelElement.setAttribute("name", day + "_" + "toggleTimeslots");
  toggleLabelElement.setAttribute("style", "font-weight: bold;");
  toggleLabelElement.appendChild(toggleLabelText);
  submitButton.before(form.appendChild(toggleLabelElement));

  document.getElementById(day + "_" + 'toggleTimeslots').setAttribute('onclick', "toggle(this, 'timeslot[" + day + "')");
}




/*

writeCheckboxes

Adds the timeslot checkboxes

*/
function writeCheckboxes(form, selection, numberOfTimeslots, clock, day) {

  var submitButton = document.getElementById("submitBreak");

  //Get the time for checkbox
  var checkboxTime = clock.timeAsString();

  //Start with a br
  var brElement = document.createElement("br");
  brElement.setAttribute("name", "timeslot");
  submitButton.before(form.appendChild(brElement));

  //The checkbox
  var inputElement = document.createElement("input");
  inputElement.type = "checkbox";
  inputElement.name = "timeslot[" + day + "][]";
  inputElement.value = checkboxTime;
  inputElement.id = day + "_" + checkboxTime;
  submitButton.before(form.appendChild(inputElement));

  //The checkbox label
  var labelElement = document.createElement("LABEL");
  var labelText = document.createTextNode(checkboxTime);
  labelElement.setAttribute("for", day + "_" + checkboxTime);
  labelElement.setAttribute("name", "timeslot");
  labelElement.appendChild(labelText);
  submitButton.before(form.appendChild(labelElement));

  //Increment the clock by the timeslot duration
  clock.setMinutes(clock.getMinutes() + selection);

}


/*

editPage

For the edit page, this checks/ticks only those checked in db record

*/
function editPage() {
  //First days of the week...

  //Form checkboxes
  var daysCheckboxes = document.getElementsByName("days[]");

  for (var i = 0, n = daysCheckboxes.length; i < n; i++) {
    daysCheckboxes[i].checked = dbResultsDays.includes(daysCheckboxes[i].value);
  }

  //Now timeslots...

  //Is all day currently set in db?
  if (dbResultsTimes[0] == "All Day") {
    document.getElementById("daily").checked = true;
    allDay();
  } else {
    //Firstly, are different timeslots for each day set
    if (dbResultsTimes[0][0] != "week") {
      document.getElementById("radioYes").checked = true;

      showTimeslots();

      //Now get the checkboxes and check the relevent ones

      var timesCheckboxes;

      //Loop through the days marked in db, then for each day loop through checkboxes and mark them
      for (var i = 0, n = dbResultsDays.length; i < n; i++) {
        timesCheckboxes = document.getElementsByName('timeslot[' + dbResultsDays[i] + '][]');

        for (var j = 0, m = timesCheckboxes.length; j < m; j++) {
          timesCheckboxes[j].checked = dbResultsTimes[i][1].includes(timesCheckboxes[j].value);
        }
      }
    } else {
      //Next show the blank checkboxes
      showTimeslots();

      //Now get the checkboxes and check the relevent ones
      var timesCheckboxes = document.getElementsByName('timeslot[week][]');

      for (var i = 0, n = timesCheckboxes.length; i < n; i++) {
        timesCheckboxes[i].checked = dbResultsTimes[0][1].includes(timesCheckboxes[i].value);
      }
    }
  }
}


/*

dayCheck

This checks whether at least one day is selected

*/
function dayCheck() {
	if (document.querySelectorAll('input[name="days[]"][type=checkbox]:checked').length > 0) {
  	showTimeslots();
  } else {
  	alert("You must select at least one day before displaying timeslots");
    return;
  }
}


/*

submitCheck

This performs checks on the form then submits the form if ok or alerts users to errors

*/
function submitCheck() {
	if (document.querySelectorAll('input[name^="timeslot["][type=checkbox]:checked').length > 0) {
  	document.getElementById("form").submit();
  } else {
  	alert("You must select at least one timeslot before submitting");
  }
}
