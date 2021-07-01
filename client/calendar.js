var today = new Date();

function displayCalendar(action) {

  var daysInFeb = 28;
  var counter = 1;

  //Next button pressed
  if (action === "n") {
    today.setMonth(today.getMonth() + 1);
  }

  //Previous button pressed
  if (action === "p") {
    today.setMonth(today.getMonth() - 1);
  }

  var todayDayOfMonth = today.getDate(); //Day as digit
  var todayMonth = today.getMonth(); //Months as digit 0-11
  var todayYear = today.getFullYear(); //4-digit year

  //Are we looking at the current month?
  var thisMonth = false;
  var monthCheck = new Date();
  if (monthCheck.getMonth() === todayMonth && monthCheck.getFullYear() === todayYear) {
    thisMonth = true;
  }

  //Calculate days in feb for current year
  if ((todayYear % 100 !== 0) && (todayYear % 4 === 0) || (todayYear % 400 === 0)) {
    daysInFeb = 29;
  }

  //Days in each month this year
  var daysPerMonth = ["31", daysInFeb, "31", "30", "31", "30", "31", "31", "30", "31", "30", "31"];

  //Months as text
  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  //Write the titles
  document.getElementById("monthText").textContent = months[today.getMonth()];
  document.getElementById("yearText").textContent = today.getFullYear();

  //Clear the calendar days
  document.getElementById("days").innerHTML = "";

  //Populate the calendar
  //First how many blank days before writing the 1st
  var firstOfMonthObj = new Date(todayYear, todayMonth, 1);
  var firstOfMonth = firstOfMonthObj.getDay();
  var blankDays;
  if (firstOfMonth === 0) {
    blankDays = 6;
  } else {
    blankDays = firstOfMonth - 1;
  }

  //Next, how many calendar days?
  var numDaysThisMonth = daysPerMonth[todayMonth];

  //Now write the blanks at the begining:
  while (blankDays > 0) {
    var node = document.createElement("LI");
    var textnode = document.createTextNode("");
    node.appendChild(textnode);
    document.getElementById("days").appendChild(node);

    //Insert whitespace (to keep everything aligned)
    document.getElementById("days").appendChild(document.createTextNode("\u00A0"));

    blankDays--;
  }

  //Now write the days of the month:
  while (counter <= numDaysThisMonth) {
    var node = document.createElement("LI");

    //Mark today if appropriate
    if (counter === todayDayOfMonth && thisMonth) {
      node.className = "active";
    }

    //Write the 'onclick'
    node.setAttribute("onclick","calendarAction(" + counter + ")");

    //Add number text
    var textnode = document.createTextNode(counter);
    node.appendChild(textnode);

    //Add li to ul
    document.getElementById("days").appendChild(node);

    //Insert whitespace (to keep everything aligned)
    document.getElementById("days").appendChild(document.createTextNode("\u00A0"));

    counter++;
  }
}

//Below is the repsonse to the on click,
//current code below is more of a placeholder
function calendarAction(chosenDay) {
  var chosenMonth = today.getMonth() + 1;
  var chosenYear = today.getFullYear();
  alert(chosenDay + "-" + chosenMonth + "-" + chosenYear);
}
