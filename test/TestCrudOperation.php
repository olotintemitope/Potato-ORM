<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\Test;

require_once '../vendor/autoload.php';

use PDO;
use \Mockery;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\DatabaseHelper;
use Laztopaz\potatoORM\DatabaseConnection;

class TestCrudOperation extends PHPUnit_Framework_TestCase {

	private
		$setUpConnection,
		$statement,
        $dbConnMocked,
        $dbHelper;


	public function setUp()
	{
		$this->setUpConnection = new DatabaseConnection();

		$this->dbHelper = new DatabaseHelper($this->setUpConnection);

		$this->dbConnMocked = Mockery::mock('\Laztopaz\potatoORM\DatabaseConnection');

		$this->statement = Mockery::mock('\PDOStatement');
	}

	public function testCreateTable()
	{
		$dbConnMocked = Mockery::mock('\Laztopaz\potatoORM\DatabaseHelper');
		$dbConnMocked->shouldReceive('exec')->with("CREATE TABLE IF NOT EXISTS gingers( id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 100 ), gender VARCHAR( 10 ), alias VARCHAR( 150 ) NOT NULL, class VARCHAR( 150 ), stack VARCHAR( 50 ) )")->andReturn(true);

		$this->assertTrue($this->dbHelper->createTable('gingers', $dbConnMocked));

	}

	public function  testGetColumnNames()
	{
		$tableColumns = [
			'0' => 'id',
			'1' => 'name',
			'2' => 'gender',
			'3' => 'stack',
			'4' => 'alias',
			'5' => 'class'];

		$this->dbConnMocked->shouldReceive('prepare')->with("SHOW COLUMNS FROM gingers")->andReturn($this->statement);
		$this->statement->shouldReceive('bind')->with(':table', 'gingers', PDO::PARAM_STR);
		$this->statement->shouldReceive('execute');
		$this->statement->shouldReceive('fetch')->with(PDO::FETCH_ASSOC)->andReturn($tableColumns);

		$resultDataSet = $this->dbHelper->getColumnNames("gingers","NULL");

		$this->assertEquals($tableColumns,$resultDataSet);

	}


}