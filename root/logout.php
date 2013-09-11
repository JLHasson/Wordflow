<?php
session_start();
// Force script errors and warnings to show on page in case php.ini file is set to not display them
error_reporting(E_ALL);
ini_set('display_errors', '0');
//-----------------------------------------------------------------------------------------------------------------------------------
// Unset all of the session variables
$_SESSION = array();
// If it's desired to kill the session, also delete the session cookie
if (isset($_COOKIE['idCookie'])) {
    setcookie("idCookie", '', time()-42000, '/');
	setcookie("passCookie", '', time()-42000, '/');
}
// Destroy the session variables
session_destroy();

header("location: welcome.php"); // << makes the script send them to any page we set


?>