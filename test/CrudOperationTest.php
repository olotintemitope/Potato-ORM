<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\Test;

//require_once '../vendor/autoload.php';

use Laztopaz\potatoORM\DatabaseConnection;
use Laztopaz\potatoORM\DatabaseHelper;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\User;

class TestCrudOperation extends PHPUnit_Framework_TestCase {

	private
		$user,
        $dbConn,
        $dbHelper;

	public function setUp()
	{
		$this->user = new User();

		$dbConn = new DatabaseConnection();
		$this->dbConn = $dbConn->connect();

		$this->dbHelper = new DatabaseHelper($this->dbConn);
	}


	/**
	 * This method test if a record is commited to a particular table
	 * @params void
	 * @return boolean true
	 */
	public function testSave()
	{
		$this->user->name    = "Temitope Emmanuel";
		$this->user->gender  = "Male";
		$this->user->alias   = "Laz";
		$this->user->class   = "21";
		$this->user->stack   = "Java/Android";

		$this->assertTrue($this->user->save());
	}

	/**
	 * This method test if a record is in a particular table and update it with a new if the record is found
	 * @params void
	 * @return boolean true
	 */
	public function testFind()
	{
		$user         = User::find(50);
		$user->name   = "Olotin Emmanuel";
		$user->alias  = "Laztopaz";

		$this->assertTrue($user->save());
	}

	/**
	 * This method test if a record is in a particular table and delete it if the record is found
	 * @params void
	 * @return boolean true
	 */
	public function testDestroy()
	{
		$boolResponse = User::destroy(46);
		$this->assertTrue($boolResponse);
	}

	/**
	 * This method gets all the records in a particular table
	 * @params void
	 * @return array $arrayOfUserRecords
	 */
	public function testGetAll()
	{
		$arrayOfUserRecords = User::getAll();

		$this->assertGreaterThan(0,count($arrayOfUserRecords));
	}

	/**
	 * This method checks if the data return is an array
	 * @params void
	 * @return boolean true
	 */
	public function testResultIfReturnDataIsArray()
	{
		$boolResponse = $this->user->checkIfRecordIsEmpty(['id' => 1, 'name' => 'Olotin Temitope', 'alias' => 'Laztopaz']);
		$this->assertTrue($boolResponse);
	}

	/**
	 * This method checks if the data return is an array and empty
	 * @params void
	 * @return boolean false
	 */
	public function testResultReturnIsEmptyArray()
	{
		$data = [];
		$boolResponse = $this->user->checkIfRecordIsEmpty($data);
		$this->assertFalse($boolResponse);
	}

	/**
	 * This method checks if the setter and getter matches the table fields
	 * @params void
	 * @return boolean true
	 */
	public function testCheckObjectRelatedMapping()
	{
		$expectedFields = $this->dbHelper->getColumnNames('users');

		$fieldsFromMagicSetter = ['0' => 'id', '1' => 'name', '2' => 'gender','3' => 'alias', '4' => 'class', '5' => 'stack'];

		$this->assertEquals($expectedFields,$fieldsFromMagicSetter);


	}

}