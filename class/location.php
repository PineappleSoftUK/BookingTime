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

  public function __construct($name)
  {
    $this->name = $name;
  }

  function setName($name)
  {
    $this->name = $name;
  }

  function getName()
  {
    return $this->name;
  }

  function toString()
  {
    return "Location name: " . $this->name;
  }
}
