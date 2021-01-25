<?php

/**
 * Initial setup - step 2, choosing the timeslot duration if minutes was set,
 * otherwise setup complete.
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
  $selected = $_POST['timeslotChoice'];
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
  <?php
  if ($selected == "minutes") {
    //Parantheses remain open for html below...

  ?>
  <h1>Booking Time - Initial Setup, Step 2</h1>
  <p>Please choose how long you would like each timeslot to be. If you are unsure
    at this stage please leave the default. This figure can be changes later within 'settings'</p>

  <form action="setup_3.php" method="post">
    <label for="duration">Timeslot duration (between 1 and 1439):</label>
    <input type="number" id="duration" name="duration" min="1" max="1439" value="60"><br>

    <input type="submit" name="submit" value="Submit">
  </form>
  <?php
  } else {
  //Parantheses remain open for html below...

  ?>
  <h1>Booking Time - Initial Setup Complete</h1>
  <p>Setup is now complete.</p>
  <p><a href="../index.php">Proceed to homepage</a></p>
  <?php
  }

  ?>

</body>
</html>
