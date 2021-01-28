<?php
/**
 * A timeslot is a segment of time that can be assigned to a booking.
 *
 */

namespace System;

class TimeSlot
{
  public $db;
  public $id;
  public $name;
  public $location;
  public $capacity;

  public function __construct($db, $id, $name, $location, $capacity)
  {
    $this->db = $db;
    $this->id = $id;
  }

  /**
  * Setter for id.
  *
  */
  public function setID($id)
  {
    $this->id = $id;
  }

  /**
  * Getter for id.
  *
  */
  public function getID()
  {
    return $this->id;
  }


  /**
  * New booking
  *
  * Adds a new booking to the database
  *
  */
  public function newBooking()
  {
    $stmt = $this->db->prepare('INSERT INTO bookings (asset) VALUES (:asset)');
    $stmt->bindValue(':asset', $this->id);
    $result = $stmt->execute();
  }

  /**
  * Get all bookings
  *
  * This returns an array of all booking objects linked this asset.
  *
  */
  public function getAllbookings()
  {
    $bookingArray = array();
    $stmt = $this->db->prepare('SELECT * FROM bookings WHERE asset = :asset');
    $stmt->bindValue(':asset', $this->id);
    $res = $stmt->execute();
    while ($row = $res->fetchArray()) {
      $object = new booking($this->db, $row['id'], $row['asset']);
      array_push($bookingArray, $object);
    }
    return $bookingArray;
  }

  /**
  * Delete booking function.
  *
  * This takes a booking object and removes it from the database.
  *
  */
  public function deletebooking($bookingToDelete)
  {
    $stmt = $this->db->prepare('DELETE FROM bookings WHERE id = :id');
    $stmt->bindValue(':id', $bookingToDelete->getID());
    $result = $stmt->execute();
  }

  /**
  * toString method.
  *
  */
  public function toString()
  {
    return "Time slot ID: " . $this->id;
  }
}
