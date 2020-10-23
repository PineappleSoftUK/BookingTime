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
  * This creates a new location object and then passes to the bookingsystem
  * object so that it can add it to the database.
  *
  */
  public function newLocation($name)
  {
    //Create the location object
    $location = new Location($this->db, 0, $name);

    //Pass the object to the booking system to add to its records
    $this->bookingSystem->addLocation($location);
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
  */
  public function getALocation($locationID)
  {
    return $this->bookingSystem->getALocation($locationID);
  }

  /**
  * Delete a location
  *
  */
  public function deleteLocation($locationID)
  {
    $this->bookingSystem->deleteLocation($locationID);
  }

  // ASSETS...

  /**
  * New asset function.
  *
  * This creates a new asset object and then passes to the bookingsystem
  * object so that it can add it to the database.
  *
  */
  public function newAsset($name, $locationID, $capacity)
  {
    //Create the objects
    $asset = new Asset(0, $name, $locationID, $capacity);
    $location = $this->getALocation($locationID);

    //Pass the object to the location to add to its records
    $location->addAsset($asset);
  }

  public function toString()
  {
    return "A booking system coordination object";
  }
}
