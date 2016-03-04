<?php

/**
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */
namespace Laztopaz\PotatoORM\Test;

use Laztopaz\PotatoORM\DatabaseHandler;
use Laztopaz\PotatoORM\DatabaseHelper;
use Mockery;
use PHPUnit_Framework_TestCase;

class DatabaseConnectionTest extends PHPUnit_Framework_TestCase
{
    private $statement;
    private $dbConnMocked;
    private $dbHelper;
    private $dbHandler;

    public function setUp()
    {
        $this->dbConnMocked = Mockery::mock('\Laztopaz\PotatoORM\DatabaseConnection');

        $this->dbHelper = new DatabaseHelper($this->dbConnMocked);

        $this->dbHandler = new DatabaseHandler('gingers', $this->dbConnMocked);

        $this->statement = Mockery::mock('\PDOStatement');
    }

    /**
     * This method test if table is successfully created.
     *
     * @params void
     *
     * @return bool true
     */
    public function testCreateTable()
    {
        $this->dbConnMocked->shouldReceive('exec')->with('CREATE TABLE IF NOT EXISTS gingers( id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 100 ), gender VARCHAR( 10 ), alias VARCHAR( 150 ) NOT NULL, class VARCHAR( 150 ), stack VARCHAR( 50 ) )')->andReturn(true);

        $this->assertTrue($this->dbHelper->createTable('gingers', $this->dbConnMocked));
    }

    public function getTableFields()
    {
        $fieldName1 = ['Field' => 'id', 'Type' => 'int', 'NULL' => 'NO'];
        $fieldName2 = ['Field' => 'name', 'Type' => 'varchar', 'NULL' => 'NO'];
        $fieldName3 = ['Field' => 'gender', 'Type' => 'varchar', 'NULL' => 'YES'];

        $fieldName = [$fieldName1, $fieldName2, $fieldName3];

        $this->dbConnMocked->shouldReceive('prepare')->with('SHOW COLUMNS FROM gingers')->andReturn($this->statement);

        $this->statement->shouldReceive('bindValue')->with(':table', 'gingers', 2);
        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('fetchAll')->with(2)->andReturn($fieldName);

        return $fieldName;
    }

    /**
     * This method returns column fields from a table.
     *
     * @params void
     *
     * @return array $fieldNames
     */
    public function testGetColumnNames()
    {
        $fieldName = $this->getTableFields();

        $resultDataSet = $this->dbHandler->getColumnNames('gingers', $this->dbConnMocked);

        $this->assertEquals(['0' => $fieldName[0]['Field'], '1' => $fieldName[1]['Field'], '2' => $fieldName[2]['Field']], $resultDataSet);
    }

}
