<?php

/**
 * This file is called by the js on the booking page and provides
 * responses from the system to populate the booking page.
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

/*
* Get all assets
*
*/
 $locationID = filter_input(INPUT_GET, 'loc', FILTER_SANITIZE_SPECIAL_CHARS);

 if (isset($locationID)) {

   $location = $coord->getALocation($locationID);
   $assetArray = $coord->getAllAssets($location);

   var_dump($assetArray);
 }
?>
