<?php

/**
 * The main booking page
 *
 * This page is used by clients to make a booking.
 *
 */

 //Error reporting (Temporary during development)
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

 //Includes
 $includes = true;
 include_once __DIR__ . '/../open_db.php';
 include __DIR__ . '/../class/coord.php';

 //Create the coordinator
 $coord = new System\Coord($db);

 //Blank span for error/success message on form processing
 $span = "";

 //Get all locations
 $locationArray = $coord->getAllLocations();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Booking Time</title>

  <meta name="description" content="PHP, HTML5 and JavaScript flexible calendar booking system">
  <meta name="author" content="PineappleSoft">

  <link rel="stylesheet" href="../styles/main.css">
  <script src="newbooking.js"></script>

  <!-- for the calendar... -->
  <link rel="stylesheet" href="calendar.css">
  <script src="https://hammerjs.github.io/dist/hammer.js"></script>
  <script src="calendar.js"></script>

</head>

<body>
  <h1>Booking Time</h1>

  <ul class="breadcrumb">
    <li><a href="../">Home</a></li>
    <li><a href="index.php">Client Hub</a></li>
    <li>Make Booking</li>
  </ul>

  <h2>New booking</h2>

  <span id="message"></span>

  <!-- This is the form to select location and asset -->
  <form>
    <label for="locationsSelect">Choose a location:</label>
    <select id="locationsSelect" name="locationsSelect" onchange="updateAssetList()">
      <option>Please select a location</option>
      <?php
      foreach ($locationArray as $value) {
      ?>

      <option value="<?php echo $value->getID(); ?>"><?php echo $value->getName(); ?></option>

      <?php
      }
      ?>
    </select>

    <br>

    <label for="assetsSelect">Choose an asset:</label>
    <select id="assetsSelect" name="assetsSelect">
      <option>Please choose a location first</option>
    </select>
  </form>

  <div name="theCalendar">
    <div class="month">
      <ul>
        <li class="prev"><a onclick="displayCalendar('p')">&#10094;</a></li>
        <li class="next"><a onclick="displayCalendar('n')">&#10095;</a></li>
        <li><span id="monthText"></span><br><span id="yearText"></span>
        </li>
      </ul>
    </div>

    <ul class="weekdays">
      <li>Mo</li>
      <li>Tu</li>
      <li>We</li>
      <li>Th</li>
      <li>Fr</li>
      <li>Sa</li>
      <li>Su</li>
    </ul>

    <ul id="days" class="days" >

    </ul>
    <script type="text/javascript">
      displayCalendar("t");
    </script>
    <!-- Script to repsond to swipe: -->
    <script type="text/javascript">
      var element = document.getElementById('days');
      var hammertime = Hammer(element).on("swipeleft", function(event) {
        displayCalendar('n');
      });
      var hammertime = Hammer(element).on("swiperight", function(event) {
        displayCalendar('p');
      });
    </script>
  </div>

  <!-- Form to show timeslots (populated by js on calendar click) -->

  <form id="form" action="confirm_booking.php" method="post">
    <span id="submitBreak"></span>
    <input type="submit" name="submitButton" value="Submit">
  </form>


</body>
</html>
