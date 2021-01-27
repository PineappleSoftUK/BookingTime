<?php
/**
 * The booking system itself.
 *
 */

namespace System;

class BookingSystem
{
  public $db;
  public $timeSlotDuration;

  public function __construct($db)
  {
    //Set the database attribute
    $this->db = $db;

    //Set remaining attributes from settings table:
    $res = $this->db->query('SELECT * FROM settings');
    while ($row = $res->fetchArray()) {
      $this->timeSlotDuration = $row['timeSlotDuration'];
    }
  }

  /**
  * Setter for $timeSlotDuration
  *
  */
  public function setTimeSlotDuration($timeSlotDuration)
  {
    //Update db table
    $stmt = $this->db->prepare('UPDATE settings SET timeSlotDuration = :timeSlotDuration WHERE id = 1');
    $stmt->bindValue(':timeSlotDuration', $timeSlotDuration);
    $result = $stmt->execute();

    //Update object attribute
    $this->timeSlotDuration = $timeSlotDuration;
  }

  /**
  * Getter for $timeSlotDuration
  *
  */
  public function getTimeSlotDuration()
  {
    return $this->timeSlotDuration;
  }

  /**
  * New Location function.
  *
  * This adds a new location to the database.
  *
  */
  public function newLocation($locationName)
  {
    $stmt = $this->db->prepare('INSERT INTO locations (name) VALUES (:name)');
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
      $object = new Location($this->db, $row['id'], $row['name']);
      array_push($locationArray, $object);
    }
    return $locationArray;
  }

  /**
  * Delete location function.
  *
  * This takes a location id and removes it from the database.
  *
  */
  public function deleteLocation($locationToDelete)
  {
    $stmt = $this->db->prepare('DELETE FROM locations WHERE id = :id');
    $stmt->bindValue(':id', $locationToDelete->getID());
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
