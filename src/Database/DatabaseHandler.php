<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use PDO;
use Laztopaz\potatoORM\DatabaseHelper;
use Laztopaz\potatoORM\TableFieldUndefinedException;

class DatabaseHandler  {

	private
		$tableFields,
		$dbHelperInstance,
        $dbConnection;

	/**
	 * This is a constructor; a default method  that will be called automatically during class instantiation
	 */
	public function __construct($modelClassName)
	{
		$dbConn = new DatabaseConnection();

		$this->dbConnection = $dbConn->connect();

		$this->dbHelperInstance = new DatabaseHelper($this->dbConnection);

		$this->tableFields = $this->dbHelperInstance->getColumnNames($modelClassName);
	}

	/**
	 * This method create a record and store it in a table row
	 * @params associative array, string tablename
	 * @return boolean true or false
	 */
	public function create($associative1DArray, $tableName)
	{
		$unexpectedFields = self::checkIfMagicSetterContainsIsSameAsClassModel($this->tableFields,$associative1DArray);

		if (count($unexpectedFields) > 0)
		{
			throw TableFieldUndefinedException::fieldsNotDefinedException($unexpectedFields,"needs to be created as table field");
		}

		unset($this->tableFields[0]);

		$insertQuery = 'INSERT INTO '.$tableName;

		$TableValues = implode(',',array_keys($associative1DArray));

		foreach ($associative1DArray as $field => $value) {

			$FormValues[] = "'".trim(addslashes($value))."'";
		}
		$splittedTableValues = implode(',', $FormValues);

		$insertQuery.= ' ('.$TableValues.')';

		$insertQuery.= ' VALUES ('.$splittedTableValues.')';

		$executeQuery = $this->dbConnection->exec($insertQuery);

		if (!$executeQuery) {

			return false;
		}
			return true;
	}

	/*
	 * This method updates any table by supplying 3 parameter
	 * @params: $updateParams, $tableName, $associative1DArray
	 * @return boolean true or false
	 *
	 */
	public function update(array $updateParams, $tableName, $associative1DArray)
	{
		$unexpectedFields = self::checkIfMagicSetterContainsIsSameAsClassModel($this->tableFields,$associative1DArray);

		if (count($unexpectedFields) > 0)
		{
			throw TableFieldUndefinedException::fieldsNotDefinedException($unexpectedFields,"needs to be created as table field");
		}

		unset($this->tableFields[0]);

		$counter = 0;

		$sql = "UPDATE `$tableName` SET ";

		foreach ($associative1DArray as $field => $value) {

			if ($counter == 0) {

				$sql = sprintf( $sql." %s = '%s' ", "`$field`" , get_magic_quotes_gpc() ? $value: addslashes($value));

				$counter++;

			} else {

				$sql = sprintf( $sql.", %s = '%s' ", "`$field`" ,get_magic_quotes_gpc() ? $value: addslashes($value));
			}
		} // end foreach
		foreach ($updateParams as $key => $val) {

			$sql = $sql." WHERE $key = $val";
		}
		$boolResponse = $this->dbConnection->exec($sql);

		if ($boolResponse) {

			return true;
		}
			return false;
	}

	/**
	 * This method retrieves record from a table
	 * @params int id, string tableName
	 * @return array
	 */
	public static function read($id, $tableName)
	{

		$tableData = array();

		if ($id) {

			$sql = 'SELECT * FROM '.$tableName.' WHERE id = '.$id;

		} else {

			$sql = 'SELECT * FROM '.$tableName;
		}

		try {

			$dhl = new DatabaseConnection();

			$stmt = $dhl->connect()->prepare($sql);

			$stmt->bindValue(':table', $tableName);
			$stmt->bindValue(':id', $id);
			$stmt->execute();

		} catch (PDOException $e) {

			return  $e->getMessage();
		}

		while($fieldValue = $stmt->fetch(PDO::FETCH_ASSOC)){

			$tableData[] = $fieldValue;
		}
		return $tableData;

	}


	/**
	 * This method deletes a record  from a table row
	 * @params int id, string tableName
	 * @return boolean true or false
	 */
	public static function delete($id,$tableName)
	{
		$dbhandle = new DatabaseConnection();

		$sql = 'DELETE FROM '.$tableName.' WHERE id = '.$id;

		$boolResponse = $dbhandle->connect()->exec($sql);

		if ($boolResponse) {

			return true;
		}
		return false;

	}

	/**
	 * This method checks if the magic setters array is the same as the table columns
	 * @param array $tableColumn
	 * @param array $userSetterArray
	 * @return array $unexpectedFields
	 */
	public static function checkIfMagicSetterContainsIsSameAsClassModel(array $tableColumn, array $userSetterArray)
	{
		$unexpectedFields = [];

		foreach ($userSetterArray as $key => $val)
		{
			if (!in_array($key,$tableColumn)) {

				$unexpectedFields[] = $key;
			}

		}

		return $unexpectedFields;

	}

}
