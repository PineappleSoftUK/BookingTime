Notes:

TODO:
* Populate the form fields -- to include timeslot times/frequencies
* Process form

<?php

/**
 * Manager menu - Edit an asset
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

//Get single asset
if (isset($_POST['assetID'])) {
  $assetID = $_POST['assetID'];
  $locationID = $_POST['locationID'];
} else {
  $assetID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
  $locationID = filter_input(INPUT_GET, 'loc', FILTER_SANITIZE_SPECIAL_CHARS);
  if (!isset($assetID)||!isset($locationID)) {
    echo "Invalid ID, the ID passed in the URI does not exist in the system";
    exit();
  }
}

$location = $coord->getALocation($locationID);
$asset = $coord->getAnAsset($location, $assetID);

//Blank span
$span = "";

//If edit asset form is submitted..
if (isset($_POST['editSubmit'])) {
  $updatedAssetName = $_POST['assetName'];
  $updatedCapacity = $_POST['capacity'];
  $coord->editAsset($location, $asset, $updatedAssetName, $updatedCapacity);

  $span = "<p class='green'>Asset has been updated successfully</p>";

  $location = $coord->getALocation($locationID);
  $asset = $coord->getAnAsset($location, $assetID);
}

//If delete asset form is submitted..
if (isset($_POST['deleteSubmit'])) {
  $coord->deleteAsset($asset, $location);

  $span = "<p class='green'>Asset has been marked as deleted</p>";

  $location = $coord->getALocation($locationID);
  $asset = $coord->getAnAsset($location, $assetID);
}

//If restore asset form is submitted..
if (isset($_POST['restoreSubmit'])) {
  $coord->restoreAsset($asset, $location);

  $span = "<p class='green'>Asset has been marked as live</p>";

  $location = $coord->getALocation($locationID);
  $asset = $coord->getAnAsset($location, $assetID);
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

  <script>
    var dbResultsDays = [<?php echo "'" . implode ( "', '", $asset->getDays() ) . "'";?>];
    var dbResultsTimes = [<?php echo "'" . implode ( "', '", $asset->getTimes() ) . "'";?>];
  </script>
  <script src="timeslots.js"></script>
</head>

<body>
  <h1>Booking Time - Edit Asset</h1>

  <?php echo $span; ?>

  <h2>Delete/Restore</h2>

  <?php
  if ($asset->getStatus() == "Live") {
  ?>

    <p>The asset "<?php echo $asset->getName(); ?>" is currently marked as live.</p>

    <form action="edit_asset.php" method="post">

      <input type="radio" id="deleteRadio" name="deleteRadio" value="deleteRadio" checked>
      <label for="deleteRadio">Delete: <?php echo $asset->getName(); ?> </label><br>

      <input type="hidden" id="assetID" name="assetID" value="<?php echo $asset->getID(); ?>">
      <input type="hidden" id="locationID" name="locationID" value="<?php echo $location->getID(); ?>">

      <input type="submit" name="deleteSubmit" value="Delete">
    </form>

  <?php
  } else {
  ?>

  <p>The asset "<?php echo $asset->getName(); ?>" is currently marked as deleted.</p>

  <form action="edit_asset.php" method="post">

    <input type="radio" id="restoreRadio" name="restoreRadio" value="restoreRadio" checked>
    <label for="restoreRadio">Restore: <?php echo $asset->getName(); ?> </label><br>

    <input type="hidden" id="assetID" name="assetID" value="<?php echo $asset->getID(); ?>">
    <input type="hidden" id="locationID" name="locationID" value="<?php echo $location->getID(); ?>">

    <input type="submit" name="restoreSubmit" value="Restore">
  </form>

  <?php
  }
  ?>

  <h2>Edit</h2>

  <form id="form" action="edit_asset.php" method="post">
    <label for="assetName">Asset Name:</label>
    <input type="text" id="assetName" name="assetName" value="<?php echo $asset->getName(); ?>"><br>

    <label for="capacity">Asset capacity:</label>
    <input type="number" id="capacity" name="capacity" value="<?php echo $asset->getCapacity(); ?>"><br>

    <input type="hidden" id="assetID" name="assetID" value="<?php echo $asset->getID(); ?>">
    <input type="hidden" id="locationID" name="locationID" value="<?php echo $location->getID(); ?>">

    <br>

    <input type="checkbox" onClick="toggle(this, 'days[]')" id="toggleDays" checked>
    <label for="toggleDays"> <b>Select All/None</b></label><br>

    <input type="checkbox" id="monday" name="days[]" value="monday">
    <label for="monday"> Monday</label><br>
    <input type="checkbox" id="tuesday" name="days[]" value="tuesday">
    <label for="tuesday"> Tuesday</label><br>
    <input type="checkbox" id="wednesday" name="days[]" value="wednesday">
    <label for="wednesday"> Wednesday</label><br>
    <input type="checkbox" id="thursday" name="days[]" value="thursday">
    <label for="thursday"> Thursday</label><br>
    <input type="checkbox" id="friday" name="days[]" value="friday">
    <label for="friday"> Friday</label><br>
    <input type="checkbox" id="saturday" name="days[]" value="saturday">
    <label for="saturday"> Saturday</label><br>
    <input type="checkbox" id="sunday" name="days[]" value="sunday">
    <label for="sunday"> Sunday</label><br>

    <br>

    <input type="checkbox" id="daily" name="daily" onChange="allDay()">
    <label for="daily">All day</label>

    <br><br>

    <label for="timeslotFrequency" id="timeslotFrequencyLabel">Length of each timeslot (in minutes):</label>
    <input type="number" id="timeslotFrequency" min="1" max="1440" value="60"><br>

    <label for="timeslotStart" id="timeslotStartLabel">Start timeslots at (minutes past the hour):</label>
    <input type="number" id="timeslotStart" min="0" max="59" value="0"><br>

    <input type="button" id="showTimeslotsButton" value="Show Timeslots" onclick="showTimeslots()"><br>

    <!-- Timeslots generated by JS will go here -->

    <br id="submitBreak">
    <input type="submit" name="submit" value="Submit">

    <!--<input type="button" value="Test" onclick="editPage()"><br>-->
  </form>

  <!-- As this is  the edit page, the following will mark the appropriate
checkboxes using the function in timeslot.js-->
  <script>editPage();</script>
</body>
</html>
