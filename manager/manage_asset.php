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
  <p><a href="new_asset.php?loc=<?php echo $selectedLocation->getID(); ?>">Click here to add a new asset</a></p>

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
