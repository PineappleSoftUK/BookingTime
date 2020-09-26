<?php
/*
* The booking system itself.
*/
namespace System;

class BookingSystem
{
  //Object variables
  public $locations;

  /**
  * Get the value of /
  *
  * @return mixed
  */
  public function getLocations()
  {
    return $this->locations;
  }

  /**
  * Set the value of /
  *
  * @param mixed $locations
  *
  * @return self
  */
  public function setLocations($locations)
  {
    $this->locations = $locations;

    return $this;
  }
}
