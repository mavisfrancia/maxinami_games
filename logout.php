<?php
session_start();

//Unset session variables
$_SESSION = array();

//Destroy session
session_destroy();

//Send user back to main page.
header('Location: index.php');
?>