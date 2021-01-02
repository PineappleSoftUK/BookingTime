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
  <label for="locations">Choose a locations:</label>
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
$someID = 1;

$coord->deleteLocation($someID);

/*
//Get one location
echo "Here is the location name for ID=2: " . $coord->getALocation(2)->getName();




//Assets
//New
$coord->newAsset("Test Asset 1", 2, 10);
$coord->newAsset("Test Asset 2", 2, 1);
*/
?>
