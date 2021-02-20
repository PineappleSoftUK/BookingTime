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

//If edit location form is submitted..
if (isset($_POST['editSubmit'])) {
  $updatedAssetName = $_POST['assetName'];
  $updatedCapacity = $_POST['capacity'];
  $coord->editAsset($location, $asset, $updatedAssetName, $updatedCapacity);

  $span = "<p class='green'>Asset has been updated successfully</p>";

  $location = $coord->getALocation($locationID);
  $asset = $coord->getAnAsset($location, $assetID);
}

//If delete location form is submitted..
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

  <!--
  <link rel="stylesheet" href="style.css">

  <script src="script.js"></script>
  -->
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

  <form action="edit_asset.php" method="post">
    <label for="assetName">Asset Name:</label>
    <input type="text" id="assetName" name="assetName" value="<?php echo $asset->getName(); ?>"><br>

    <label for="capacity">Asset capacity:</label>
    <input type="number" id="capacity" name="capacity" value="<?php echo $asset->getCapacity(); ?>"><br>

    <input type="hidden" id="assetID" name="assetID" value="<?php echo $asset->getID(); ?>">
    <input type="hidden" id="locationID" name="locationID" value="<?php echo $location->getID(); ?>">

    <input type="submit" name="editSubmit" value="Submit">
  </form>

</body>
</html>
