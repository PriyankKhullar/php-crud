<?php namespace Config;

class DatabaseTable
{
	protected $connection;
	public function __construct()
	{
		$connectionObject = new Connection;
		$this->connection = $connectionObject->createDatabase();
	}
	/**
	 * 	Method of Create Database Table.
	 */
	function createTable()
	{
		// user table
		$sql = "CREATE TABLE IF NOT EXISTS user(
			id int(11) AUTO_INCREMENT PRIMARY KEY,
			user_name varchar(255),
			user_email varchar(255),
			user_password varchar(255),
			user_role varchar(255)
		)";
		$this->connection->exec($sql);

		// Blog_post table
		$sql = "CREATE TABLE IF NOT EXISTS post(
			id int(11) AUTO_INCREMENT PRIMARY KEY,
			post_title varchar(255),
			post_img varchar(255),
			post_description varchar(255),
			post_author varchar(255),
			category_id int(11),
			user_id int(11),
			posted_at timestamp default now()
		)";
		$this->connection->exec($sql);

		// post_likes table
		$sql = "CREATE TABLE IF NOT EXISTS 	post_likes(
			id int(11) AUTO_INCREMENT PRIMARY KEY,
			user_id int(11),
			post_id int(11)  
		)";
		$this->connection->exec($sql);

		// post_comments table.
		$sql = "CREATE TABLE IF NOT EXISTS post_comments(
			id int(11) AUTO_INCREMENT PRIMARY KEY,
			post_comment varchar(255),
			user_name varchar(255),
			post_id int(11),
			commented_at timestamp default now()
		)";
		$this->connection->exec($sql);

		// post_category table.
		$sql = "CREATE TABLE IF NOT EXISTS post_category(
			id int(11) AUTO_INCREMENT PRIMARY KEY,
			parent_id int(11),
			category varchar(255),
			display_order int(11)
		)";
		$this->connection->exec($sql);
	}
}