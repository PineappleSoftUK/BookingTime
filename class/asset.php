<?php
/**
 * An asset is an item that can be booked, it is linked
 * to one location.
 *
 */

namespace System;

class Asset
{
  public $id;
  public $name;
  public $location;
  public $capacity;

  public function __construct($id, $name, $location, $capacity)
  {
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
  * toString method.
  *
  */
  public function toString()
  {
    return "Asset ID: " . $this->id .  ", Asset name: " . $this->name . ", Asset Location: " . $this->location . ", Asset capacity: " . $this->capacity;
  }
}
