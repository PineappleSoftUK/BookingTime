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
  public $bookingID;
  public $date;
  public $time;
  public $duration;

  public function __construct($db, $id, $bookingID, $dateTime)
  {
    $this->db = $db;
    $this->id = $id;
    $this->bookingID = $bookingID;
    $this->time = $dateTime->format('H:i');
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
  * Setter for bookingID.
  *
  */
  public function setbookingID($bookingID)
  {
    $this->bookingID = $bookingID;
  }

  /**
  * Getter for bookingID.
  *
  */
  public function getbookingID()
  {
    return $this->bookingID;
  }

  /**
  * Getter for time
  *
  */
  public function getTime()
  {
    return $this->time;
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
