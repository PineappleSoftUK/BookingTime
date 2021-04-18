<?php

/**
 * Manager menu - Manage assets
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

//If location is newly selected
if (isset($_POST['locationConfirmSubmit'])) {
$confirmedLocation = $_POST['locations'];
$selectedLocation = $coord->getALocation($confirmedLocation);
}

//If 'new' form is submitted..
if (isset($_POST['capacity'])) {
  $assetName = $_POST['newAssetName'];

  $formLocation = $_POST['locationID'];//Get location ID
  $selectedLocation = $coord->getALocation($formLocation);//Retrieve this as object

  $assetCapacity = $_POST['capacity'];
  if (isset($_POST['daily'])) {
    $timeslotLength = 0;
    $timeslotStart = 0;
  } else {
    $timeslotLength = $_POST['timeslotLength'];
    $timeslotStart = $_POST['timeslotStart'];
  }

  //Set days of the week
  foreach ($_POST['days']  as $key => $value) {
    $days[$key] = $value;
  }

  //Set timeslots, or mark arr[0] as 'all day'
  if (isset($_POST['daily'])) {
    $times[0] = "All Day";
  } else {
    $timeslotsArr = $_POST['timeslot'];

    foreach ($timeslotsArr as $dayName => $dayArr) {
      foreach ($dayArr as $key => $value) {
        $times[$dayName][$key] = $value;
      }
    }
  }

  //Create the object
  $coord->newAsset($assetName, $selectedLocation, $assetCapacity, $timeslotLength, $timeslotStart, $days, $times);
  $span = "<p class='green'>Asset has been added successfully</p>";
}

//If page is navigated to directly
if (!isset($selectedLocation)) {
  echo "Error: No location has been selected, please return to the manager hub and choose 'Manage Assets'";
  exit();
}

//Get all assets
$assetArray = $coord->getAllAssets($selectedLocation);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Booking Time</title>

  <meta name="description" content="PHP, HTML5 and JavaScript flexible calendar booking system">
  <meta name="author" content="PineappleSoft">

  <link rel="stylesheet" href="../styles/main.css">

  <script src="timeslots.js"></script>
</head>

<body>
  <h1>Booking Time - Asset Manager</h1>

  <ul class="breadcrumb">
    <li><a href="../">Home</a></li>
    <li><a href="index.php">Manager Hub</a></li>
    <li>Manage Assets</li>
  </ul>

  <?php echo $span; ?>

  <p>You are working with location: "<?php echo $selectedLocation->getName(); ?>"</p>

  <h2>Add a new asset</h2>
  <form id="form" action="manage_asset.php" method="post">
    <p>Please give the asset a name:</p>
    <label for="newAssetName">Asset Name:</label>
    <input type="text" id="newAssetName" name="newAssetName"><br>

    <hr>

    <p>How many concequtive bookings can take place at the same time:</p>
    <label for="capacity">Asset capacity:</label>
    <input type="number" id="capacity" name="capacity" value="1" min="1" required><br>

    <hr>

    <p>What days of the week should this asset be available to book:</p>

    <fieldset>
      <legend>
        Days of the week
      </legend>

      <input type="checkbox" onClick="toggle(this, 'days[]')" id="toggleDays" checked>
      <label for="toggleDays"> <b>Select All/None</b></label><br>

      <input type="checkbox" id="monday" name="days[]" value="Monday" checked>
      <label for="monday"> Monday</label><br>
      <input type="checkbox" id="tuesday" name="days[]" value="Tuesday" checked>
      <label for="tuesday"> Tuesday</label><br>
      <input type="checkbox" id="wednesday" name="days[]" value="Wednesday" checked>
      <label for="wednesday"> Wednesday</label><br>
      <input type="checkbox" id="thursday" name="days[]" value="Thursday" checked>
      <label for="thursday"> Thursday</label><br>
      <input type="checkbox" id="friday" name="days[]" value="Friday" checked>
      <label for="friday"> Friday</label><br>
      <input type="checkbox" id="saturday" name="days[]" value="Saturday" checked>
      <label for="saturday"> Saturday</label><br>
      <input type="checkbox" id="sunday" name="days[]" value="Sunday" checked>
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
    <input type="number" id="timeslotLength" name="timeslotLength" min="1" max="1440" value="60" required><br>

    <label for="timeslotStart" id="timeslotStartLabel">Start timeslots at (minutes past the hour):</label>
    <input type="number" id="timeslotStart" name="timeslotStart" min="0" max="59" value="0" required><br>

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

    <input type="button" id="showTimeslotsButton" value="Show Timeslots" onclick="dayCheck()"><br>

    <!-- Timeslots generated by JS will go here -->

    <input type="hidden" id="locationID" name="locationID" value="<?php echo $selectedLocation->getID(); ?>">

    <hr id="submitBreak">

    <p>Click the 'Submit' button to save and create this asset</p>

    <input type="button" name="submitBtn" value="Submit" onclick="submitCheck()">
  </form>


  <h2>Existing assets</h2>

  <table>
    <thead>
      <tr>
        <th>Asset ID</th>
        <th>Asset Name</th>
        <th>Capacity</th>
        <th>Status</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($assetArray as $value) {
        ?>
        <tr>
          <td><?php echo $value->getID(); ?></td>
          <td><?php echo $value->getName(); ?></td>
          <td><?php echo $value->getCapacity(); ?></td>
          <td><?php echo $value->getStatus(); ?></td>
          <td><a href="edit_asset.php?id=<?php echo $value->getID(); ?>&loc=<?php echo $value->getLocation(); ?>">Edit/Delete</a></td>
        </tr>

      <?php
      }
      ?>
    </tbody>
  </table>

</body>
</html>
