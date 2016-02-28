<?php
/**
 * Created by PhpStorm.
 * User: andela
 * Date: 2/28/16
 * Time: 2:26 AM
 */

namespace Laztopaz\potatoORM\Test;

use \Mockery;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\DatabaseConnection;
use Laztopaz\potatoORM\DatabaseHandler;
use Laztopaz\potatoORM\DatabaseHelper;
use Laztopaz\potatoORM\EmptyArrayException;

class ExceptionTest extends PHPUnit_Framework_TestCase {

	private $dbConnMocked;
	private $dbHelper;
	private $dbHandler;

	public function setUp()
	{
		$this->dbConnMocked = Mockery::mock('\Laztopaz\potatoORM\DatabaseConnection');

		$this->dbHelper = new DatabaseHelper($this->dbConnMocked);

		$this->dbHandler = new DatabaseHandler("gingers", $this->dbConnMocked);

		$this->statement = Mockery::mock('\PDOStatement');
	}

	/**
	 * @expectedException Laztopaz\potatoORM\EmptyArrayException
	 */
	public function testEmptyArrayOnFindAndWhere()
	{
		$dbHandler = new DatabaseHandler("gingers", $this->dbConnMocked);

		$dbHandler->findAndWhere([], "gingers", $this->dbConnMocked);

	}

}