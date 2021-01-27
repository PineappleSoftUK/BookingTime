<?php

/**
 * Administrator menu - update settings.
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

//If form is submitted..
if (isset($_POST['submit']))
{
  //Set timeslot duration
  $timeSlotDuration = $_POST['duration'];

  $coord->setTimeSlotDuration($timeSlotDuration);
}

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
  <h1>Booking Time - Update Settings</h1>

  <form action="index.php" method="post">
    <label for="duration">Timeslot duration (between 1 and 1439):</label>
    <input type="number" id="duration" name="duration" min="1" max="1439" value="<?php echo $coord->getTimeSlotDuration(); ?>"><br>

    <input type="submit" name="submit" value="Submit">
  </form>
</body>
</html>
