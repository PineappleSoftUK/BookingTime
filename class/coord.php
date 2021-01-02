<?php
/**
 * A co-ordinator class that bridges the system
 * with the user interface.
 *
 */

namespace System;

//Includes
$includes = true;
include_once __DIR__ . '/bookingsystem.php';
include_once __DIR__ . '/location.php';
include_once __DIR__ . '/asset.php';


class Coord
{
  public $db;
  private $bookingSystem;

  public function __construct($db)
  {
    $this->db = $db;
    $this->bookingSystem = new BookingSystem($this->db);
  }

  // LOCATIONS...

  /**
  * New location function.
  *
  * This passes the location name to the BookingSystem object
  *
  */
  public function newLocation($name)
  {
    //Pass the object to the booking system to add to its records
    $this->bookingSystem->newLocation($name);
  }

  /**
  * Get all locations
  *
  */
  public function getAllLocations()
  {
    return $this->bookingSystem->getAllLocations();
  }

  /**
  * Get a location
  *
  * ##### For reference, consider deleting.
  *
  */
  /*
  public function getALocation($locationID)
  {
    return $this->bookingSystem->getALocation($locationID);
  }
  */

  /**
  * Delete a location
  *
  */
  public function deleteLocation($locationToDelete)
  {
    $this->bookingSystem->deleteLocation($locationToDelete);
  }

  // ASSETS...

  /**
  * New asset function.
  *
  * Asks the location object to add an asset
  *
  */
  public function newAsset($name, $locationForAsset, $capacity)
  {
    $locationForAsset->newAsset($name, $capacity);
  }

  /**
  * Get all assets
  *
  */
  public function getAllAssets($locationForAsset)
  {
    return $locationForAsset->getAllAssets();
  }


  public function toString()
  {
    return "A booking system coordination object";
  }
}
