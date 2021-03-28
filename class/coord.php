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
include_once __DIR__ . '/booking.php';
include_once __DIR__ . '/timeslot.php';


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
  * Returns a location from a given location ID
  *
  */
  public function getALocation($locationID)
  {
    return $this->bookingSystem->getALocation($locationID);
  }

  /**
  * Edit a location
  *
  */
  public function editLocation($location, $updatedLocationName)
  {
    $this->bookingSystem->editLocation($location, $updatedLocationName);
  }

  /**
  * Delete a location
  *
  */
  public function deleteLocation($locationToDelete)
  {
    $this->bookingSystem->deleteLocation($locationToDelete);
  }

  /**
  * Restore a location
  *
  */
  public function restoreLocation($locationToRestore)
  {
    $this->bookingSystem->restoreLocation($locationToRestore);
  }

  // ASSETS...

  /**
  * New asset function.
  *
  * Asks the location object to add an asset
  *
  */
  public function newAsset($name, $locationForAsset, $capacity, $timeslotLength, $timeslotStart, $days, $times)
  {
    $locationForAsset->newAsset($name, $capacity, $timeslotLength, $timeslotStart, $days, $times);
  }

  /**
  * Get all assets
  *
  */
  public function getAllAssets($locationForAsset)
  {
    return $locationForAsset->getAllAssets();
  }

  /**
  * Get an asset
  *
  * Returns a single asset from a given asset ID
  *
  */
  public function getAnAsset($locationForAsset, $assetID)
  {
    return $locationForAsset->getAnAsset($assetID);
  }

  /**
  * Edit an asset
  *
  */
  public function editAsset($locationForAsset, $asset, $updatedAssetName, $updatedCapacity, $updatedTimeslotLength, $updatedTimeslotStart, $updatedDays, $updatedTime)
  {
    $locationForAsset->editAsset($asset, $updatedAssetName, $updatedCapacity, $updatedTimeslotLength, $updatedTimeslotStart, $updatedDays, $updatedTime);
  }


  /**
  * Delete an asset
  *
  */
  public function deleteAsset($assetToDelete, $locationForAsset)
  {
    $locationForAsset->deleteAsset($assetToDelete);
  }

  /**
  * Restore an asset
  *
  */
  public function restoreAsset($assetToDelete, $locationForAsset)
  {
    $locationForAsset->restoreAsset($assetToDelete);
  }

  // Bookings...

  /**
  * New booking function.
  *
  * Asks the asset object to add a new booking
  *
  */
  public function newBooking($assetForBooking)
  {
    $assetForBooking->newBooking();
  }

  /**
  * Get all bookings
  *
  */
  public function getAllbookings($assetForBooking)
  {
    return $assetForBooking->getAllbookings();
  }

  /**
  * Delete a booking
  *
  */
  public function deletebooking($bookingToDelete, $assetForBooking)
  {
    $assetForBooking->deletebooking($bookingToDelete);
  }

  // Time Slots...


  /**
  * Get time slots
  *
  */
  public function getListOfTimeSlots($assetForBooking, $aGivenDay)
  {
    $timeSlotDuration = $this->getTimeSlotDuration();
    return $assetForBooking->getListOfTimeSlots($aGivenDay, $timeSlotDuration);
  }


  public function toString()
  {
    return "A booking system coordination object";
  }
}
