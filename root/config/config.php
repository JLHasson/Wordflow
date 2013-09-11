<?php


/*
 * Word of Mouth Config File
 *
 * Dont mix up this file that holds all of our config information with the config
 * class in the functions file.
 *
 * License here
 *
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Word Flow Inc
 * @license 	website license here
 *
 */

/**
 * Config Instance
 * 
 * (default value: config::get_instance())
 * 
 * @var mixed
 * @access public
 */
 
$config = config::get_instance();


/**
 * Facebook API Settings
 * 
 * @var mixed
 * @access public
 */
 
$config->set('facebook', array(

	'app_id' => '****************',
	
	'app_secret' => '*****************************',
	
	'url_redirect' => urlencode('http://word-flow.com/auth.php'),

));


/*
 * Word Flow Database Settings
 *
 */

/**
 * Database driver to use.
 * 
 * Based on what is inputted here determines which database driver we use throughtout our app.
 *
 * In our case we are using the mysqli driver right now.
 * 
 * @var mixed
 * @access public
 */
		 
$config->set('use_database', 'pdo'); // PDO currently not working..

$config->set('database_host', '***********');

$config->set('database_user', '*********************');

$config->set('database_pass', '**********');

$config->set('database_name', '**********');



/**
 * PDO Database Settings
 * 
 * @var mixed
 * @access public
 */
 
$config->set('pdo_database', array(
	
	// mysql:host=localhost;dbname=members
	
	'dsn' => 'mysql:host=' . $config->get('database_host') . ';dbname=' . $config->get('database_name'),
	'user' => $config->get('database_user'),
	'pass' => $config->get('database_pass'),

));


/**
 * MySQLi Database Settings
 * 
 * @var mixed
 * @access public
 */
$config->set('mysqli_database', array(
	
	'host' => $config->get('database_host'),
	
	'user' => $config->get('database_user'),
	
	'pass' => $config->get('database_pass'),
	
	'db'   => $config->get('database_name'),
	
));