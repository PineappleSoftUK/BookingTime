<?php

/**
 * A temporary index.php page to test function calls
 * during development
 *
 */

//Error reporting (Temporary during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes
$includes = true;
include_once __DIR__ . '/open_db.php';
include __DIR__ . '/class/coord.php';

//Create the coordinator
$coord = new System\Coord($db);

//Test function calls

//Locations
//New
$coord->newLocation("Test Location 1");
$coord->newLocation("Test Location 2");

//Get all locations
$locationArray = $coord->getAllLocations();
?>
<form action="/action_page.php">
  <label for="locations">Choose a location:</label>
  <select id="locations" name="locations">
    <?php
    foreach ($locationArray as $value) {
    ?>

    <option value="<?php echo $value->getID(); ?>"><?php echo $value->getName(); ?></option>

    <?php
    }
    ?>
  </select>
  <input type="submit">
</form>

<?php

//Delete a location
$locationToDelete = $locationArray[0];

$coord->deleteLocation($locationToDelete);

/*
//Get one location
echo "Here is the location name for ID=2: " . $coord->getALocation(2)->getName();
*/



//Assets
//New

//Location object
$locationForAsset = $locationArray[1];

$coord->newAsset("Test Asset 1", $locationForAsset, 10);
$coord->newAsset("Test Asset 2", $locationForAsset, 1);

//Get all assets
$locationForAsset = $locationArray[1];
$assetArray = $coord->getAllAssets($locationForAsset);
?>
<form action="/action_page.php">
  <label for="assets">Choose an asset:</label>
  <select id="assets" name="assets">
    <?php
    foreach ($assetArray as $value) {
    ?>

    <option value="<?php echo $value->getID(); ?>"><?php echo $value->getName(); ?></option>

    <?php
    }
    ?>
  </select>
  <input type="submit">
</form>

<?php

//Delete an asset
$assetToDelete = $assetArray[0];
$locationForAsset = $locationArray[1];

$coord->deleteAsset($assetToDelete, $locationForAsset);


//Booking
//New

//Asset object
$assetForBooking = $assetArray[1];

$coord->newBooking($assetForBooking);
$coord->newBooking($assetForBooking);

//Get all assets
$assetForBooking = $assetArray[1];
$bookingArray = $coord->getAllBookings($assetForBooking);
?>
<form action="/action_page.php">
  <label for="bookings">Choose an booking:</label>
  <select id="bookings" name="bookings">
    <?php
    foreach ($bookingArray as $value) {
    ?>

    <option value="<?php echo $value->getID(); ?>"><?php echo $value->getID(); ?></option>

    <?php
    }
    ?>
  </select>
  <input type="submit">
</form>

<?php

//Delete an booking
$bookingToDelete = $bookingArray[0];
$assetForBooking = $assetArray[1];

$coord->deletebooking($bookingToDelete, $assetForBooking);
