<?php

/**
 * The confirm booking page
 *
 * This page checks and submits the data and confirms a valid booking.
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

 //Get the selected asset
 $assetID = $_POST['assetToSubmit'];
 $locationID = $_POST['locationToSubmit'];

 $location = $coord->getALocation($locationID);
 $asset = $coord->getAnAsset($location, $assetID);

 //Create a new booking
 $bookingObject = $coord->newBooking($asset);

 //Get date and time of TimeSlot
 $dateObject = new DateTime();

 $time = explode(":", $_POST['timeslotRadio']);
 $date = explode("/", $_POST['dateToSubmit']); // M/D/Y
 $dateObject->setTime($time[0], $time[1]);
 $dateObject->setDate($date[2], $date[0], $date[1]); // Y-M-D

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Booking Time</title>

  <meta name="description" content="PHP, HTML5 and JavaScript flexible calendar booking system">
  <meta name="author" content="PineappleSoft">

  <link rel="stylesheet" href="../styles/main.css">

</head>

<body>
  <h1>Booking Time</h1>

  <ul class="breadcrumb">
    <li><a href="../">Home</a></li>
    <li><a href="index.php">Client Hub</a></li>
    <li><a href="make_booking.php">Make Booking</a></li>
    <li>Confirm Booking</li>
  </ul>

  <h2>Confirm booking</h2>

  <span id="message"><?php echo $span; ?></span>

</body>
</html>
