<?php

/**
 * Main system page
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Booking Time</title>

  <ul class="breadcrumb">
    <li>Home</li>
  </ul

  <meta name="description" content="PHP, HTML5 and JavaScript flexible calendar booking system">
  <meta name="author" content="PineappleSoft">

  <!--
  <link rel="stylesheet" href="style.css">

  <script src="script.js"></script>
  -->
</head>

<body>
  <h1>Booking Time</h1>

  <h2>Administrator</h2>
  <p><a href="settings/index.php">Update settings</a></p>

  <h2>Manager</h2>
  <p><a href="manager/index.php">Visit manager hub</a></p>

  <h2>Client</h2>
</body>
</html>
