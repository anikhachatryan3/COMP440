<?php 

// Starting the session
session_start();
// Unsetting/freeing all session variables
session_unset();
// Destroying the session
session_destroy();

// Sending the user back to the login page
header("Location: index.php");

?>