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

  public function __construct($db, $id, $bookingID, $dateTime, $duration)
  {
    $this->db = $db;
    $this->id = $id;
    $this->bookingID = $bookingID;
    $this->date = $dateTime->format('Y-n-d'); //YYYY-MM-DD
    $this->time = $dateTime->format('H:i'); //HH:MM
    $this->duration = $duration;
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
  * Getter for date.
  * YYYY-MM-DD
  *
  */
  public function getDate()
  {
    return $this->date;
  }

  /**
  * Getter for time
  * HH:MM
  *
  */
  public function getTime()
  {
    return $this->time;
  }

  /**
  * Setter for duration.
  *
  */
  public function setDuration($duration)
  {
    $this->duration = $duration;
  }

  /**
  * Get duration
  *
  */
  public function getDuration()
  {
    return $this->duration;
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
