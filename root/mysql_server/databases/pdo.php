<?php

/**
 * PDO Database Class
 *
 *
 * License goes here
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Word of Mouth Inc.
 * @license 	Need license url
 */
 
 
class pdo_database {

	protected $db;
	
	protected $results;
		
	public function __construct()
	{
		try {
			
			$config = (object) config::get_instance()->get('pdo_database');
			
			$this->db = new pdo($config->dsn, $config->user, $config->pass);
			
			unset($config);
			
		} 
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	public function raw($sql)
	{
		try {
			$this->results = $this->db->query($sql);
			return $this;
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	public function query($sql, $params)
	{
		try {
		
			$this->results = $this->db->prepare($sql);
			
			$this->results->execute($params);
			
			return $this;
		
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	public function get()
	{
		return $this->results->fetchAll();
	}
	
	public function get_obj()
	{
		return $this->results->fetchObject();
	}
	

}