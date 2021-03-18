<?php

/**
 * Manager menu - Manage assets, confirming a location to work with
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

//Get all locations
$locationArray = $coord->getAllLocations();

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

  <ul class="breadcrumb">
    <li><a href="../">Home</a></li>
    <li><a href="index.php">Manager Hub</a></li>
    <li>Confirm Locations</li>
  </ul>

  <h2>Confirm location</h2>

  <p>Please choose a location to work with:</p>

  <form action="manage_asset.php" method="post">
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

    <br>

    <input type="submit" name="locationConfirmSubmit" value="Submit">
  </form>

</body>
</html>
