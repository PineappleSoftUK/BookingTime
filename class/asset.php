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
  public $timeslotLength;
  public $timeslotStart;
  public $days;
  public $times;
  public $status;

  public function __construct($db, $id, $name, $location, $capacity, $timeslotLength, $timeslotStart, $days, $times, $status)
  {
    $this->db = $db;
    $this->id = $id;
    $this->name = $name;
    $this->location = $location;
    $this->capacity = $capacity;
    $this->timeslotLength = $timeslotLength;
    $this->timeslotStart = $timeslotStart;
    $this->days = $days;
    $this->times = $times;
    $this->status = $status;
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
  * Getter for capacity.
  *
  */
  public function getCapacity()
  {
    return $this->capacity;
  }

  /**
  * Setter for timeslotLength.
  *
  */
  public function setTimeslotLength($timeslotLength)
  {
    $this->timeslotLength = $timeslotLength;
  }

  /**
  * Getter for timeslotLength.
  *
  */
  public function getTimeslotLength()
  {
    return $this->timeslotLength;
  }

  /**
  * Setter for timeslotStart.
  *
  */
  public function setTimeslotStart($timeslotStart)
  {
    $this->timeslotStart = $timeslotStart;
  }

  /**
  * Getter for timeslotStart.
  *
  */
  public function getTimeslotStart()
  {
    return $this->timeslotStart;
  }


  /**
  * Setter for days.
  *
  */
  public function setDays($days)
  {
    foreach ($days as $key => $value) {
      $this->days[$key] = $value;
    }
  }

  /**
  * Getter for days.
  *
  */
  public function getDays()
  {
    return $this->days;
  }

  /**
  * Setter for times.
  *
  */
  public function settimes($times)
  {
    foreach ($times as $key => $value) {
      $this->times[$key] = $value;
    }
  }

  /**
  * Getter for times.
  *
  */
  public function gettimes()
  {
    return $this->times;
  }

  /**
  * Setter for status.
  *
  */
  public function setStatus($status)
  {
    $this->status = $status;
  }

  /**
  * Getter for status.
  *
  */
  public function getStatus()
  {
    return $this->status;
  }

  /**
  * New booking
  *
  * Adds a new booking to the database
  *
  */
  public function newBooking()
  {
    $stmt = $this->db->prepare('INSERT INTO bookings (asset, status) VALUES (:asset, "Live")');
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
      $object = new booking($this->db, $row['id'], $row['asset'], $row['status']);
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
    $stmt = $this->db->prepare('UPDATE bookings SET status = "Deleted" WHERE id = :id');
    $stmt->bindValue(':id', $bookingToDelete->getID());
    $result = $stmt->execute();
  }

  /**
  * Restore booking function.
  *
  * This takes a booking id and marks its status as Live.
  *
  */
  public function restoreBooking($bookingToRestore)
  {
    $stmt = $this->db->prepare('UPDATE bookings SET status = "Live" WHERE id = :id');
    $stmt->bindValue(':id', $bookingToRestore->getID());
    $result = $stmt->execute();
  }

  /**
  * Get list of timeslots
  *
  * This returns a list of available time slots for a given day.
  *
  */
  public function getAvailableTimeSlots($aGivenDay)
  {
    $listOfTimeSlots = array();

    //Convert given Day to a DateTime object
    $dateObject = new DateTime($aGivenDay);

    //Get day of the week from date object (as lowercase text e.g "monday")
    $dayOfWeek = $dateObject->format('l');

    //Perform check on day of week against asset, if dissalowed return empty array.
    //Note: array search returns the key of result or false
    if (array_search($dayOfWeek, $this->getDays()) === FALSE) {
      return $listOfTimeSlots;
    }

    //Look up restricted days, i.e is this a bank holiday?
    // TODO

    //Get a list of current bookings and check timeslots against $capacity
    // TODO

    //Create the timeslots...

    $times = $this->getTimes();

    //Is it all day?
    if (array_key_exists(0, $times) && $times[0] == "All day") {
      $testing = "All day!";
      return $testing;
    }

    //Is it a week, i.e are the times the same on each day
    if (array_key_exists("week", $times)) {
      foreach ($times['week'] as $key => $value) {
        //Create new timeslot object: time = $value (needs exploding and the $value adding to dateobject)
        //and timeslot duration = $this->getTimeslotLength(). Add this timeslot object to the array for return

        $time = explode(":", $value);

        $dateObject->setTime($time[0], $time[1]);
        $object = new TimeSlot($this->db, 0, 0, $dateObject);
        array_push($listOfTimeSlots, $object);
      }
    } else {
      foreach ($times[$dayOfWeek] as $key => $value) {
        //Create new timeslot object: time = $value (needs exploding and the $value adding to dateobject)
        //and timeslot duration = $this->getTimeslotLength(). Add this timeslot object to the array for return

        $time = explode(":", $value);

        $dateObject->setTime($time[0], $time[1]);
        $object = new TimeSlot($this->db, 0, 0, $dateObject);
        array_push($listOfTimeSlots, $object);
      }
    }

    // TODO Alter timeslot object to include duration

    // TODO Timeslots on differing days

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
