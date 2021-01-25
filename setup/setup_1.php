<?php

/**
 * Initial setup - step 1, choosing the timeslot type.
 *
 */

//Error reporting (Temporary during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes
$includes = true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Booking Time</title>

  <meta name="description" content="PHP, HTML5 and JavaScript flexible calendar booking system">
  <meta name="author" content="PineappleSoft">

  <!--
  <link rel="stylesheet" href="style.css">

  <script src="script.js"></script>
  -->
</head>

<body>
  <h1>Booking Time - Initial Setup, Step 1</h1>
  <p>Please select which type of timeslot you would like to use. <span class="red">Important -
    Once selected this cannot be changed unless the database file is deleted and this
    setup is re-run.</span></p>

  <p><b>Minutes</b> - Selecting 'minutes' will allow timeslots to be offered in a
    pre-defined block of minutes, for example you could choose 15 minute timeslots or
    perhaps hourly by choosing 60 minute timeslots. This figure can be changed at
    any time. One or a number of timeslots can be added to a booking should you require this.</p>

  <p><b>Days</b> - Selecting 'days' will make timeslots be in full days only. This is
    ideal for hotel reservations for example. One or a number of timeslots can be added
    to a booking should you require this.</p>

  <form action="setup_2.php" method="post">
    <input type="radio" id="minutes" name="timeslotChoice" value="minutes" checked>
    <label for="minutes">Minutes</label><br>

    <input type="radio" id="days" name="timeslotChoice" value="days">
    <label for="days">Days</label><br>

    <input type="submit" name="submit" value="Submit">
  </form>
</body>
</html>
