<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\Test;

use PDO;
use \Mockery;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\DatabaseHelper;
use Laztopaz\potatoORM\DatabaseHandler;
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

		$this->dbHandler = new DatabaseHandler('users' ,$this->dbConnMocked);

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
		$id = 40;

		$this->dbConnMocked->shouldReceive('exec')->with('DELETE FROM gingers WHERE id = '.$id)->andReturn(true);

		$bool = DatabaseHandler::delete($id,'gingers',$this->dbConnMocked);

		$this->assertTrue($bool);
	}

	/**
	 * This method checks if a record is successfully committed to  a table
	 * @params void
	 * @return boolean true
	 */
	public  function testInsertData()
	{
		$insertQuery = "INSERT INTO gingers (name,alias,class,stack) VALUES ('Temitope Olotin','Laztopaz','14','php/laravel')";

		$this->dbConnMocked->shouldReceive('exec')->with($insertQuery)->andReturn(true);

		$boolInsert = $this->dbHandler->create(['name' => 'Temitope Olotin', 'alias' => 'Laztopaz', 'class' => '14', 'stack' => 'php/laravel'], 'gingers', $this->dbConnMocked);

		$this->assertTrue($boolInsert);
	}

	/**
	 * This method test that there are records to be retrieved from a table
	 * @params void
	 * @return boolean true
	 */
	public function testReadAll()
	{
		$id = false;

		$row1 = ['id' => 3, 'name' => 'Temitope Olotin', 'alias' => 'Laztopaz', 'class' => 14];
		$row2 = ['id' => 5, 'name' => 'Ogunde Kehinde', 'alias' => 'codekenn', 'class' => 13];
		$row3 = ['id' => 7, 'name' => 'Raimi Ademola', 'alias' => 'demo', 'class' => 14];

		$results = [$row1,$row2,$row3];

		$readQuery = $id  ? 'SELECT * FROM gingers WHERE id = '.$id : 'SELECT * FROM gingers';

		$this->dbConnMocked->shouldReceive('prepare')->with($readQuery)->andReturn($this->statement);

		$this->statement->shouldReceive('bindValue')->with(':table', 'gingers');

		$this->statement->shouldReceive('bindValue')->with(':id', $id);

		$this->statement->shouldReceive('execute');

		$this->statement->shouldReceive('fetchAll')->with(2)->andReturn($results);

		$allDataset = DatabaseHandler::read($id,'gingers',$this->dbConnMocked);

		$this->assertEquals($allDataset,['0'=>
			['id' => $row1['id'], 'name' => $row1['name'], 'alias' => $row1['alias'], 'class' => $row1['class']],
			['id' => $row2['id'], 'name' => $row2['name'], 'alias' => $row2['alias'], 'class' => $row2['class']],
			['id' => $row3['id'], 'name' => $row3['name'], 'alias' => $row3['alias'], 'class' => $row3['class']]
		     ]);
	}

	/**
	 * This method get a single record based on the row id supplied
	 * @params void
	 * @return boolean true
	 */
	public function testReadSingleRecord()
	{
		$id = 3;

		$row = ['id' => 3, 'name' => 'Olotin Temitope', 'alias' => 'laztopaz', 'class' => 14];

		$results = [$row];

		$readQuery = $id  ? 'SELECT * FROM gingers WHERE id = '.$id : 'SELECT * FROM gingers';

		$this->dbConnMocked->shouldReceive('prepare')->with($readQuery)->andReturn($this->statement);

		$this->statement->shouldReceive('bindValue')->with(':table', 'gingers');

		$this->statement->shouldReceive('bindValue')->with(':id', $id);

		$this->statement->shouldReceive('execute');

		$this->statement->shouldReceive('fetchAll')->with(2)->andReturn($results);

		$allDataset = DatabaseHandler::read($id,'gingers',$this->dbConnMocked);

		$this->assertEquals($allDataset,['0'=> ['id' => $row['id'], 'name' => $row['name'], 'alias' => $row['alias'],'class' => $row['class']]]);

	}

	/**
	 * This method if  record is successfully updated
	 * @params void
	 * @return boolean true
	 */
	/*public function testUpdateRecord()
	{
		$id = 3;

		$data = ['name' => 'Emmanuel Temitope', 'alias' => 'laztopaz', 'class' => 14, 'gender' => 'Female'];

		$updateQuery = "UPDATE `gingers` SET `name` = 'Olotin Emmanuel',`alias` = 'laztopaz',`gender` = 'Female' WHERE id = ".$id;

		$this->dbConnMocked->shouldReceive('prepare')->with($updateQuery)->andReturn($this->statement);

		$this->statement->shouldReceive('execute');

		$boolUpdate = $this->dbHandler->update(['id' => $id], 'gingers', $data, $this->dbConnMocked);

		$this->assertTrue(true);
	}*/

}