<?php

/**
 * Initial setup - step 3, setup complete.
 *
 */

//Error reporting (Temporary during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes
$includes = true;

//If form is submitted..
if (isset($_POST['submit']))
{
  //Set timetslot type to minutes
  $type = "minutes";

  //Set timeslot duration
  $timeslotDuration = $_POST['duration'];

  //Setup tables
  include_once __DIR__ . '/create_initial_tables.php';
  include_once __DIR__ . '/create_setup_table.php';
} else {
  echo "Error, please rerun setup";
  exit();
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

  <h1>Booking Time - Initial Setup Complete</h1>
  <p>Setup is now complete.</p>
  <p><a href="../index.php">Proceed to homepage</a></p>

</body>
</html>
