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
  public function editAsset($locationForAsset, $asset, $updatedAssetName, $updatedCapacity, $updatedTimeslotLength, $updatedTimeslotStart, $updatedDays, $updatedTimes)
  {
    $locationForAsset->editAsset($asset, $updatedAssetName, $updatedCapacity, $updatedTimeslotLength, $updatedTimeslotStart, $updatedDays, $updatedTimes);
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
  * Asks the asset object to add a new booking, retrieves row ID and creates,
  * then returns the booking object.
  *
  */
  public function newBooking($assetForBooking, $clientID)
  {
    $bookingID = $assetForBooking->newBooking($clientID);
    return new Booking($this->db, $bookingID, $assetForBooking->getID(), $clientID, "Live");
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
  * Get a booking
  *
  * Returns a single booking from a given booking ID
  *
  */
  public function getABooking($assetForBooking, $bookingID)
  {
    return $assetForBooking->getABooking($bookingID);
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
  * Create new timeslot
  *
  */
  public function newTimeslot($asset, $bookingObject, $dateObject)
  {
    $timeslotObject = new Timeslot($this->db, 0, $bookingObject->getID(), $dateObject, $asset->getTimeslotLength());

    if ($asset->checkTimeslotAvailability($timeslotObject)) {
      return $bookingObject->newTimeslot($timeslotObject);
    }

    return false;
  }

  /**
  * Get time slots
  *
  */
  public function getAvailableTimeSlots($assetForBooking, $aGivenDay)
  {
    return $assetForBooking->getAvailableTimeSlots($aGivenDay);
  }


  // Ownerships...


  /**
  * Get timeslot's booking object
  *
  */
  public function getTimeslotsBookingObject($asset, $aTimeslotObject)
  {
    return $this->getABooking($asset, $aTimeslotObject->getID());
  }




  public function toString()
  {
    return "A booking system coordination object";
  }
}
