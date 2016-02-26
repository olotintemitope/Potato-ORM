<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\Test;

require_once '../vendor/autoload.php';

use Laztopaz\potatoORM\DatabaseHandler;
use PDO;
use \Mockery;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\DatabaseHelper;
use Laztopaz\potatoORM\DatabaseConnection;

class TestDatabaseConnection extends PHPUnit_Framework_TestCase {

	private
		$setUpConnection,
		$statement,
        $dbConnMocked,
        $dbHelper,
        $dbHandler;

	public function setUp()
	{
		$this->setUpConnection = new DatabaseConnection();

		$this->dbHelper = new DatabaseHelper($this->setUpConnection->connect());

		$this->dbConnMocked = Mockery::mock('\Laztopaz\potatoORM\DatabaseConnection');

		$this->dbHandler = new DatabaseHandler('users');

		$this->statement = Mockery::mock('\PDOStatement');
	}

	/**
	 * This method test if table is successfully created
	 * @params void
	 * @return boolean true
	 */
	public function testCreateTable()
	{
		$dbConnMocked = Mockery::mock('\Laztopaz\potatoORM\DatabaseHelper');
		$dbConnMocked->shouldReceive('exec')->with("CREATE TABLE IF NOT EXISTS gingers( id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 100 ), gender VARCHAR( 10 ), alias VARCHAR( 150 ) NOT NULL, class VARCHAR( 150 ), stack VARCHAR( 50 ) )")->andReturn(true);

		$this->assertTrue($this->dbHelper->createTable('gingers', $dbConnMocked));

	}

	/**
	 * This method returns column fields from a table
	 * @params void
	 * @return array $fieldNames
	 */
	public function  testGetColumnNames()
	{
		$fieldName1 = ['Field' => 'id', 'Type' => 'int', 'NULL' => 'NO'];
		$fieldName2 = ['Field' => 'name', 'Type' => 'varchar', 'NULL' => 'NO'];
		$fieldName3 = ['Field' => 'gender', 'Type' => 'varchar', 'NULL' => 'YES'];
		$fieldName = [$fieldName1, $fieldName2, $fieldName3];

		$this->dbConnMocked->shouldReceive('prepare')->with("SHOW COLUMNS FROM gingers")->andReturn($this->statement);

		$this->statement->shouldReceive('bindValue')->with(':table', 'gingers', 2);
		$this->statement->shouldReceive('execute');
		$this->statement->shouldReceive('fetchAll')->with(2)->andReturn($fieldName);

		$resultDataSet = $this->dbHelper->getColumnNames("gingers", $this->dbConnMocked);

		$this->assertEquals(['0' => $fieldName1['Field'], '1' => $fieldName2['Field'], '2' => $fieldName3['Field']], $resultDataSet);
	}

	/**
	 * This method checks if a record is successfully deleted from a table
	 * @params void
	 * @return boolean true
	 */
	public function testDeleteRecord()
	{
		$this->dbConnMocked->shouldReceive('exec')->with('DELETE FROM gingers WHERE id = 2')->andReturn(true);

		$bool = DatabaseHandler::delete(2,'gingers',$this->dbConnMocked);

		$this->assertTrue($bool);
	}

	/**
	 * This method checks if a record is successfully committed to  a table
	 * @params void
	 * @return boolean true
	 */
	public  function testInsertData()
	{
		$insertQuery = "INSERT INTO users (name,alias,class,stack) VALUES ('Temitope Olotin','Laztopaz','14','php/laravel')";

		$this->dbConnMocked->shouldReceive('exec')->with($insertQuery)->andReturn(true);

		$boolInsert = $this->dbHandler->create(['name' => 'Temitope Olotin', 'alias' => 'Laztopaz', 'class' => '14', 'stack' => 'php/laravel'], 'users', $this->dbConnMocked);

		$this->assertTrue($boolInsert);

	}


}