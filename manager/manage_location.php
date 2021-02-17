<?php

/**
 * Manager menu - Add a new location
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

//If new location form is submitted..
if (isset($_POST['submit'])) {
  $locationName = $_POST['locationName'];
  $coord->newLocation($locationName);
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
  <h1>Booking Time - Location Manager</h1>

  <h2>Add new location</h2>

  <form action="manage_location.php" method="post">
    <label for="newLocationName">Location Name:</label>
    <input type="text" id="newLocationName" name="newLocationName"><br>

    <input type="submit" name="submit" value="Submit">
  </form>

  <h2>Existing locations</h2>

  <table>
    <thead>
      <tr>
        <th>Location ID</th>
        <th>Location Name</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($locationArray as $value) {
        ?>

        <tr>
          <td><?php echo $value->getID(); ?></td>
          <td><?php echo $value->getName(); ?></td>
          <td><a href="edit_location.php?id=<?php echo $value->getID(); ?>">Edit/Delete</a></td>
        </tr>

      <?php
      }
      ?>
    </tbody>
  </table>

</body>
</html>
