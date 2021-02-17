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

  // Settings...

  /**
  * Set time slot duration.
  *
  * This passes the time slot duration to the BookingSystem object
  *
  */
  public function setTimeSlotDuration($timeSlotDuration)
  {
    //Pass the object to the booking system to update its attribute
    $this->bookingSystem->setTimeSlotDuration($timeSlotDuration);
  }

  /**
  * Get time slot duration.
  *
  * This returns the time slot duration to the GUI
  *
  */
  public function getTimeSlotDuration()
  {
    //Pass the object to the booking system to update its attribute
    return $this->bookingSystem->getTimeSlotDuration();
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


  /**
  * Delete an asset
  *
  */
  public function deleteAsset($assetToDelete, $locationForAsset)
  {
    $locationForAsset->deleteAsset($assetToDelete);
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
