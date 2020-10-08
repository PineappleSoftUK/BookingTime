<?php
/**
 * A location that houses assets that can be booked.
 *
 */

namespace System;

class Location
{
  public $id;
  public $name;
  public $assets;

  public function __construct($id, $name)
  {
    $this->id = $id;
    $this->name = $name;
  }

  public function setID($id)
  {
    $this->id = $id;
  }

  public function getID()
  {
    return $this->id;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function toString()
  {
    return "Location name: " . $this->name;
  }
}
