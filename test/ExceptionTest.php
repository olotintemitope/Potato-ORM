<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\Test;

error_reporting(0);

use PDO;
use \Mockery;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\User;
use Laztopaz\potatoORM\EmptyArrayException;
use Laztopaz\potatoORM\NoArgumentPassedToFunctionException;
use Laztopaz\potatoORM\NoRecordDeletionException;
use Laztopaz\potatoORM\NoRecordFoundException;
use Laztopaz\potatoORM\NoRecordInsertionException;
use Laztopaz\potatoORM\NoRecordUpdateException;
use Laztopaz\potatoORM\NullArgumentPassedToFunction;
use Laztopaz\potatoORM\TableFieldUndefinedException;
use Laztopaz\potatoORM\Test\TestDatabaseConnection;
use Laztopaz\potatoORM\WrongArgumentException;
use Laztopaz\potatoORM\RecordExistsException;
use Laztopaz\potatoORM\DatabaseConnection;
use Laztopaz\potatoORM\DatabaseHandler;
use Laztopaz\potatoORM\DatabaseHelper;

class ExceptionTest extends PHPUnit_Framework_TestCase {

	private $user;
    private $dbHandler;
	private $dbConnMocked;
	private $dbHelper;
	private $statement;

	public function setUp()
	{
		$this->user = new User();

		$this->dbConnMocked = Mockery::mock('\Laztopaz\potatoORM\DatabaseConnection');

		$this->dbHelper  = new DatabaseHelper($this->dbConnMocked);

		//$this->dbHandler = new DatabaseHandler('gingers', $this->dbConnMocked);

		$this->statement = Mockery::mock('\PDOStatement');

	}

	/**
	 * @expectedException Laztopaz\potatoORM\NoArgumentPassedToFunctionException
	 */
	public function testNoArgumentPassedToFunctionException()
	{
		User::find();

	}

	/**
	 * @expectedException Laztopaz\potatoORM\NoArgumentPassedToFunctionException
	 */
	public function testNoArgumentForDestroy()
	{
		User::destroy();
	}

	/**
	 * @expectedException Laztopaz\potatoORM\NullArgumentPassedToFunction
	 */
	public function  testNullArgumentPassedToFunction()
	{
		$user = User::find("");
	}

	public function mockDelete()
	{
		$id = 1;

		$sql =  "DELETE FROM gingers WHERE id = ".$id;

		$this->dbConnMocked->shouldReceive('exec')->with($sql)->andReturn(true);

		$bool = DatabaseHandler::delete($id,'gingers',$this->dbConnMocked);

		$this->assertTrue($bool);

	}

	/**
	 * @expectedException Laztopaz\potatoORM\NoRecordDeletionException
	 */
	public function testNoRecordDeletedException()
	{
		$this->mockDelete();

		User::destroy(1);
	}

//	/**
//	 * @expectedException Laztopaz\potatoORM\EmptyArrayException;
//	 */
//	public function testEmptyArrayPassedToFindAndWhere()
//	{
//		$params = [];
//		$tableName = "users";
//
//		$this->dbHandler->findAndWhere($params,$tableName);
//	}


}