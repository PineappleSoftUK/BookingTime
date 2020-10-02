<?php
/**
 * A co-ordinator class that bridges the system
 * with the user interface.
 *
 */

namespace System;

//Includes
$includes = TRUE;
include_once __DIR__ . '/bookingsystem.php';
include_once __DIR__ . '/location.php';


class Coord
{
  public $db;
  private $bookingSystem;

  function __construct($db)
  {
    $this->db = $db;
    $this->bookingSystem = new BookingSystem($this->db);
  }

  /**
  * New location function.
  *
  * This creates a new location object and then passes to the bookingsystem
  * object so that it can add it to the database.
  *
  */
  function newLocation($name)
  {
    //Create the location object
    $location = new Location($name);

    //Pass the object to the booking system to add to its records
    $this->bookingSystem->addLocation($location);
  }

  function toString()
  {
    return "A booking system coordination object";
  }
}
