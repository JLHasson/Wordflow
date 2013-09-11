<?php 
// Connecting to the Mysql Database
// Hostname
$db_host = "";
// Username
$db_username = ""; 
// Password
$db_pass = ""; // nothing1035357 // mike its not working because someone changed my password
// Name of Database
$db_name = "";

// Run the connection here 
mysql_connect("$db_host","$db_username","$db_pass") or die ("Could not connect to the database -- Connect to mysql page .php");
mysql_select_db("$db_name") or die ("no database");

// Eventually be replaced with $database = database::get_instance();

?>