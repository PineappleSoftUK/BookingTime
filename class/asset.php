<?php
/**
 * An asset is an item that can be booked, it is linked
 * to one location.
 *
 */

namespace System;

use DateTime;
use DateInterval;

class Asset
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
    $this->name = $name;
    $this->location = $location;
    $this->capacity = $capacity;
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
  * Setter for name.
  *
  */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
  * Getter for name.
  *
  */
  public function getName()
  {
    return $this->name;
  }

  /**
  * Setter for location.
  *
  */
  public function setLocation($location)
  {
    $this->location = $location;
  }

  /**
  * Getter for location.
  *
  */
  public function getLocation()
  {
    return $this->location;
  }

  /**
  * Setter for capacity.
  *
  */
  public function setCapacity($capacity)
  {
    $this->capacity = $capacity;
  }

  /**
  * Setter for capacity.
  *
  */
  public function getCapacity()
  {
    return $this->capacity;
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
  * Get list of timeslots
  *
  * This returns a list of available time slots for a given day.
  *
  */
  public function getListOfTimeSlots($aGivenDay, $timeSlotDuration)
  {
    $listOfTimeSlots = array();
    $timeSlotDurationObject = new DateInterval('PT' . $timeSlotDuration . 'M');
    $slotsInDay = 1440/$timeSlotDuration;

    //Convert date to a DateTime object
    $dateObject = new DateTime($aGivenDay);

    //Get day of the week (MON=1)
    $dayOfWeek = $dateObject->format('w');

    //Perform check on day of week, if dissalowed return empty array.
    // TODO

    //Look up restricted days, i.e is this a bank holiday?
    // TODO

    //Get a list of bookings and check timeslots against $capacity
    // TODO

    //Create the time slot objects
    $i = 1;
    while($i <= $slotsInDay) {
      //Create a new time slot object then add to list

      $object = new TimeSlot($this->db, 0, 0, $dateObject);
      array_push($listOfTimeSlots, $object);

      //Increase the date object by the time slot $timeSlotDuration
      $dateObject->add($timeSlotDurationObject);

      $i++;
    }

    return $listOfTimeSlots;

  }

  /**
  * toString method.
  *
  */
  public function toString()
  {
    return "Asset ID: " . $this->id .  ", Asset name: " . $this->name . ", Asset Location: " . $this->location . ", Asset capacity: " . $this->capacity;
  }
}
