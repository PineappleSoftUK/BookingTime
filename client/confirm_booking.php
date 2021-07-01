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
    <select id="assetsSelect" name="assetsSelect" onchange="#">
      <option value="">Please choose a location first</option>
    </select>
  </form>

  <!-- Implementation of timeslot follows, this is work in progress -->
  <?php
  $testLocation = $coord->getALocation(1);
  $testAsset = $coord->getAnAsset($testLocation, 2);
  $testDate = "01/01/2021";

  $arrayOfTimeslotObjects = $coord->getAvailableTimeSlots($testAsset, $testDate);
  ?>

  <form action="confirm_booking.php" method="post">
    <?php
    // Loop through the timeslots and add a radio, the value will be the timeslot id.
    foreach ($arrayOfTimeslotObjects as $value) {
    ?>
      <input type="radio" id="<?php echo $value->getTime();?>" name="timeslots" value="<?php echo $value->getTime();?>">
      <label for="<?php echo $value->getTime();?>"><?php echo $value->getTime();?></label><br>
    <?php }?>

    <input type="submit" name="Submit" value="Submit">
  </form>
  
</body>
</html>
