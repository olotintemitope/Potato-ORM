<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Laztopaz\potatoORM\BaseClass;
use Laztopaz\potatoORM\DatabaseHandler;
use ReflectionClass;

class User extends BaseClassController {

	public $gender;          // Public variable that allows the user to set their gender during class instantiation
	public $alias;           // Public variable that allows the user to set their alias during class instantiation
	public $class;           // Public variable that allows the user to set their class during class instantiation
	public $stack;           // Public variable that allows the user to set their stack during class instantiation

	private $databaseModel;  // Private variable that contains instance of database

	private static $id;       // Id supplied by the user for updating table row record

	private $tableName;       // Class variable holding class name pluralized

	public function __construct()
	{
		$this->databaseModel = new DatabaseHandler();

		$this->tableName = strtolower(get_class($this)).'s';

		echo $this->tableName;
	}

	/**
	 * This method return user gender
	 * @params void
	 * @return string gender
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * This method return user alias
	 * @params void
	 * @return string alias
	 */
	public function getAlias()
	{
		return $this->alias;
	}

	/**
	 * This method return user class
	 * @params void
	 * @return string class
	 */
	public function getClass()
	{
		return $this->class;
	}

	/**
	 * This method return user stack
	 * @params void
	 * @return string stack
	 */
	public function getStack()
	{
		return $this->stack;
	}

	/**
	 * This method create or update record in a database table
	 * @params void
	 * @return boolean true or false;
	 */
	public function save()
	{
		$userSuppliedData = [
			strlen($this->getName())    == 0 ? "null" : $this->getName(),   // Set the value of name to null if user didn't see a value
			strlen($this->getGender())  == 0 ? "null" : $this->getGender(), // Set the value of gender to null if user didn't see a value
			strlen($this->getAlias())   == 0 ? "null" : $this->getAlias(),  // Set the value of alias to null if user didn't see a value
			strlen($this->getClass())   == 0 ? "null" : $this->getClass(),  // Set the value of class to null if user didn't see a value
			strlen($this->getStack())   == 0 ? "null" : $this->getStack()   // Set the value of stack to null if user didn't see a value

		];

		return $this->databaseModel->create($userSuppliedData, $this->tableName='users');
	}

	/**
	 * This method find a record by id
	 * @params int id
	 * @return int  rowid
	 */
	public static function find($id)
	{
		return new User();
	}

	/**
	 * This method delete a row from the table by the row id
	 * @params int id
	 * @return boolean true or false
	 */
	public static function destroy($id)
	{

	}

}