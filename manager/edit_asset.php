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

//Blank span for reporting sucess/failure folliwing form processing
$span = "";

//If edit asset form is submitted..
if (isset($_POST['capacity'])) {
  $updatedAssetName = $_POST['assetName'];
  $updatedCapacity = $_POST['capacity'];
  $updatedTimeslotLength = $_POST['timeslotLength'];
  $updatedTimeslotStart = $_POST['timeslotStart'];

  //Set days of the week
  foreach ($_POST['days']  as $key => $value) {
    $updatedDays[$key] = $value;
  }

  //Set timeslots, or mark arr[0] as 'all day'
  if (isset($_POST['daily'])) {
    $updatedTimes[0] = "All Day";
  } else {
    foreach ($_POST['timeslot']  as $key => $value) {
      $updatedTimes[$key] = $value;
    }
  }

  $coord->editAsset($location, $asset, $updatedAssetName, $updatedCapacity, $updatedTimeslotLength, $updatedTimeslotStart, $updatedDays, $updatedTimes);

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

//Build a js string out of php array (apologies this is messy)
//This is for where timeslots differ by day.
function buildString($arr) {
  $string = "";
  foreach ($arr as $keya => $valuea) {
    $string .= "['";
    $string .= $keya;
    $string .= "', [";
    foreach ($valuea as $keyb => $valueb) {
      $string .= "'";
      $string .= $valueb;
      $string .= "', ";
    }
    $string = substr($string, 0, -2);
    $string .= "]], ";
  }
  $string = substr($string, 0, -2);
  //$string .= "";
  return $string;
}

//Now set the js string variable using the php array
$timesArr = $asset->getTimes();

//If all day is set use implode, else use the above builder function
if(isset($timesArr[0]) && $timesArr[0] == "All Day") {
  $timeString = "'" . implode ( "', '", $asset->getTimes() ) . "'";
} else {
  $timeString = buildString($asset->getTimes());
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
    var dbResultsTimes = [<?php echo $timeString;?>];
  </script>
  <script src="timeslots.js"></script>
</head>

<body>
  <h1>Booking Time - Edit Asset</h1>

  <ul class="breadcrumb">
    <li><a href="../">Home</a></li>
    <li><a href="index.php">Manager Hub</a></li>
    <li><a href="confirm_location_for_asset.php">Manage Assets</a></li>
    <li>Edit Asset</li>
  </ul>

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
    <p>Please give the asset a name:</p>
    <label for="assetName">Asset Name:</label>
    <input type="text" id="assetName" name="assetName" value="<?php echo $asset->getName(); ?>"><br>

    <hr>

    <p>How many concequtive bookings can take place at the same time:</p>
    <label for="capacity">Asset capacity:</label>
    <input type="number" id="capacity" name="capacity" value="<?php echo $asset->getCapacity(); ?>"><br>

    <hr>

    <p>What days of the week should this asset be available to book:</p>

    <fieldset>
      <legend>
        Days of the week
      </legend>

      <input type="hidden" id="assetID" name="assetID" value="<?php echo $asset->getID(); ?>">
      <input type="hidden" id="locationID" name="locationID" value="<?php echo $location->getID(); ?>">

      <br>

      <input type="checkbox" onClick="toggle(this, 'days[]')" id="toggleDays" checked>
      <label for="toggleDays"> <b>Select All/None</b></label><br>

      <input type="checkbox" id="monday" name="days[]" value="Monday">
      <label for="monday"> Monday</label><br>
      <input type="checkbox" id="tuesday" name="days[]" value="Tuesday">
      <label for="tuesday"> Tuesday</label><br>
      <input type="checkbox" id="wednesday" name="days[]" value="Wednesday">
      <label for="wednesday"> Wednesday</label><br>
      <input type="checkbox" id="thursday" name="days[]" value="Thursday">
      <label for="thursday"> Thursday</label><br>
      <input type="checkbox" id="friday" name="days[]" value="Friday">
      <label for="friday"> Friday</label><br>
      <input type="checkbox" id="saturday" name="days[]" value="Saturday">
      <label for="saturday"> Saturday</label><br>
      <input type="checkbox" id="sunday" name="days[]" value="Sunday">
      <label for="sunday"> Sunday</label><br>
    </fieldset>
    <br>

    <hr>

    <p>Will bookings be made per day or for a specific amount of time in a day:</p>

    <input type="checkbox" id="daily" name="daily" onChange="allDay()">
    <label for="daily">All day</label>

    <br>

    <p name="timeslotText">Or:</p>


    <label for="timeslotLength" id="timeslotLengthLabel">Length of each timeslot (in minutes):</label>
    <input type="number" id="timeslotLength" name="timeslotLength" min="1" max="1440" value="<?php echo $asset->getTimeslotLength(); ?>"><br>

    <label for="timeslotStart" id="timeslotStartLabel">Start timeslots at (minutes past the hour):</label>
    <input type="number" id="timeslotStart" name="timeslotStart" min="0" max="59" value="<?php echo $asset->getTimeslotStart(); ?>"><br>

    <p name="timeslotText">Will these timeslots differ throughout the week, on a day-by-day basis:</p>

    <fieldset>

      <legend name="timeslotText">
        Timeslots differ each day?
      </legend>

      <input type="radio" id="radioYes" name="radio">
      <label for="radioYes" id="radioYesLabel">Yes</label>

      <input type="radio" id="radioNo" name="radio" checked>
      <label for="radioNo" id="radioNoLabel">No</label>

    </fieldset>

    <br>

    <p name="timeslotText">Now click the 'Show Timelots' button to choose which times the asset should be available to book:</p>

    <input type="button" id="showTimeslotsButton" value="Show Timeslots"  onclick="dayCheck()"><br>

    <!-- Timeslots generated by JS will go here -->

    <hr id="submitBreak">

    <p>Click the 'Submit' button to save and create this asset</p>

    <input type="button" name="submitBtn" value="Submit"  onclick="submitCheck()">

  </form>

  <!-- As this is the edit page, the following will mark the appropriate
checkboxes using the function in timeslot.js-->
  <script>editPage();</script>
</body>
</html>
