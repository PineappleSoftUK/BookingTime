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
//Fetch all
$locationArray = $coord->getAllLocations();
