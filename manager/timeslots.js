//Select all
function toggle(source, element) {
  var checkboxes = document.getElementsByName(element);
  for (var i = 0, n = checkboxes.length; i < n; i++) {
    checkboxes[i].checked = source.checked;
  }
}

//Returns the current time of the object as a string
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


//Removes any checkboxes generated by js from the form
function removeTimeslots() {

  //Find any element with the attribute: name="timeslot"
  var timeSlotElements = document.querySelectorAll('[name="timeslot"],[name="timeslot[]"],[name="toggleTimeslots"]');

  //Loop through and remove the element
  for (var i = 0; i < timeSlotElements.length; i++) {
    timeSlotElements[i].remove();
  }
}


//Mask timeslot selection when 'All Day' is checked
function allDay() {

  //First remove any checkboxes generated by js from the form
  removeTimeslots();

  //Disable the input and button
  if (document.getElementById("daily").checked) {
    document.getElementById("timeslotFrequency").disabled = true;
    document.getElementById("timeslotFrequencyLabel").setAttribute("style", "color: #ccc;");

    document.getElementById("timeslotStart").disabled = true;
    document.getElementById("timeslotStartLabel").setAttribute("style", "color: #ccc;");

    document.getElementById("showTimeslotsButton").disabled = true;
  } else {
    document.getElementById("timeslotFrequency").disabled = false;
    document.getElementById("timeslotFrequencyLabel").setAttribute("style", "color: black;");

    document.getElementById("timeslotStart").disabled = false;
    document.getElementById("timeslotStartLabel").setAttribute("style", "color: black;");

    document.getElementById("showTimeslotsButton").disabled = false;
  }

}

//Add checkboxes to form based on number selected
function showTimeslots() {

  //First remove any checkboxes generated by js from the form
  removeTimeslots();

  //The form
  var form = document.getElementById("form");
  var submitButton = document.getElementById("submitBreak");

  //Set the clock to zero
  var clock = new TimeString();
  clock.setHours(0, parseInt(document.getElementById("timeslotStart").value), 0);

  //Get text box value then calculate number of timeslots for the day
  var selection = parseInt(document.getElementById("timeslotFrequency").value);
  var numberOfTimeslots = 1440 / selection;

  //Add toggle
  var toggleElement = document.createElement("input");
  toggleElement.type = "checkbox";
  toggleElement.id = "toggleTimeslots";
  toggleElement.name = "toggleTimeslots";
  submitButton.before(form.appendChild(toggleElement));

  var toggleLabelElement = document.createElement("LABEL");
  var toggleLabelText = document.createTextNode("Select All/None");
  toggleLabelElement.setAttribute("for", "toggleTimeslots");
  toggleLabelElement.setAttribute("name", "toggleTimeslots");
  toggleLabelElement.setAttribute("style", "font-weight: bold;");
  toggleLabelElement.appendChild(toggleLabelText);
  submitButton.before(form.appendChild(toggleLabelElement));

  document.getElementById('toggleTimeslots').setAttribute('onclick', "toggle(this, 'timeslot[]')");

  //Add the checkboxes to the form
  for (i = 0; i < numberOfTimeslots; i++) {

    //Get the time for checkbox
    var checkboxTime = clock.timeAsString();

    //Start with a br
    var brElement = document.createElement("br");
    brElement.setAttribute("name", "timeslot");
    submitButton.before(form.appendChild(brElement));

    //The checkbox
    var inputElement = document.createElement("input");
    inputElement.type = "checkbox";
    inputElement.name = "timeslot[]";
    inputElement.value = checkboxTime;
    inputElement.id = checkboxTime;
    submitButton.before(form.appendChild(inputElement));

    //The checkbox label
    var labelElement = document.createElement("LABEL");
    var labelText = document.createTextNode(checkboxTime);
    labelElement.setAttribute("for", checkboxTime);
    labelElement.setAttribute("name", "timeslot");
    labelElement.appendChild(labelText);
    submitButton.before(form.appendChild(labelElement));

    //Increment the clock by the timeslot duration
    clock.setMinutes(clock.getMinutes() + selection);
  }

}

// For the edit page, this checks/ticks only those checked in db record
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
    //Firstly show the blank checkboxes
    showTimeslots();

    //Now get the checkboxes and check the relevent ones
    var timesCheckboxes = document.getElementsByName("timeslot[]");

    for (var i = 0, n = timesCheckboxes.length; i < n; i++) {
      timesCheckboxes[i].checked = dbResultsTimes.includes(timesCheckboxes[i].value);
    }
  }
}
