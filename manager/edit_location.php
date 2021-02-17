<?php

/**
 * Manager menu - Edit a location
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

//Get single location

//TODO IF Below....
$locationID = $_POST['locationID'];
$locationID = filter_input(INPUT_GET, 'locationID', FILTER_SANITIZE_SPECIAL_CHARS);

$location = $coord->getALocation($locationID);

//If new location form is submitted..
if (isset($_POST['submit'])) {
  $updatedLocationName = $_POST['locationName'];
  $coord->editLocation($location, $updatedLocationName);
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
  <h1>Booking Time - Edit Location</h1>

  <form action="edit_location.php" method="post">
    <label for="locationName">Location Name:</label>
    <input type="text" id="locationName" name="locationName"><br>

    <input type="submit" name="submit" value="Submit">
  </form>

</body>
</html>
