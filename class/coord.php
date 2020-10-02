<?php
/**
 * A co-ordinator class that bridges the system
 * with the user interface.
 *
 */

namespace System;

//Includes
$includes = TRUE;
include __DIR__ . '/bookingsystem.php';
include_once __DIR__ . '/../open_db.php';

class Coord
{
  private $bookingSystem;

  function __construct()
  {
    $this->bookingSystem = new BookingSystem();
  }

  function toString()
  {
    return "A booking system coordination object";
  }
}
