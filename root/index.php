<?php
session_start();

include_once('mysql_server/connect_to_mysql.php');

if(isset($_SESSION['id'])) {

	header("location: home.php");
	
} else {

	header("location: welcome.php");
	
}

?>