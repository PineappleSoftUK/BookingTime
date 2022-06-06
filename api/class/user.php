<?php
/**
 * User
 *
 * @author  PineappleSoft
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class User{

  // database connection and table name
  private $conn;
  private $table_name = "users";

  // object properties
  public $id;
  public $firstname;
  public $lastname;
  public $email;
  public $password;

  // constructor, $db as database connection
  public function __construct($db){
      $this->conn = $db;
  }

  /**
   * Create
   *
   * Insert a new item into database
   *
   * @return boolean
   */
  function create(){
    // query to insert record
    $query = <<<SQL
    INSERT INTO $this->table_name (firstname, lastname, email, password)
    VALUES (:firstname, :lastname, :email, :password)
    SQL;

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));

    // bind values
    $stmt->bindValue(":firstname", $this->firstname);
    $stmt->bindValue(":lastname", $this->lastname);
    $stmt->bindValue(":email", $this->email);

    //hash the password here then bind
    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    $stmt->bindValue(":password", $password_hash);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

  }

  /**
   * Email Exists
   *
   * A helper function that checks for duplicate email address in database
   *
   * @return boolean
   */
  function emailExists(){

    // query to check if email exists
    $query = <<<SQL
    SELECT id, firstname, lastname, password
    FROM $this->table_name
    WHERE email = :email
    LIMIT 0,1
    SQL;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
    $stmt->bindValue(':email', $this->email);

    $result = $stmt->execute();

    // get retrieved row
    $row = $result->fetchArray(SQLITE3_ASSOC);

    // check if records are returned
    if(!empty($row)){
      // set values to object properties
      $this->id = $row['id'];
      $this->firstname = $row['firstname'];
      $this->lastname = $row['lastname'];
      $this->password = $row['password'];

      // return true because email exists in the database
      return true;
    }
    // return false if email does not exist in the database
    return false;
  }


  /**
   * Update
   *
   * Updates item in database
   *
   * @return boolean
   */
  public function update(){

    // if password needs to be updated
    $password_set=!empty($this->password) ? ", password = :password" : "";

    // if no posted password, do not update the password
    $query = <<<SQL
    UPDATE $this->table_name
    SET
      firstname = :firstname,
      lastname = :lastname
      $password_set
    WHERE id = :id
    SQL;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));

    // bind new values
    $stmt->bindValue(':firstname', $this->firstname);
    $stmt->bindValue(':lastname', $this->lastname);

    // hash the password before saving to database
    if(!empty($this->password)){
        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindValue(':password', $password_hash);
    }

    // unique ID of record to be edited
    $stmt->bindValue(':id', $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }

    return false;
  }

  /**
   * Delete
   *
   * Deletes the selected item from database
   *
   * @return boolean
   */
  function delete(){

    // delete query
    $query = <<<SQL
    DELETE FROM $this->table_name
    WHERE id = :id
    SQL;

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind id of record to delete
    $stmt->bindValue(':id', $this->id);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;
  }

}
?>
