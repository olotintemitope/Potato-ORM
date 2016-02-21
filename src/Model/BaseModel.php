<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Laztopaz\potatoORM\DatabaseHandler;
use Laztopaz\potatoORM\InterfaceBaseClass;

class BaseClass implements InterfaceBaseClass
{
	protected $databaseModel;   // Private variable that contains instance of database

	protected $tableName;       // Class variable holding class name pluralized

	protected $properties = []; // Properties will later contain key, value pairs from the magic setter, getter methods

	use Inflector;              // Inject the inflector trait

	public function  __construct()
	{
		$this->tableName = $this->getClassName();

		$this->databaseModel = new DatabaseHandler($this->tableName);
	}

	/*
	 * The magic getter method
	 * @params key
	 * @return array key
	 */
	public function __get($key)
	{
		$this->properties[$key];

	}

	/*
	 * The magic setter method
	 * @params property, key
	 * @return array associative array properties
	 */
	public function  __set($property,$value)
	{
		$this->properties[$property] = $value;
	}

	/**
	 * This method gets all the record from a particular table
	 * @params void
	 * @return associative array
	 */
	public static function getAll()
	{
		$allData = DatabaseHandler::read($id = false, self::getClassName());

		return $allData;
	}

	/**
	 * This method create or update record in a database table
	 * @params void
	 * @return boolean true or false;
	 */
	public function save()
	{
		if ($this->properties['id']) {

			$allData = DatabaseHandler::read($id = $this->properties['id'], self::getClassName());

			if($this->checkIfRecordIsEmpty($allData))
			{
				return $this->databaseModel->update(['id' => $this->properties['id']], $this->tableName, $this->properties);
			}

			return false;
		}

		return $this->databaseModel->create($this->properties, $this->tableName);
	}

	/**
	 * This method find a record by id
	 * @params int id
	 * @return int  rowid
	 */
	public static function find($id)
	{
		$staticFindInstance = new static();

		$staticFindInstance->id = $id == "" ? false : $id;

		return $staticFindInstance;
	}

	/**
	 * This method delete a row from the table by the row id
	 * @params int id
	 * @return boolean true or false
	 */
	public static function destroy($id)
	{
		return DatabaseHandler::delete($id,self::getClassName());
	}

	/**
	 * This method return the current class name
	 * $params void
	 * @return string classname
	 */
	public static function getClassName()
	{
		$tableName = preg_split('/(?=[A-Z])/', get_called_class());

		$className = end($tableName);

		return self::pluralize(strtolower($className));
	}

	public function checkIfRecordIsEmpty($arrayOfRecord)
	{
		if (count($arrayOfRecord) > 0 ) {

			return true;
		}
		return false;
	}

}