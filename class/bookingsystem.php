<?php
/**
 * The booking system itself.
 *
 */

namespace System;

class BookingSystem
{
  public $db;

  public function __construct($db)
  {
    //Set the database attribute
    $this->db = $db;
  }

  /**
  * New Location function.
  *
  * This adds a new location to the database.
  *
  */
  public function newLocation($locationName)
  {
    $stmt = $this->db->prepare('INSERT INTO locations (name, status) VALUES (:name, "Live")');
    $stmt->bindValue(':name', $locationName);
    $result = $stmt->execute();
  }

  /**
  * Get all locations
  *
  * This returns an array of all location objects.
  *
  */
  public function getAllLocations()
  {
    $locationArray = array();
    $res = $this->db->query('SELECT * FROM locations');
    while ($row = $res->fetchArray()) {
      $object = new Location($this->db, $row['id'], $row['name'], $row['status']);
      array_push($locationArray, $object);
    }
    return $locationArray;
  }

  /**
  * Get a location
  *
  * This returns one location based on id provided.
  *
  */
 public function getALocation($locationID)
 {
   $stmt = $this->db->prepare('SELECT * FROM locations WHERE id = :id');
   $stmt->bindValue(':id', $locationID);
   $result = $stmt->execute();
   $array = $result->fetchArray();
   $location = new Location($this->db, $array['id'], $array['name'], $array['status']);
   return $location;
 }

 /**
 * Edit location function.
 *
 * Updated the atributes of a location.
 *
 */
 public function editLocation($location, $updatedLocationName)
 {
   $stmt = $this->db->prepare('UPDATE locations SET name = :name WHERE id = :id');
   $stmt->bindValue(':name', $updatedLocationName);
   $stmt->bindValue(':id', $location->getID());
   $result = $stmt->execute();
 }

  /**
  * Delete location function.
  *
  * This takes a location id and marks its status as Deleted.
  *
  */
  public function deleteLocation($locationToDelete)
  {
    $stmt = $this->db->prepare('UPDATE locations SET status = "Deleted" WHERE id = :id');
    $stmt->bindValue(':id', $locationToDelete->getID());
    $result = $stmt->execute();
  }

  /**
  * Restore location function.
  *
  * This takes a location id and marks its status as Live.
  *
  */
  public function restoreLocation($locationToRestore)
  {
    $stmt = $this->db->prepare('UPDATE locations SET status = "Live" WHERE id = :id');
    $stmt->bindValue(':id', $locationToRestore->getID());
    $result = $stmt->execute();
  }

  /**
  * toString method.
  *
  */
  public function toString()
  {
    return "Time Slot Duration: " . $this->timeSlotDuration;
  }
}
