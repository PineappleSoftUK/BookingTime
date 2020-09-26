<?php
/**
*
* A location that houses assets that can be booked.
*
*/
namespace System;

class BookingSystem
{
  //Object variables
  public $id;
  public $name;
  public $assets;

  /**
  * Get the value of Id
  *
  * @return mixed
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * Set the value of Id
  *
  * @param mixed $id
  *
  * @return self
  */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
  * Get the value of Name
  *
  * @return mixed
  */
  public function getName()
  {
    return $this->name;
  }

  /**
  * Set the value of Name
  *
  * @param mixed $name
  *
  * @return self
  */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
  * Get the value of Assets
  *
  * @return mixed
  */
  public function getAssets()
  {
    return $this->assets;
  }

  /**
  * Set the value of Assets
  *
  * @param mixed $assets
  *
  * @return self
  */
  public function setAssets($assets)
  {
    $this->assets = $assets;

    return $this;
  }
}
