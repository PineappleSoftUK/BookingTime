<?php
/**
 * Create initial tables
 *
 * This is used to set up the database on first use.
 *
 * @author  PineappleSoft
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Users table
$db->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, firstname TEXT, lastname TEXT, email TEXT, password TEXT, created TEXT, modified TEXT)');

//Locations table
$db->exec('CREATE TABLE IF NOT EXISTS locations (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, status TEXT, created TEXT, modified TEXT)');

//Assets table
$db->exec('CREATE TABLE IF NOT EXISTS assets (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, location INTEGER, capacity INTEGER, timeslots TEXT, status TEXT, created TEXT, modified TEXT)');

//Bookings table
$db->exec('CREATE TABLE IF NOT EXISTS bookings (id INTEGER PRIMARY KEY AUTOINCREMENT, asset INTEGER, client INTEGER, status TEXT, created TEXT, modified TEXT)');

//Timeslots table
$db->exec('CREATE TABLE IF NOT EXISTS timeslots (id INTEGER PRIMARY KEY AUTOINCREMENT, bookingID INTEGER, timeslotDate TEXT, timeslotTime TEXT, timeslotLength INTEGER, status TEXT, created TEXT, modified TEXT)');
?>
