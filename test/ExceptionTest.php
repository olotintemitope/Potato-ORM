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
use Laztopaz\potatoORM\TableNotCreatedException;
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

		$this->statement = Mockery::mock('\PDOStatement');

	}

	/**
	 *
	 */
	public function testNoArgumentPassedToFunctionException()
	{
		$this->setExpectedException('Laztopaz\potatoORM\NoArgumentPassedToFunctionException');

		User::find();

	}

	/**
	 *
	 */
	public function testNoArgumentForDestroy()
	{
		$this->setExpectedException('Laztopaz\potatoORM\NoArgumentPassedToFunctionException');

		User::destroy();
	}

	/**
	 *
	 */
	public function  testNullArgumentPassedToFunction()
	{
		$this->setExpectedException('Laztopaz\potatoORM\NullArgumentPassedToFunction');

		$user = User::find("");
	}

	/**
	 *
	 */
	public function testNoRecordDeletedException()
	{
		$this->setExpectedException('Laztopaz\potatoORM\NoRecordDeletionException');

		User::destroy(1);
	}
	
}