<?php

/**
 * Initial setup
 *
 */

//Error reporting (Temporary during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes
$includes = true;

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
  <h1>Booking Time</h1>
  <p>Welcome to Booking Time</p>

  <h2>Initial setup</h2>
  <p>If you have just installed Booking Time and would like to run the initial
    setup please follow the link below. If you were not expecting to see this
    page then please read the next section.</p>

  <p><a href="setup/setup_1.php">Start initial setup</a></p>

  <h2>Not expecting to see this page?</h2>
  <p>You are seeing this page because the system cannot find the table 'setup'
    within a database file called 'Booking Time'. Please do not proceed and ask
    your administrator to troubleshoot this</p>
</body>
</html>
