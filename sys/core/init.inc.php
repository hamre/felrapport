<?php
// Starts the session
session_start();
/*
 * Include the necessary configuration info
 */
include_once '../sys/config/db-cred.inc.php';

/*
 * Define constants for configuration info
 */
foreach ($C as $name => $val) {    
    define($name, $val);
}

$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
$current_file = end($current_file);

/*
 * Create a PDO object
 */
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
$dbo = new PDO($dsn, DB_USER, DB_PASS);

/*
 * Define the auto-load function for classes
 */
function __autoload($class) {
    $filename = "../sys/class/class." . strtolower($class) . ".inc.php";
    if(file_exists($filename)) {
        include_once $filename;
    }
}
/*
 * Check if the user is logged in and fetch user information
 */
$check = new user();

if($check->logged_in() === true) {
  $session_user_id = $_SESSION['user_id'];
  $user_data = $check->user_data($session_user_id, 'user_id', 'username', 'password', 'first_name', 'email', 'admin');
}
/*
 * Creates an error array that stores error info
 */
$errors = array();
?>