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

//Blank span
$span = "";

//If location is newly selected
if (isset($_POST['locationConfirmSubmit'])) {
$confirmedLocation = $_POST['locations'];
$selectedLocation = $coord->getALocation($confirmedLocation);
}

//If 'new' form is submitted..
if (isset($_POST['submit'])) {
  $assetName = $_POST['newAssetName'];

  $formLocation = $_POST['locationID'];
  $selectedLocation = $coord->getALocation($formLocation);

  $assetCapacity = $_POST['capacity'];

  foreach ($_POST['days']  as $key => $value) {
    $days[$key] = $value;
  }

  foreach ($_POST['times']  as $key => $value) {
    $times[$key] = $value;
  }

  $coord->newAsset($assetName, $selectedLocation, $assetCapacity, $days, $times);
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

  <!--
  <link rel="stylesheet" href="style.css">

  <script src="script.js"></script>
  -->
</head>

<body>
  <h1>Booking Time - Asset Manager</h1>

  <?php echo $span; ?>

  <p>You are working with location: "<?php echo $selectedLocation->getName(); ?>"</p>

  <h2>Add a new asset</h2>
  <form action="manage_asset.php" method="post">
    <label for="newAssetName">Asset Name:</label>
    <input type="text" id="newAssetName" name="newAssetName"><br>

    <label for="capacity">Asset capacity:</label>
    <input type="number" id="capacity" name="capacity" value="1">

    <input type="checkbox" id="monday" name="days[]" value="monday" checked>
    <label for="monday"> Monday</label><br>
    <input type="checkbox" id="tuesday" name="days[]" value="tuesday" checked>
    <label for="tuesday"> Tuesday</label><br>
    <input type="checkbox" id="wednesday" name="days[]" value="wednesday" checked>
    <label for="wednesday"> Wednesday</label><br>
    <input type="checkbox" id="thursday" name="days[]" value="thursday" checked>
    <label for="thursday"> Thursday</label><br>
    <input type="checkbox" id="friday" name="days[]" value="friday" checked>
    <label for="friday"> Friday</label><br>
    <input type="checkbox" id="saturday" name="days[]" value="saturday" checked>
    <label for="saturday"> Saturday</label><br>
    <input type="checkbox" id="sunday" name="days[]" value="sunday" checked>
    <label for="sunday"> Sunday</label><br>

    <br>

    <input type="checkbox" id="00" name="times[]" value="00" checked>
    <label for="00"> 00:00</label><br>

    <input type="hidden" id="locationID" name="locationID" value="<?php echo $selectedLocation->getID(); ?>">

    <input type="submit" name="submit" value="Submit">
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
