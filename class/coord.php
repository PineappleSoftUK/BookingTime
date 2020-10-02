<?php
/**
 * A co-ordinator class that bridges the system
 * with the user interface.
 *
 */

namespace System;
include __DIR__ . '/bookingsystem.php';

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
