<?php namespace App\Modules;
use \Config\Connection;

class Commands
{
	protected $connection;
	public function __construct()
	{
		$connectionObject = new Connection;
		$this->connection = $connectionObject->createDataBase();
	}
	/**
	 *  Insert Query
	 *	@param $table use for tabename.
	 *	@param $dbfield use for table fields in which data insert.
	 */
	function insert($table, $dbfield)
	{
		try{
			$key = array_keys( $dbfield);  
			$value = array_values( $dbfield);  
			$query ="INSERT INTO $table ( ". implode(',' , $key) .") VALUES('". implode("','" , $value) ."')";
			$this->connection->exec($query);
			return $query;
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  Select Query for fetch single data 
	 *	@param $table use for tabename 
	 *	@param $fields use for tabe fields which user want to select.
	 *	@param $where use for condition.
	 */
	function select($table, $fields = ['*'], $where = [])
	{
		try{
			$fieldsStr = implode(',', $fields);
			$whereBlock = implode(',', $where);
			$select_Data = $this->connection->prepare("SELECT $fieldsStr FROM $table WHERE $whereBlock");
			$select_Data->execute();
			$result = $select_Data->setFetchMode(\PDO::FETCH_ASSOC);
			return $select_Data->fetch();
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  Delete Query
	 *	@param $table use for tablename.
	 *	@param $where use for condition.
	 */
	function delete($table,  $where = [])
	{
		try{
			$whereBlock = implode(',', $where);
			$select_Data = $this->connection->prepare("DELETE  FROM $table WHERE $whereBlock");
			$select_Data->execute();
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
}