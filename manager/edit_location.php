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
if (isset($_POST['locationID'])) {
  $locationID = $_POST['locationID'];
} else {
  $locationID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
  if (!isset($locationID)) {
    echo "Invalid ID, the ID passed in the URI does not exist in the system";
    exit();
  }
}

$location = $coord->getALocation($locationID);

//Blank span
$span = "";

//If edit location form is submitted..
if (isset($_POST['editSubmit'])) {
  $updatedLocationName = $_POST['locationName'];
  $coord->editLocation($location, $updatedLocationName);
  $span = "<p class='green'>Location has been updated successfully</p>";
  $location = $coord->getALocation($locationID);
}

//If delete location form is submitted..
if (isset($_POST['deleteSubmit'])) {
  $coord->deleteLocation($location);
  $span = "<p class='green'>Location has been marked as deleted</p>";
  $location = $coord->getALocation($locationID);
}

//If restore location form is submitted..
if (isset($_POST['restoreSubmit'])) {
  $coord->restoreLocation($location);
  $span = "<p class='green'>Location has been marked as live</p>";
  $location = $coord->getALocation($locationID);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Booking Time</title>

  <meta name="description" content="PHP, HTML5 and JavaScript flexible calendar booking system">
  <meta name="author" content="PineappleSoft">

  <link rel="stylesheet" href="../styles/main.css">

  <!--
    <script src="script.js"></script>
  -->
</head>

<body>
  <h1>Booking Time - Edit Location</h1>

  <ul class="breadcrumb">
    <li><a href="../">Home</a></li>
    <li><a href="index.php">Manager Hub</a></li>
    <li>Edit Loction</li>
  </ul>

  <?php echo $span; ?>

  <h2>Delete/Restore</h2>

  <?php
  if ($location->getStatus() == "Live") {
  ?>

    <p>The location "<?php echo $location->getName(); ?>" is currently marked as live.</p>

    <form action="edit_location.php" method="post">

      <input type="radio" id="deleteRadio" name="deleteRadio" value="deleteRadio" checked>
      <label for="deleteRadio">Delete: <?php echo $location->getName(); ?> </label><br>

      <input type="hidden" id="locationID" name="locationID" value="<?php echo $location->getID(); ?>">

      <input type="submit" name="deleteSubmit" value="Delete">
    </form>

  <?php
  } else {
  ?>

  <p>The location "<?php echo $location->getName(); ?>" is currently marked as deleted.</p>

  <form action="edit_location.php" method="post">

    <input type="radio" id="restoreRadio" name="restoreRadio" value="restoreRadio" checked>
    <label for="restoreRadio">Restore: <?php echo $location->getName(); ?> </label><br>

    <input type="hidden" id="locationID" name="locationID" value="<?php echo $location->getID(); ?>">

    <input type="submit" name="restoreSubmit" value="Restore">
  </form>

  <?php
  }
  ?>

  <h2>Edit</h2>

  <form action="edit_location.php" method="post">
    <label for="locationName">Location Name:</label>
    <input type="text" id="locationName" name="locationName" value="<?php echo $location->getName(); ?>"><br>

    <input type="hidden" id="locationID" name="locationID" value="<?php echo $location->getID(); ?>">

    <input type="submit" name="editSubmit" value="Submit">
  </form>

</body>
</html>
