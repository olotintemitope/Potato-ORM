<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use PDO;

class DatabaseHelper {

	public $dbConn;

	/**
	 * This is a constructor; a default method  that will be called automatically during class instantiation
	 */
	public function __construct($dbConnect)
	{
		$this->dbConn = $dbConnect;
	}

	/**
	 * This method creates a particular table
	 * @param tableName
	 * $return boolean true or false
	 */
	public function createTable($tableName, $conn = NULL)
	{
		try {

			if (is_null($conn)) {

				$conn = $this->dbConn;
			}

			$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(';

			$sql.= ' id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 100 ), gender VARCHAR( 10 ), alias VARCHAR( 150 ) NOT NULL, class VARCHAR( 150 ), stack VARCHAR( 50 ) )';

			return $conn->exec($sql);

		} catch (PDOException $e) {

			echo $e->getMessage();
		}
	}

	/**
	 * This method returns column fields of a particular table
	 * @param $table
	 * @return array
	 */
	public function getColumnNames($table, $conn = Null){

		$tableFields = array();

		try {

			if (is_null($conn)) {

				$conn = $this->dbConn;
			}

			$sql = "SHOW COLUMNS FROM ".$table;

			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':table', $table, PDO::PARAM_STR);
			$stmt->execute();

			while ($fieldName = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$tableFields[] = $fieldName['Field'];
			}
			return $tableFields;

		} catch (PDOException $e) {

			trigger_error('Could not connect to MySQL database. ' . $e->getMessage() , E_USER_ERROR);
		}
	}


}