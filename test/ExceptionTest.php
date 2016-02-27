<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\Test;

error_reporting(0);

use Laztopaz\potatoORM\DatabaseHandler;
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

class ExceptionTest extends PHPUnit_Framework_TestCase {

	private $user;
    private $dbHandler;

	public function  setUp()
	{
		$this->user = new User();
		$this->dbHandler = new DatabaseHandler('users');
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
//
//	/**
//	 * @expectedException Laztopaz\potatoORM\NoRecordDeletionException
//	 */
//	public function testNoRecordDeletedException()
//	{
//		User::destroy(1);
//	}
//
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