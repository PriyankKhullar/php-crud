<?php namespace Config;

class Connection
{
	protected $servername;
	protected $username;
	protected $password;
	protected $connection;
	
	public function __construct()
	{
		$this->servername = "localhost";
		$this->username = "root";
		$this->password = "";
		$this->connection = "";
	}
	/**
	 * 	Method of create database.
	 */
	public function createDatabase()
	{
		try {
			$this->connection = new \PDO("mysql:host=$this->servername", $this->username, $this->password);
			$this->connection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
			$sql = 'CREATE DATABASE IF NOT EXISTS mobirise';
			$this->connection->exec($sql);
			$sql = "use mobirise";
			$this->connection->exec($sql);
		}
		catch(\PDOException $e){
			echo $sql."<br>".$e->getMessage();
		}
		return $this->connection;
	}
}