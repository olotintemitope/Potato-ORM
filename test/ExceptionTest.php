<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\Test;

use \Mockery;
use Laztopaz\potatoORM\BaseClass;
use Laztopaz\potatoORM\User;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\DatabaseConnection;
use Laztopaz\potatoORM\DatabaseHandler;
use Laztopaz\potatoORM\DatabaseHelper;
use Laztopaz\potatoORM\EmptyArrayException;
use Laztopaz\potatoORM\TableFieldUndefinedException;
use Laztopaz\potatoORM\TableNotCreatedException;
use Laztopaz\potatoORM\NoRecordDeletionException;
use Laztopaz\potatoORM\NoRecordInsertionException;
use Laztopaz\potatoORM\NoRecordUpdateException;

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
    public function testFindAndWhere()
    {
        $id = 3;

        $sql =  "SELECT * FROM gingers WHERE `id` = '$id'";

        $this->dbConnMocked->shouldReceive('prepare')->with($sql)->andReturn($this->statement);
        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('rowCount')->andReturn(true);
        $this->dbHandler->findAndWhere([], "gingers", $this->dbConnMocked);
        
    }

    /**
     * @expectedException Laztopaz\potatoORM\TableFieldUndefinedException
     */
    public function testUpdateRecord()
    {
        $this->testings();
        $id = 1;
        $data = ['kiss' => 'Kola', 'gender' => 'Male'];
        $updateQuery = "UPDATE `gingers` SET `name` = 'Kola',`gender` = 'Male' WHERE id = ".$id;
        $this->dbConnMocked->shouldReceive('prepare')->with($updateQuery)->andReturn($this->statement);
        $this->statement->shouldReceive('execute')->andReturn(true);
        $this->dbHandler = new DatabaseHandler('gingers', $this->dbConnMocked);
        $this->dbHandler->update(['id' => $id], 'gingers', $data, $this->dbConnMocked);
    }


    /**
     * @expectedException Laztopaz\potatoORM\TableFieldUndefinedException
     */
    public  function testCreate()
    {
        $this->testings();
        $this->dbHandler = new DatabaseHandler('gingers', $this->dbConnMocked);
        $insertQuery = "INSERT INTO gingers (id,name,gender) VALUES ('1','Kola','Male')";
        $this->dbConnMocked->shouldReceive('exec')->with($insertQuery)->andReturn(true);
        $this->dbHandler->create(['id' => '1', 'kiss' => 'Kola', 'gender' => 'Male'], 'gingers', $this->dbConnMocked);
    }

    public function testings()
    {
        $fieldName1 = ['Field' => 'id', 'Type' => 'int', 'NULL' => 'NO'];
        $fieldName2 = ['Field' => 'name', 'Type' => 'varchar', 'NULL' => 'NO'];
        $fieldName3 = ['Field' => 'gender', 'Type' => 'varchar', 'NULL' => 'YES'];
        $fieldName = [$fieldName1, $fieldName2, $fieldName3];
        $this->dbConnMocked->shouldReceive('prepare')->with("SHOW COLUMNS FROM gingers")->andReturn($this->statement);
        $this->statement->shouldReceive('bindValue')->with(':table', 'gingers', 2);
        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('fetchAll')->with(2)->andReturn($fieldName);

        return $fieldName;
    }
}
