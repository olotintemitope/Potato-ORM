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

	public function testSave()
	{
		$this->user->name    = "Temitope Emmanuel";
		$this->user->gender  = "Male";
		$this->user->alias   = "Laz";
		$this->user->class   = "21";
		$this->user->stack   = "Java/Android";

		$this->assertTrue($this->user->save());
	}

	public function testFind()
	{
		$user         = User::find(50);
		$user->name   = "Olotin Emmanuel";
		$user->alias  = "Laztopaz";

		$this->assertTrue($user->save());
	}

	public function testDestroy()
	{
		$boolResponse = User::destroy(46);
		$this->assertTrue($boolResponse);
	}

	public function testGetAll()
	{
		$arrayOfUserRecords = User::getAll();

		$this->assertGreaterThan(0,count($arrayOfUserRecords));
	}

	public function testResultIfReturnDataIsArray()
	{
		$boolResponse = $this->user->checkIfRecordIsEmpty(['id' => 1, 'name' => 'Olotin Temitope', 'alias' => 'Laztopaz']);
		$this->assertTrue($boolResponse);
	}

	public function testResultReturnIsEmptyArray()
	{
		$data = [];
		$boolResponse = $this->user->checkIfRecordIsEmpty($data);
		$this->assertFalse($boolResponse);
	}

	public function testCheckObjectRelatedMapping()
	{
		$expectedFields = $this->dbHelper->getColumnNames('users');

		$fieldsFromMagicSetter = ['id' => 1, 'name' => 'Temitope', 'class' => '14'];


	}

}